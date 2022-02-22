<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Mail\notifyMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use App\users;
use App\time;
use App\class_stud_list;
use App\bk_time;
use App\bk_time_detail;

class AdminController extends Controller
{
    public function getStud($id){
        $student = DB::select('select * from users where idCode = :idCode', ['idCode' => $id]);

        return view('/admin/form/getStudDetail', ['student' => $student]);
    }

    public function getLectur($id){
        $lecturer = DB::select('select * from users where idCode = :idCode', ['idCode' => $id]);

        return view('/admin/form/getLecturDetail', ['lecturer' => $lecturer]);
    }

    public function getClass($id){
        $class = DB::select('select class.classID, class.classCode, class.className, class.status, faculty.facultyName, users.name, class.updated_at from class left join users on class.teacherID = users.idCode left join faculty on class.facultyID = faculty.id where class.classID = :id', ['id' => $id]);
        $times = DB::select('select * from time where classID = :id', ['id' => $id]);

        error_log("yolo: ".$class[0]->className);

        return view('admin/form/getClassDetail', ['class' => $class, 'times' => $times]);
    }

    public function createStud(){
        return view('/admin/createStud');
    }

    public function editStud($id){
        $student = DB::select('select * from users where idCode = :idCode', ['idCode' => $id]);
        $countryCode = substr($student[0]->contact, 0, 3);
        $contact = substr($student[0]->contact, 3);

        return view('/admin/editStud', ['student' => $student, 'countryCode' => $countryCode, 'contact' => $contact]);
    }

    public function updateStud(Request $request){
        $changePass = request('changePass');
        $updateUser = users::find(request('studID'));
        error_log(JSON_encode($updateUser));
        if($changePass === "true"){
            request()->validate([
                'studName' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'password' => 'required|confirmed'
            ]);

            $updateUser->name = request('studName');
            $updateUser->email = request('email');
            $updateUser->contact = request('phone');
            $updateUser->password = Hash::make(request('password'));

            $updateUser->save();

        }else if($changePass === "false"){
            request()->validate([
                'studName' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
            ]);

            $updateUser->name = request('studName');
            $updateUser->email = request('email');
            $updateUser->contact = request('phone');

            $updateUser->save();
        }


    }

    public function emailPass(Request $request){
        $id = request('id');
        $user = DB::select('select * from users where idCode = :idCode', ['idCode' => $id]);

        Mail::to($user[0]->email)->send(new notifyMail());
    }

    public function storeStud(Request $request){

        request()->validate([
            'studID' => 'required|unique:users,id',
            'studName' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required|confirmed'
        ]);

        $users = new users();
        $users->idCode = request('studID');
        $users->name = request('studName');
        $users->email = request('email');
        $users->password = Hash::make(request('password'));
        $users->contact = request('phone');
        $users->type = "2";

        $users->save();

    }

    public function createLectur(){
        return view('/admin/createLectur');
    }

    public function createClass(){
        $type = 1;
        $lecturers = DB::select('select * from users where type = :type', ['type' => $type]);
        $facultys = DB::select('select * from faculty');

        return view('/admin/createClass', ['lecturers' => $lecturers, 'facultys' => $facultys]);
    }

    public function storeLect(Request $request){

        request()->validate([
            'lectID' => 'required|unique:users,id',
            'lectName' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required|confirmed'
        ]);

        $users = new users();
        $users->idCode = request('lectID');
        $users->name = request('lectName');
        $users->email = request('email');
        $users->password = Hash::make(request('password'));
        $users->contact = request('phone');
        $users->type = "1";

        $users->save();

    }

    public function editLect($id){
        $lecturer = DB::select('select * from users where idCode = :idCode', ['idCode' => $id]);
        $countryCode = substr($lecturer[0]->contact, 0, 3);
        $contact = substr($lecturer[0]->contact, 3);

        return view('/admin/editLect', ['lecturer' => $lecturer, 'countryCode' => $countryCode, 'contact' => $contact]);
    }

    public function updateLect(Request $request){
        $changePass = request('changePass');
        $updateUser = users::where('idCode', request('lectID')->first());

        if($changePass === "true"){
            request()->validate([
                'lectName' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'password' => 'required|confirmed'
            ]);

            $updateUser->name = request('lectName');
            $updateUser->email = request('email');
            $updateUser->contact = request('phone');
            $updateUser->password = Hash::make(request('password'));

            $updateUser->save();

        }else if($changePass === "false"){
            request()->validate([
                'lectName' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
            ]);

            $updateUser->name = request('lectName');
            $updateUser->email = request('email');
            $updateUser->contact = request('phone');

            $updateUser->save();
        }


    }

    public function checkStudID($id){
        $student = DB::select('select idCode, name, batch from users where idCode = :idCode', ['idCode' => $id]);

        return $student;
    }

    public function targetStatusChange(Request $request){
        $updateUser = users::find(request('targetID'));

        if(request('choice') === 'activate'){
            $choice = 1;
        }else{
            $choice = 0;
        }

        $updateUser->status = $choice;

        $updateUser->save();

    }

    public function storeClass(Request $request){
        error_log('controller reach');
        $classCode = request('classCode');
        $className = request('className');
        $facultyID = request('facultyID');
        $lecturerID = request('lecturerID');
        $tempTimeArray = request('timeArray');
        $tempErollArray = request('erollArray');

        //insert into class table
        $classID = DB::table('class')->insertGetId(
            ['classCode' => $classCode, 'className' => $className, 'facultyID' => $facultyID, 'teacherID' => $lecturerID]
        );

        //insert into time table
        foreach ($tempTimeArray as $timeRecord){
            $time = new time();
            $time->Day = $timeRecord['Day'];
            $time->startTime = $timeRecord['startTime'];
            $time->endTime = $timeRecord['endTime'];
            $time->classID = $classID;

            $time->save();
        }

        //insert into class_stud_list table
        foreach ($tempErollArray as $enrollRecord){
            $class_stud_list = new class_stud_list();
            $class_stud_list->classID = $classID;
            $class_stud_list->studentID = $enrollRecord['idCode'];

            $class_stud_list->save();
        }


        error_log(json_encode($tempTimeArray)." @@@@@@ ".json_encode($tempErollArray));
    }

    public function resetSingle($id){
        $classID = $id;

        //change class status
        DB::table('class')->where('classID', $classID)->update(array('status' => 0));

        //delete timeSchedule for class
        $removeTime = time::where('classID', $id)->delete();

        //delete studentList for class
        $removeEnroll = class_stud_list::where('classID', $id)->delete();
        error_log("resetSingle".$classID);
    }

    public function setupClass($id){
        //get class basic detail
        $classID = $id;
        error_log($classID);
        $classDetails = DB::select('select * from class where classID = :classID', ['classID' => $classID]);


        //get teacher and faculty data
        //type 1 for teacher record
        $type = 1;
        $lecturers = DB::select('select * from users where type = :type', ['type' => $type]);
        $facultys = DB::select('select * from faculty');

        return view('/admin/setupClass', ['lecturers' => $lecturers, 'facultys' => $facultys, 'classDetails' => $classDetails[0]]);

    }

    public function updateClass(Request $request){
        $classID = request('classID');
        error_log("idclass=".request('classID'));
        $classCode = request('classCode');
        $className = request('className');
        $facultyID = request('facultyID');
        $lecturerID = request('lecturerID');
        $tempTimeArray = request('timeArray');
        $tempErollArray = request('erollArray');

        //insert into class table
        DB::table('class')->where('classID', $classID)->update(
            ['classCode' => $classCode, 'className' => $className, 'facultyID' => $facultyID, 'teacherID' => $lecturerID, 'status' => 1]
        );

        //insert into time table
        foreach ($tempTimeArray as $timeRecord){
            $time = new time();
            $time->Day = $timeRecord['Day'];
            $time->startTime = $timeRecord['startTime'];
            $time->endTime = $timeRecord['endTime'];
            $time->classID = $classID;

            $time->save();
        }

        //insert into class_stud_list table
        foreach ($tempErollArray as $enrollRecord){
            $class_stud_list = new class_stud_list();
            $class_stud_list->classID = $classID;
            $class_stud_list->studentID = $enrollRecord['id'];

            $class_stud_list->save();
        }


        error_log(json_encode($tempTimeArray)." @@@@@@ ".json_encode($tempErollArray));
    }

    public function resetAllClass(){
        //change class status
        DB::table('class')->update(array('status' => 0));

        //delete timeSchedule for class
        $removeTime = time::truncate();

        //delete studentList for class
        $removeEnroll = class_stud_list::truncate();
    }

    public function bkList(){
        $bkLists = DB::select('select * from bk_time');

        return view('admin/component/bkList', ['bkLists' => $bkLists]);
    }

    public function restoreList(){
        $restoreLists = DB::select('select * from bk_time');

        return view('admin/component/restoreList', ['restoreLists' => $restoreLists]);
    }

    public function bkRecordCheck($bkname){
        $exist = 0;
        $name = $bkname;
        $bk_time = DB::select('select * from bk_time where name = :name', ['name' => $name]);

        error_log(count($bk_time));
        if(count($bk_time) > 0){
            $exist = true;
        }
        error_log($exist);

        return $exist;
    }

    public function backupClasses($bkname){
        $name = $bkname;
        $bkID = "";
        $nameFilter = DB::select('select * from bk_time where name = :name', ['name' => $name]);

        if(count($nameFilter) > 0){
            $bkID = $nameFilter[0]->bktimeID;
            $deleteOrig = bk_time_detail::where('bktimeID', $bkID)->delete();
        }else{
            $bk_time = new bk_time();
            $bk_time->name = $name;

            $bk_time->save();
            $bkID = $bk_time->id;
        }
        error_log("bkid::".$bkID);
        $timeSchedules = time::all();

        foreach ($timeSchedules as $timeSchedule) {
            $bk_time_detail = new bk_time_detail();
            $bk_time_detail->Day = $timeSchedule->Day;
            $bk_time_detail->startTime = $timeSchedule->startTime;
            $bk_time_detail->endTime = $timeSchedule->endTime;
            $bk_time_detail->classID = $timeSchedule->classID;
            $bk_time_detail->bktimeID = $bkID;

            $bk_time_detail->save();
        }
    }

    public function bkrestore($bktimeID){
        error_log('bkrestore reach::'.$bktimeID);
        //get all from bktimedetail where = bktimeID
        $bkClassLists = bk_time_detail::select('classID')->where('bktimeID', $bktimeID)->groupBy('classID')->get();

        //get bktimedetail without sort where = bktimeID
        //$bkfullLists =  bk_time_detail::where('bktimeID', $bktimeID)->get();

        //loop::select from time according to class id with array
        foreach($bkClassLists as $bkClassList){
            $removeTime = time::where('classID', $bkClassList->classID)->delete();

            $bkClassTimes =  bk_time_detail::where('bktimeID', $bktimeID)->where('classID', $bkClassList->classID)->get();
            foreach($bkClassTimes as $bkClassTime){
                $time = new time();
                $time->Day = $bkClassTime->Day;
                $time->startTime = $bkClassTime->startTime;
                $time->endTime = $bkClassTime->endTime;
                $time->classID = $bkClassList->classID;

                $time->save();
            }

            DB::table('class')->where('classID', $bkClassList->classID)->update(array('status' => 1));
        }

        //loop:: delete the time record with the same classid

        //loop::loop:: loop by the element in bktimedetail with the same classid

        //loop::loop:: put data one by one into the time

        //loop::change status to 1 if 0

    }
}
