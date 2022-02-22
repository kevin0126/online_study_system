<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use App\time_adjustment;
use App\exam;
use App\exam_q;
use App\assignment;
use App\exam_submission;
use App\submission;
use App\grading;
use App\exam_sub_ans;
use App\assign_file;

class StudentController extends Controller
{
    public function getTimeSpecificTimeTable(){
        $user = Auth::user();
        $weekdayList = array("sunday","monday","tuesday","wednesday","thursday","friday","saturday");
        $currentWeekDay = Carbon::now()->dayOfWeek;
        $today = Carbon::today();

        for($d = 0; $d <= 6; $d++){
            if($today->dayOfWeek < 6 && $today->dayOfWeek > 0){
                error_log($today->dayOfWeek);
                $weekDay = $weekdayList[$today->dayOfWeek];
                $timeSlot = DB::table('class')->leftJoin('class_stud_list', 'class.classID', '=', 'class_stud_list.classID')->leftJoin('time', 'class.classID', '=', 'time.classID')->where('class_stud_list.studentID', $user->idCode)->where('Day', $weekDay);

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

        error_log(JSON_encode($timeSets));

        return view('stud/component/timeSch', ['timeSets' => $timeSets]);
    }

    public function getClasses(){
        $user = Auth::user();

        $classes = DB::select('select * from class left join faculty on class.facultyID = faculty.id left join class_stud_list on class_stud_list.classID = class.classID where studentID = :id', ['id' => $user->idCode]);

        //error_log(JSON_encode($classes));
        return view('stud/component/getClassesCard', ['classes' => $classes]);
    }

    public function getStudClass($id){
        $classID = $id;
        $classDetail = DB::select('select * from class left join users on class.teacherID = users.idCode where classID = :classID', ['classID' => $classID]);

        return view('stud/classPage', ['classDetail' => $classDetail[0]]);
    }

    public function getInfor($id){
        $classID = $id;
        $temp = "temp";

        $exam = exam::where('classID', $classID)->get();
        $timeAdj = time_adjustment::where('classID', $classID)->get();
        $assign = assignment::where('classID', $classID)->get();

        $infor = collect([]);

        if($exam->count() > 0){
            $infor = $infor->merge($exam);
        }

        if($timeAdj->count() > 0){
            $infor = $infor->merge($timeAdj);
        }

        if($assign->count() > 0){
            $infor = $infor->merge($assign);
        }

        $infor = $infor->sortByDesc('created_at');

        return view('stud/component/getClassInfo', ['inforDetails' => $infor->values(), 'temp' => $temp]);
        //$timeSlot->push($newTAdj);
    }

    public function getCarry($id){
        $classID = $id;
        $user = Auth::user();
        $today = Carbon::today();
        $carryMarkList = [];

        $gradings = grading::where('classID', $classID)->get();

        $class = DB::select('select * from class where classID = :classID', ['classID' => $classID]);
        $classInitial = $class[0]->updated_at;

        foreach ($gradings as $grading){
            $temp = exam_submission::leftJoin('exam', 'exam_submission.examID', '=', 'exam.examID')->leftjoin('grading', 'exam.gradingID', '=', 'grading.gradingID')->where('exam_submission.created_at', '>', $classInitial)->where('exam.gradingID', $grading->gradingID)->where('exam_submission.studID', $user->id)->get();
            $temp2 = submission::leftJoin('assignment', 'submission.assignmentID', '=', 'assignment.assignmentID')->leftjoin('grading', 'assignment.gradingID', '=', 'grading.gradingID')->where('submission.created_at', '>', $classInitial)->where('assignment.gradingID', $grading->gradingID)->where('submission.studID', $user->id)->get();
            //if($temp->examID)
            //error_log($temp->examID);
            $exam = exam::leftJoin('exam_q', 'exam.examID', '=', 'exam_q.examID')->leftjoin('grading', 'exam.gradingID', '=', 'grading.gradingID')->where('exam.gradingID', $grading->gradingID)->get();
            $fullMark = $exam->sum('mark');

            //error_log(JSON_encode($temp));

            if($temp->isNotEmpty() > 0){
                $carryMark = (($temp[0]->totalMark)/$fullMark)*($temp[0]->gradingPercentage);

                array_push($carryMarkList, array('examName'=>$grading->gradingType, 'carryMark'=>$carryMark, 'fullMark'=>$grading->gradingPercentage));
            }else{
                if($temp2->isNotEmpty() > 0){
                    $carryMark = $temp2[0]->totalMark;

                    array_push($carryMarkList, array('examName'=>$grading->gradingType, 'carryMark'=>$carryMark, 'fullMark'=>$grading->gradingPercentage));
                }else{
                    $carryMark = 0;

                    array_push($carryMarkList, array('examName'=>$grading->gradingType, 'carryMark'=>$carryMark, 'fullMark'=>$grading->gradingPercentage));
                }
            }


        }

        return view('stud/component/carryMarkPanel', ['carryMarkList' => $carryMarkList]);
    }

    public function getTimeAdjDetail($id){
        $timeAdjID = $id;
        $tAdjDetail = DB::select('select * from time_adjustment left join class on time_adjustment.classID = class.classID where time_adjustment.timeAdjID = :timeAdjID', ['timeAdjID' => $timeAdjID]);

        return view('lecturer/component/getTimeAdjDetail', ['tAdjDetail' => $tAdjDetail[0]]);
    }

    public function examPage($classID, $id){
        error_log("examPage reach");
        return view('stud/examPage', ['classID' => $classID, 'examID' => $id]);
    }

    public function assignPage($classID, $id){

        return view('stud/assignPage', ['classID' => $classID, 'assignID' => $id]);
    }

    public function examCheck($classID, $id){
        $examID = $id;
        $today = Carbon::now();
        $passData = array();
        $user = Auth::user();
        $exam = exam::leftJoin('class', 'exam.classID', '=', 'class.classID')->where('examID', $examID)->get();
        $examSubmission = exam_submission::where('studID', $user->id)->where('examID', $examID)->get();
        $urlString  = "stud/component/";

        error_log($examSubmission->count());
        if($examSubmission->count() < 1){
            if(($today->toDateString()) == ($exam[0]->date)){
                if((($today->toTimeString()) >= ($exam[0]->startTime)) && (($today->toTimeString()) <= ($exam[0]->endTime))){

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
                            array_push($questionArray[count($questionArray)-1]['mcqID'], $question->id);
                        }else{
                            $tempMcqArray = array();
                            $tempMcqIDArray = array();
                            if($question->type == 'mcq'){
                                array_push($tempMcqArray, $question->choiceName);
                                array_push($tempMcqIDArray, $question->id);

                                $tempQuestion = array('type'=>$question->type, 'questionID'=>$question->questionIDCode, 'question'=>$question->question, 'mark'=>$question->mark, 'mcq'=>$tempMcqArray, 'mcqID'=>$tempMcqIDArray);
                                $tempIDHolder = $question->questionID;
                            }else{
                                error_log($question->questionID);
                                $tempQuestion = array('type'=>$question->type, 'questionID'=>$question->questionIDCode, 'question'=>$question->question, 'mark'=>$question->mark);
                            }

                            array_push($questionArray, $tempQuestion);
                        }

                    };
                    $passData += ['questions' => $questionArray];

                    $urlString = $urlString . "examUnlock";
                }else{
                    error_log($today->toTimeString()."::".$exam[0]->startTime);
                    $urlString = $urlString . "examLock";
                }
            }else{
                $urlString = $urlString . "examLock";
            }
        }else{
            $urlString = $urlString . "examLock";
        }
        error_log($today);

        $passData += ['classID' => $classID, 'exam' => $exam[0], 'student' => Auth::user()];

        return view($urlString, $passData);
    }

    public function checkAssign($classID, $id){
        $assignID = $id;
        $today = Carbon::now();
        $passData = array();
        $user = Auth::user();
        $assignment = assignment::leftJoin('class', 'assignment.classID', '=', 'class.classID')->leftJoin('grading', 'assignment.gradingID', '=', 'grading.gradingID')->where('assignment.assignmentID', $assignID)->get();
        $assignmentSubmission = submission::where('studID', $user->id)->where('assignmentID', $assignID)->get();
        $urlString  = "stud/component/";

        error_log($assignmentSubmission->count());
        if($assignmentSubmission->count() < 1){
            if(($today->toDateString()) < ($assignment[0]->assignDate)){

                $filePath = assign_file::where('assignFileID', $assignment[0]->assignFileID)->get();
                $assignFile = array();

                foreach($filePath as $file){
                    $fileName = explode('/', $file->filePath);
                    if($fileName[count($fileName)-1] != 'original'){
                        $fileArray = array(($file->assignFileID), array_pop($fileName));
                    }else{
                        $fileArray = array();
                    }

                    array_push($assignFile, $fileArray);
                }

                $passData += ['assignFile' => $assignFile];

                $urlString = $urlString . "assignUnlock";

            }else if(($today->toDateString()) == ($assignment[0]->assignDate)){
                if(($today->toTimeString()) <= ($assignment[0]->endTime)){

                    $filePath = assign_file::where('assignFileID', $assignment[0]->assignFileID)->get();
                    $assignFile = array();

                    foreach($filePath as $file){
                        $fileName = explode('/', $file->filePath);
                        if($fileName[count($fileName)-1] != 'original'){
                            $fileArray = array(($file->assignFileID), array_pop($fileName));
                        }else{
                            $fileArray = array();
                        }

                        array_push($assignFile, $fileArray);
                    }

                    $passData += ['assignFile' => $assignFile];

                    $urlString = $urlString . "assignUnlock";
                }else{
                    $urlString = $urlString . "assignLock";
                }
            }else{
                $urlString = $urlString . "assignLock";
            }
        }else{
            $urlString = $urlString . "assignLock";
        }

        $passData += ['classID' => $classID, 'assignment' => $assignment[0], 'student' => Auth::user()];

        return view($urlString, $passData);
    }

    public function submitExam(Request $request){
        $examID = request('examID');
        $studID = request('studentID');
        error_log($studID);
        $classID = request('classID');
        $examArray = request('examArray');
        $today = Carbon::now();
        $trigglePass = 0;

        $exam = exam::leftJoin('class', 'exam.classID', '=', 'class.classID')->where('examID', $examID)->get();

        if(($today->toDateString()) >= ($exam[0]->date)){
            if((($today->toTimeString()) >= ($exam[0]->startTime)) && (($today->toTimeString()) <= ($exam[0]->endTime))){
                $trigglePass = 1;
            }else{
                if($exam[0]->lateSubmit > 0){
                    $trigglePass = 1;
                }
            }
        }

        if($trigglePass == 1){
            $exam_sub = new exam_submission();
            $exam_sub->examID = $examID;
            $exam_sub->studID = $studID;

            $exam_sub->save();
            $submissionID = $exam_sub->examSubID;

            foreach ($examArray as $question){
                $examAns_sub = new exam_sub_ans();
                $examAns_sub->examSubID = $submissionID;
                $examAns_sub->questionID = $question['questionID'];
                $examAns_sub->answer = $question['answer'];

                $examAns_sub->save();
            }
        }

        return $trigglePass;
    }

    public function submitAssignment(Request $request){
        request()->validate([
            'fileUpload' => 'required',
        ]);

        $today = Carbon::now();
        $assignmentID = request('assignmentID');
        $studentID = request('studentID');
        $classID = request('classID');
        $fileUpload = request('fileUpload');
        $uploadString = 'assignment/'.request('classID').'/'.$assignmentID.'/submission/'.$studentID;
        $trigglePass = 0;

        $assignment = assignment::leftJoin('class', 'assignment.classID', '=', 'class.classID')->where('assignment.assignmentID', $assignmentID)->get();


        if(($today->toDateString()) < ($assignment[0]->assignDate)){

            $filePath = assign_file::where('assignFileID', $assignment[0]->assignFileID)->get();
            $assignFile = array();

            if(($today->toDateString()) < ($assignment[0]->assignDate)){
                $trigglePass = 1;
            }else if(($today->toDateString()) == ($assignment[0]->assignDate)){
                if(($today->toTimeString()) <= ($assignment[0]->endTime)){
                    $trigglePass = 1;
                }
            }
        }

        if($trigglePass == 1){
            $path = $fileUpload->storeAs($uploadString, $fileUpload->getClientOriginalName());

            $assignSubmission = new submission();
            $assignSubmission->assignmentID = $assignmentID;
            $assignSubmission->studID = $studentID;
            $assignSubmission->submitFilePath = $path;

            $assignSubmission->save();
        }

        return $trigglePass;
    }

    public function submitSuccess(){
        return view('stud/successSubmit');
    }

    public function submitReject(){
        return view('stud/submitReject');
    }
}
