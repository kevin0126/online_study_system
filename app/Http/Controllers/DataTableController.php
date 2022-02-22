<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\submission;
use App\grading;


class DataTableController extends Controller
{
    public function stud(){
        $students = DB::select('select * from users where type = ?', [2]);
        //Serror_log(json_encode($students));
        return view('/admin/dataTable/DT_Student', ['students' => $students]);
    }

    public function lectur(){
        $lecturers = DB::select('select * from users where type = ?', [1]);

        return view('/admin/dataTable/DT_Lecturer', ['lecturers' => $lecturers]);
    }

    public function class(){
        $classes = DB::select('select class.classID, class.classCode, class.className, users.name, class.status from class left join users on class.teacherID = users.idCode');

        return view('/admin/dataTable/DT_Class', ['classes' => $classes]);
    }

    public function classStud($id){
        $classStuds = DB::select('select users.idCode, users.name, users.contact, users.email from users left join class_stud_list on users.idCode = class_stud_list.studentID where classID = :classID', ['classID' => $id]);

        return view('admin/dataTable/DT_ClassStudList', ['classStuds' => $classStuds] );
    }

    public function getTimeClassCreate(){
        $records = "";

        return view('admin/dataTable/T_ClassTimeSch');
    }

    public function postTimeClassCreate(Request $request){
        $records = request('records');
        error_log(Json_encode($records));
        return view('admin/dataTable/T_ClassTimeSch', ['records' => $records]);
    }

    public function getEnrollStudentList(){
        $records = "";

        return view('admin/dataTable/T_EnrollStudentList');
    }

    public function postEnrollStudentList(Request $request){
        $records = request('records');
        error_log(Json_encode($records));
        return view('admin/dataTable/T_EnrollStudentList', ['studrecords' => $records]);
    }

    public function getClassStudentsList($id){
        $students = DB::select('select * from class_stud_list left join users on class_stud_list.studentID = users.idCode where classID = :classID', ['classID' => $id]);

        return view('lecturer/dataTable/DT_studList', ['students' => $students] );
    }

    public function getGradTable($id){
        $gradings = DB::select('select * from grading where classID = :classID', ['classID' => $id]);

        return view('lecturer/dataTable/T_gradingSch', ['records' => $gradings] );
    }

    public function getAssignSubmission(Request $request){
        $assignID = request('assignID');

        $assignSubmissions = submission::select('users.idCode', 'submission.submissionID', 'submission.totalMark', 'submission.created_at', 'assignment.assignDate', 'assignment.endTime')
                                        ->leftJoin('users', 'submission.studID', '=', 'users.id')
                                        ->leftJoin('assignment', 'submission.assignmentID', '=', 'assignment.assignmentID')
                                        ->where('submission.assignmentID', $assignID)
                                        ->get();

        $grading = grading::leftJoin('assignment', 'grading.gradingID', '=', 'assignment.gradingID')
                            ->where('assignmentID', $assignID)
                            ->get();

        $max = $grading[0]->gradingPercentage;

        foreach($assignSubmissions as $submission){
            if(is_null($submission->totalMark)){
                $submission->totalMark = 0;
            }

            $date = $submission->created_at;
            if($date->toDateString() >= $submission->assignDate){

                if(($date->toTimeString()) > ($submission->endTime)){
                    error_log($date);
                    $submission['lateSubmit'] = "Yes";

                }else{
                    $submission['lateSubmit'] = "No";
                }

            }else{
                $submission['lateSubmit'] = "No";
            }
        }

        return view('lecturer/dataTable/DT_assignSubmission', ['assignID' => $assignID, 'assignSubmissions' => $assignSubmissions, 'max' => $max]);

    }
}
