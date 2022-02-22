<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use App\time;
use App\class_stud_list;
use App\grading;
use App\exam;
use App\exam_q;
use App\exam_q_mcq;
use App\exam_sub_ans;
use App\time_adjustment;
use App\exam_submission;
use App\submission;
use App\users;
use App\assign_file;
use App\assignment;

class LecturerController extends Controller
{
    //
    public function getClasses(){
        $user = Auth::user();

        $classes = DB::select('select * from class left join faculty on class.facultyID = faculty.id where teacherID = :id', ['id' => $user->idCode]);

        return view('lecturer/component/getClassesCard', ['classes' => $classes]);
    }

    public function getExamDetail($id){
        $examID = $id;
        $examDetail = DB::select("select * from exam left join grading on exam.gradingID = grading.gradingID where examID = :examID", ['examID' => $examID]);
        return view('lecturer/component/getExamDetail', ['examDetail' => $examDetail[0]]);
    }

    public function getAssignDetail($id){
        $assignmentID = $id;
        $assignDetail = assignment::leftJoin('grading', 'assignment.gradingID', '=', 'grading.gradingID')
                                        ->where('assignment.assignmentID', '=', $assignmentID)
                                        ->get();

        return view('lecturer/component/getAssignDetail', ['assignDetail' => $assignDetail[0]]);
    }

    public function classPage($id){
        $classID = $id;
        $classDetail = DB::select('select * from class where classID = :classID', ['classID' => $classID]);

        return view('lecturer/classPage', ['classDetail' => $classDetail[0]]);
    }

    public function setup_timeSch($id){
        $classID = $id;
        $classDetail = DB::select('select * from time where classID = :classID', ['classID' => $classID]);
        $className = DB::select('select className from class where classID = :classID', ['classID' => $classID]);
        error_log($className[0]->className);

        $monday = DB::table('time')->where('classID', $classID)->where('Day', 'monday')->get();
        $tuesday = DB::table('time')->where('classID', $classID)->where('Day', 'tuesday')->get();
        $wednesday = DB::table('time')->where('classID', $classID)->where('Day', 'wednesday')->get();
        $thursday = DB::table('time')->where('classID', $classID)->where('Day', 'thursday')->get();
        $friday = DB::table('time')->where('classID', $classID)->where('Day', 'friday')->get();

        $timeSet = array($monday, $tuesday, $wednesday, $thursday, $friday);

        return view('lecturer/component/timeSch', ['timeSet' => $timeSet, 'className' => $className[0]]);
    }

    public function checkStudID($id, $classID){
        //0 = exist student but not enroll in the class yet
        //1 = no exist student
        //2 = exist student but already enroll in the class
        $returnStatus = 0;
        $student = DB::select('select idCode, name, batch from users where idCode = :idCode', ['idCode' => $id]);
        $classEnrollStudnt = DB::select('select * from class_stud_list where studentID = :studentID and classID = :classID', ['studentID' => $id, 'classID' => $classID]);

        if(count($student) <= 0){
            $returnStatus = 1;
        }else{
            if(count($classEnrollStudnt) > 0){
                $returnStatus = 2;
            }
        }
        return $returnStatus;
    }

    public function enrollStudent($id, $classID){
        error_log("test");
        $addStud = new class_stud_list();
        $addStud->classID = $classID;
        $addStud->studentID = $id;

        $addStud->save();


    }

    public function removeEnrollStud(Request $request){
        $studID = request('studentID');
        $classID = request('classID');

        $deleteOrig = class_stud_list::where('studentID', $studID)->where('classID', $classID)->delete();
        error_log('delete done');
    }

    public function getPieString($id){
        $grading = DB::select('select * from grading where classID = :classID', ['classID' => $id]);

        return $grading;
    }

    public function addGradingSch(Request $request){
        $grading = new grading();
        $grading->classID = request('classID');
        $grading->gradingType = request('gradName');
        $grading->gradingPercentage = request('gradMark');

        $grading->save();
    }

    public function removeGradString($id, $gradingID){
        $deleteGrading = grading::where('classID', $id)->where('gradingID', $gradingID)->delete();
    }

    public function getClassesCard($id){
        $examCards = DB::select('select exam.examID, exam.examName, exam.date, exam.startTime, exam.endTime, COALESCE(count(exam_submission.examSubID), 0) as subCount from exam left join exam_submission on exam.examID = exam_submission.examID where classID = :classID group by exam.examID', ['classID' => $id]);
        $studAmount = DB::select('select count(*) as studNumb from class_stud_list where classID = :classID', ['classID' => $id]);

        return view('lecturer/component/getExamCard', ['examCards' => $examCards, 'studAmount' => $studAmount[0]]);
    }

    public function getAssignCard($id){
        $assignCards = DB::select('select assignment.assignmentID, assignment.assignName, assignment.assignDate, assignment.endTime, COALESCE(count(submission.submissionID), 0) as subCount from assignment left join submission on assignment.assignmentID = submission.assignmentID where classID = :classID group by assignment.assignmentID', ['classID' => $id]);
        $studAmount = DB::select('select count(*) as studNumb from class_stud_list where classID = :classID', ['classID' => $id]);

        return view('lecturer/component/getAssignCard', ['assignCards' => $assignCards, 'studAmount' => $studAmount[0]]);
    }

    public function createExam($id){
        $gradings = DB::select('select * from grading where classID = :classID', ['classID' => $id]);

        return view('lecturer/createExam', ['classID' => $id, 'gradings' => $gradings]);
    }

    public function createAssign($id){
        $gradings = DB::select('select * from grading where classID = :classID', ['classID' => $id]);

        return view('lecturer/createAssign', ['classID' => $id, 'gradings' => $gradings]);
    }

    public function addQuestion($qNumb){
        return view('lecturer/component/examQuestion', ['qNumb' => $qNumb]);
    }

    public function saveExam(Request $request){
        request()->validate([
            'examName' => 'required',
            'examDate' => 'required',
            'startTime' => 'required',
            'endTime' => 'required',
            'gradingID' => 'required',
            'examDescrip' => 'required',
        ]);

        $examID = request('examID');
        $examName = request('examName');
        $examDate = request('examDate');
        $startTime = request('startTime');
        $endTime = request('endTime');
        $gradingID = request('gradingID');
        $examDescrip = request('examDescrip');
        $classID = request('classID');
        $examArray = request('examArray');
        $examLateSubmit = request('examLateSubmit');

        error_log($examLateSubmit);
        if($examLateSubmit == 'true'){
            $examLateSubmit = 1;
        }

        $exam = new exam();
        $exam->examID = $examID;
        $exam->examName = $examName;
        $exam->date = $examDate;
        $exam->startTime = $startTime;
        $exam->endTime = $endTime;
        $exam->gradingID = $gradingID;
        $exam->Detail = $examDescrip;
        $exam->classID = $classID;
        $exam->lateSubmit = $examLateSubmit;

        $exam->save();

        foreach ($examArray as $question){
            $exam_q = new exam_q();
            $exam_q->examID = $examID;
            $exam_q->question = $question['question'];
            $exam_q->mark = $question['mark'];
            $exam_q->type = $question['qType'];

            $exam_q->save();
            $questionID = $exam_q->id;

            if($question['qType'] == 'mcq'){
                foreach ($question['mcq'] as $mcqOption){
                    $exam_q_mcq = new exam_q_mcq();
                    $exam_q_mcq->questionID = $questionID;
                    $exam_q_mcq->choiceName = $mcqOption;
                    $exam_q_mcq->eID = $examID;

                    $exam_q_mcq->save();
                }
            }
        }


        error_log($examDescrip);
    }

    public function editExam($classID, $id){
        $examDetail = DB::select('select * from exam where examID = :examID', ['examID' => $id]);
        $gradings = DB::select('select * from grading where classID = :classID', ['classID' => $classID]);
        //$question = DB::select('select * from exam_q left join exam_q_mcq on exam_q.questionID = exam_q_mcq.questionID where examID = :examID', ['examID' => $id]);

        $questions = DB::table('exam_q')
                        ->select('*','exam_q.questionID as questionIDCode')
                        ->leftJoin('exam_q_mcq', 'exam_q.questionID', '=', 'exam_q_mcq.questionID')
                        ->where('exam_q.examID', '=', $id)
                        ->orderBy('exam_q.questionID')
                        ->get();

        $quesCount = $questions->groupBy('questionID')->count();


        $tempIDHolder = "";
        $questionArray = array();
        foreach ($questions as $question){
            if($question->questionID == $tempIDHolder){
                array_push($questionArray[count($questionArray)-1]['mcq'], $question->choiceName);
            }else{
                $tempMcqArray = array();
                if($question->type == 'mcq'){
                    array_push($tempMcqArray, $question->choiceName);
                    $tempQuestion = array('type'=>$question->type, 'question'=>$question->question, 'mark'=>$question->mark, 'mcq'=>$tempMcqArray);
                    $tempIDHolder = $question->questionID;
                }else{
                    $tempQuestion = array('type'=>$question->type, 'question'=>$question->question, 'mark'=>$question->mark);
                }

                array_push($questionArray, $tempQuestion);
            }

        };
        //error_log($quesCount);

        return view('lecturer/editExam', ['examDetail' => $examDetail[0], 'classID' => $classID, 'gradings' => $gradings, 'questions' => $questionArray, 'quesCount' => $quesCount]);
    }

    public function editAssign($classID, $id){
        $assignDetail = DB::select('select * from assignment left join assign_file on assignment.assignFileID = assign_file.assignFileID where assignment.assignmentID = :assignmentID', ['assignmentID' => $id]);
        $gradings = DB::select('select * from grading where classID = :classID', ['classID' => $classID]);
        $assignFile = array();

        foreach($assignDetail as $file){
            $fileName = explode('/', $file->filePath);
            if($fileName[count($fileName)-1] != 'original'){
                $fileArray = array(($file->assignFileID), array_pop($fileName));
            }else{
                $fileArray = array();
            }

            array_push($assignFile, $fileArray);
        }

        return view('lecturer/editAssignment', ['assignDetail' => $assignDetail[0], 'classID' => $classID, 'gradings' => $gradings, 'assignFile' => $assignFile]);
    }

    public function updateExam(Request $request){
        request()->validate([
            'examName' => 'required',
            'examDate' => 'required',
            'startTime' => 'required',
            'endTime' => 'required',
            'gradingID' => 'required',
            'examDescrip' => 'required',
        ]);

        $examID = request('examID');
        $examName = request('examName');
        $examDate = request('examDate');
        $startTime = request('startTime');
        $endTime = request('endTime');
        $gradingID = request('gradingID');
        $examDescrip = request('examDescrip');
        $classID = request('classID');
        $examArray = request('examArray');
        $examLateSubmit = request('examLateSubmit');

        if($examLateSubmit == 'true'){
            $examLateSubmit = 1;
        }

        $exam = exam::find($examID);
        $exam->examName = $examName;
        $exam->date = $examDate;
        $exam->startTime = $startTime;
        $exam->endTime = $endTime;
        $exam->gradingID = $gradingID;
        $exam->Detail = $examDescrip;
        $exam->classID = $classID;
        $exam->lateSubmit = $examLateSubmit;

        $exam->save();

        $deleteQ = exam_q::where('examID', $examID)->delete();
        $deleteMCQ = exam_q_mcq::where('eID', $examID)->delete();

        foreach ($examArray as $question){
            $exam_q = new exam_q();
            $exam_q->examID = $examID;
            $exam_q->question = $question['question'];
            $exam_q->mark = $question['mark'];
            $exam_q->type = $question['qType'];

            $exam_q->save();
            $questionID = $exam_q->id;

            if($question['qType'] == 'mcq'){
                foreach ($question['mcq'] as $mcqOption){
                    $exam_q_mcq = new exam_q_mcq();
                    $exam_q_mcq->questionID = $questionID;
                    $exam_q_mcq->choiceName = $mcqOption;

                    $exam_q_mcq->save();
                }
            }
        }


        error_log($examDescrip);
    }

    public function updateAssignment(Request $request){
        request()->validate([
            'assignName' => 'required',
            'assignDate' => 'required',
            'endTime' => 'required',
            'gradingID' => 'required',
        ]);

        $subjectClassID = request('classID');
        $assignID = request('assignID');
        $assignName = request('assignName');
        $assignDate = request('assignDate');
        $endTime = request('endTime');
        $gradingID = request('gradingID');
        $assignDescrip = request('assignDescrip');
        $assignLateSubmit = request('assignLateSubmit');
        $fileUpload = request('fileUpload');
        $uploadString = 'assignment/'.request('classID').'/'.$assignID.'/original';

        if($assignLateSubmit == 'true'){
            $assignLateSubmit = 1;
        }else{
            $assignLateSubmit = 0;
        }

        $assignment = assignment::find($assignID);

        $tempFileID = $assignment->assignFileID;

        $assignment->assignName = $assignName;
        $assignment->assignDate = $assignDate;
        $assignment->endTime = $endTime;
        $assignment->description = $assignDescrip;
        $assignment->gradingID = $gradingID;
        $assignment->classID = $subjectClassID;
        $assignment->lateSubmit = $assignLateSubmit;

        $assignment->save();

        if($request->hasFile('fileUpload')){
            error_log($fileUpload->getClientOriginalName());
            $path = $fileUpload->storeAs($uploadString, $fileUpload->getClientOriginalName());
            $assignFile = assign_file::find($tempFileID);
            $assignFile->filePath = $path;

            $assignFile->save();

        }

        return 'success';
    }

    public function getTimeAdj(){
        $user = Auth::user();

        $timeAdjs = DB::select('select * from time_adjustment left join class on time_adjustment.classID = class.classID where class.teacherID = :id', ['id' => $user->idCode]);

        return view('lecturer/dataTable/DT_timeAdjust', ['timeAdjs' => $timeAdjs]);
    }

    public function createTimeAdj(){
        $user = Auth::user();

        $classes = DB::select('select * from class where teacherID = :teacherID', ['teacherID' => $user->idCode]);


        return view('lecturer/createTimeAdj', ['classes' => $classes]);
    }

    public function getTimeSelect($id){
        $times = DB::select('select * from time where classID = :classID', ['classID' => $id]);

        return view('lecturer/component/classTimeSelect', ['times' => $times]);
    }

    public function saveTimeAdj(Request $request){
        error_log('reachLecController0');

        $classID = request('classID');
        $timeID = request('timeID');
        $reason = request('reason');
        $type = request('type');
        $startTime = request('startTime');
        $endTime = request('endTime');
        $addInfo = request('addInfo');
        $date = request('date');

        $timeAdj = new time_adjustment();
        $timeAdj->classID = $classID;
        $timeAdj->timeID = $timeID;
        $timeAdj->reason = $reason;
        $timeAdj->type = $type;
        $timeAdj->startTime = $startTime;
        $timeAdj->endTime = $endTime;

        $time = time::find($timeID);
        //get the old time info
        $timeAdj->oldDay = $time->Day;
        $timeAdj->oldStart = $time->startTime;
        $timeAdj->oldEnd = $time->endTime;

        if($type === 'temp'){
            error_log('reach temp2');
            $timeAdj->date = $date;
            $timeAdj->newdate = $addInfo;
        }else if($type === 'perm'){
            $timeAdj->day = $addInfo;

            //updated the time slot
            $time->Day =  $addInfo;
            $time->startTime = $startTime;
            $time->endTime = $endTime;
            $time->classID = $classID;

            $time->save();
        }

        $timeAdj->save();
    }

    public function getTimeAdjDetail($id){
        $timeAdjID = $id;
        $tAdjDetail = DB::select('select * from time_adjustment left join class on time_adjustment.classID = class.classID where time_adjustment.timeAdjID = :timeAdjID', ['timeAdjID' => $timeAdjID]);

        return view('lecturer/component/getTimeAdjDetail', ['tAdjDetail' => $tAdjDetail[0]]);
    }

    public function examMark($id){
        $examID = $id;

        $examSubmissions = exam_submission::select('users.idCode', 'users.name', 'exam_submission.examSubID', 'exam_submission.created_at', 'exam_submission.totalMark')
                                            ->leftJoin('users', 'exam_submission.studID', '=', 'users.id')
                                            ->where('exam_submission.examID', $examID)
                                            ->get();

        $examQ = exam::leftJoin('exam_q', 'exam.examID', '=', 'exam_q.examID')
                        ->where('exam.examID', $examID)
                        ->get();

        $classID = $examQ[0]->classID;

        $qNumber = $examQ->count();

        return view('lecturer/examMark', ['examSubmissions' => $examSubmissions, 'examID' => $examID, 'qn' => $qNumber, 'cid' => $classID]);
    }

    public function getSubmition(Request $request){
        $examID = request('examID');
        $submitID = request('submitID');

        $examSubmissions = exam_submission::select('users.idCode', 'users.name', 'exam_submission.examSubID', 'exam_submission.created_at', 'exam.date', 'exam.startTime', 'exam.endTime')
                                            ->leftJoin('exam', 'exam_submission.examID', '=', 'exam.examID')
                                            ->leftJoin('users', 'exam_submission.studID', '=', 'users.id')
                                            ->where('exam_submission.examID', $examID)
                                            ->where('exam_submission.examSubID', $submitID)
                                            ->get();

        $date = $examSubmissions[0]->created_at;
        if($date->toDateString() >= $examSubmissions[0]->date){

            if(($date->toTimeString()) > ($examSubmissions[0]->endTime)){
                error_log($date);
                $examSubmissions[0]['lateSubmit'] = "Yes";

            }else{
                $examSubmissions[0]['lateSubmit'] = "No";
            }

        }else{
            $examSubmissions[0]['lateSubmit'] = "No";
        }

        //getSubmission Question
        $submissionQ = exam_sub_ans::leftJoin('exam_q', 'exam_sub_ans.questionID', '=', 'exam_q.questionID')
                                    ->leftJoin('exam_q_mcq', 'exam_sub_ans.answer', '=', 'exam_q_mcq.id')
                                    ->where('exam_sub_ans.examSubID', $submitID)
                                    ->get();


        return view('lecturer/component/getSubmitExam', ['examSubmission' => $examSubmissions[0], 'submissionQ' => $submissionQ]);
    }

    public function saveExamMark(Request $request){
        $tempQ = request('tempQ');
        $examID = request('examID');
        $totalMark = 0;

        foreach ($tempQ as $question){
            $SubmitQ = exam_sub_ans::find($question[0]);
            $SubmitQ->remark = $question[1];
            $SubmitQ->assignMark = $question[2];
            $totalMark = $totalMark + $SubmitQ->assignMark;

            $submissionID = $SubmitQ->examSubID;

            $SubmitQ->save();
        }
        error_log($submissionID);
        $saveTotalMark = exam_submission::find($submissionID);
        $saveTotalMark->totalMark = $totalMark;
        $saveTotalMark->save();


        return $submissionID;
    }

    public function saveAssignment(Request $request){
        request()->validate([
            'assignName' => 'required',
            'assignDate' => 'required',
            'endTime' => 'required',
            'gradingID' => 'required',
        ]);

        $SubjectClassID = request('classID');
        $assignID = request('assignID');
        $assignName = request('assignName');
        $assignDate = request('assignDate');
        $endTime = request('endTime');
        $gradingID = request('gradingID');
        $assignDescrip = request('assignDescrip');
        $assignLateSubmit = request('assignLateSubmit');
        $fileUpload = request('fileUpload');
        $uploadString = 'assignment/'.request('classID').'/'.$assignID.'/original';

        error_log($SubjectClassID);

        if($assignLateSubmit == 'true'){
            $assignLateSubmit = 1;
        }else{
            $assignLateSubmit = 0;
        }

        $newAssignment = new assignment();
        $newAssignment->assignmentID = $assignID;
        $newAssignment->assignName = $assignName;
        $newAssignment->assignDate = $assignDate;
        $newAssignment->endTime = $endTime;
        $newAssignment->gradingID = $gradingID;
        $newAssignment->classID = $SubjectClassID;
        $newAssignment->description = $assignDescrip;
        $newAssignment->lateSubmit = $assignLateSubmit;

        if($request->hasFile('fileUpload')){
            $path = $fileUpload->storeAs($uploadString, $fileUpload->getClientOriginalName());

            $savePath = new assign_file();
            $savePath->filePath = $path;

            $savePath->save();

            $fileID = $savePath->assignFileID;
            $newAssignment->assignFileID = $fileID;
        }

        $newAssignment->save();

        return 'success';
    }

    public function fileDownload($id){
        error_log('testing');
        $fileDetail = assign_file::where('assignFileID', $id)->get();
        $filePath = '../storage/app/'.$fileDetail[0]->filePath;

        $tempName = explode('/', $filePath);
        $fileName = array_pop($tempName);
        //error_log($filePath);

        return response()->download($filePath, $fileName);

    }

    public function submitDownload($id){
        $fileDetail = submission::leftJoin('users', 'submission.studID', '=', 'users.id')->where('submissionID', $id)->get();
        $filePath = '../storage/app/'.$fileDetail[0]->submitFilePath;

        $fileName = $fileDetail[0]->assignmentID."_".$fileDetail[0]->idCode;
        //error_log($filePath);

        return response()->download($filePath, $fileName);
    }

    public function assignMark($id){
        $assignID = $id;
        $tempArray = array();

        $assignSubmissions = submission::leftJoin('users', 'submission.studID', '=', 'users.id')
                                            ->where('submission.assignmentID', $assignID)
                                            ->get();

        $grading = grading::leftJoin('assignment', 'grading.gradingID', '=', 'assignment.gradingID')
                                ->where('assignmentID', $assignID)
                                ->get();

        foreach($assignSubmissions as $submission){
            $temp = array("sbID" => $submission->submissionID, "mark"=>"");
            array_push($tempArray, $temp);
        }

        $sNumber = $assignSubmissions->count();

        return view('lecturer/assignMark', ['assignID' => $assignID, 'ss' => $tempArray, 'assignment' => $grading[0]]);
    }

    public function saveAssignMark(Request $request){
        $submissionID = request('submissionID');
        $mark = request('mark');

        $submission = submission::find($submissionID);
        $submission->totalMark = $mark;
        $studID = $submission->studID;

        $submission->save();

        $stud = DB::select('select * from users where id = :id', ['id' => $studID]);
        $idCode = $stud[0]->idCode;
        error_log(JSON_encode($stud));
        return $idCode;
    }

    public function saveAssignMarkAll(Request $request){
        $submissionSets = request('ss');
        $countN = 0;

        foreach($submissionSets as $submission){
            $update = submission::find($submission['sbID']);
            $update->totalMark = $submission['mark'];
            $update->save();
            $countN++;
        }

        return $countN;
    }

    public function getDashboard(){
        $user = Auth::user();
        $today = Carbon::now();
        $examData = array();
        $assignData = array();

        $classes = DB::select('select * from class where teacherID = :teacherID', ['teacherID' => $user->idCode]);
        $totalStud = DB::select('select count(*) as studNumb from class_stud_list where classID = :classID', ['classID' => $classes[0]->classID]);


        foreach($classes as $class){
            //Exam submission rate
            $exams = DB::select('select exam.examID, exam.examName, exam.date, exam.startTime, exam.endTime, COALESCE(count(exam_submission.examSubID), 0) as subCount from exam left join exam_submission on exam.examID = exam_submission.examID where exam.classID = :classID group by exam.examID', ['classID' => $class->classID]);

            foreach($exams as $exam){
                if(($exam->date) >= ($today->toDateString())){
                    $temp = array($exam, $totalStud[0]);
                    array_push($examData, $temp);
                }
            }

            //assignment submission rate
            $assignments = DB::select('select assignment.assignName, assignment.assignDate, COALESCE(count(submission.submissionID), 0) as subCount from assignment left join submission on assignment.assignmentID = submission.assignmentID where assignment.classID = :classID group by assignment.assignmentID', ['classID' => $class->classID]);

            foreach($assignments as $assignment){
                if(($assignment->assignDate) >= ($today->toDateString())){
                    $temp = array($assignment, $totalStud[0]);
                    array_push($assignData, $temp);
                }
            }
        }

        //timeTable setup
        $weekdayList = array("sunday","monday","tuesday","wednesday","thursday","friday","saturday");
        $currentWeekDay = Carbon::now()->dayOfWeek;

        for($d = 0; $d <= 6; $d++){
            if($today->dayOfWeek < 6 && $today->dayOfWeek > 0){
                $weekDay = $weekdayList[$today->dayOfWeek];
                $timeSlot = DB::table('class')->leftJoin('time', 'class.classID', '=', 'time.classID')->where('class.teacherID', $user->idCode)->where('Day', $weekDay);

                //remove from data
                $oldTAdjs = time_adjustment::where('date', $today->toDateString())->get();
                foreach ($oldTAdjs as $oldTAdj){
                    $timeSlot = $timeSlot->where('timeID', '<>', $oldTAdj['timeID']);
                }
                $timeSlot = $timeSlot->get();

                //add into data
                $newTAdjs = time_adjustment::leftJoin('class', 'time_adjustment.classID', '=', 'class.classID')->where('newdate', $today->toDateString())->get();
                foreach ($newTAdjs as $newTAdj){
                    //$timeSlot = JSON_decode(JSON_encode($timeSlot));
                    //array_push($timeSlot, $newTAdj);
                    //error_log($newTAdj);
                    $timeSlot->push($newTAdj);
                }

                switch ($today->dayOfWeek) {
                    case 1:
                        $monday = array('Monday', $timeSlot, $today->toDateString());
                        break;
                    case 2:
                        $tuesday = array('Tuesday', $timeSlot, $today->toDateString());
                        break;
                    case 3:
                        $wednesday = array('Wednesday', $timeSlot, $today->toDateString());
                        break;
                    case 4:
                        $thursday = array('Thursday', $timeSlot, $today->toDateString());
                        break;
                    case 5:
                        $friday = array('Friday', $timeSlot, $today->toDateString());
                        break;

                }

            }

            $today->addDays(1);
        }

        switch ($currentWeekDay){
            case 2:
                $timeSets = array($tuesday, $wednesday, $thursday, $friday, $monday);
                break;
            case 3:
                $timeSets = array($wednesday, $thursday, $friday, $monday, $tuesday);
                break;
            case 4:
                $timeSets = array($thursday, $friday, $monday, $tuesday, $wednesday);
                break;
            case 5:
                $timeSets = array($friday, $monday, $tuesday, $wednesday, $thursday);
                break;
            default:
                $timeSets = array($monday, $tuesday, $wednesday, $thursday, $friday);
        }

        return view('lecturer/component/getDashboard', ['examData' => $examData, 'assignData' => $assignData, 'timeSets' => $timeSets]);
    }

}
