<?php

use Illuminate\Support\Facades\Route;
use App\Mail\notifyMail;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('/auth/login');
});

// Route::get('/email', function () {
//      return new notifyMail();
//  });

Auth::routes([
    'register' => false
]);

Route::get('/home', 'HomeController@index')->name('home');

//admin panel
Route::get('/DT_stud', 'DataTableController@stud');
Route::get('/DT_lectur', 'DataTableController@lectur');
Route::get('/DT_class', 'DataTableController@class');
Route::get('/ClassStudList/{id}', 'DataTableController@classStud');
Route::get('/T_TimeClassCreate', 'DataTableController@getTimeClassCreate');
Route::post('/T_TimeClassCreate', 'DataTableController@postTimeClassCreate');
Route::get('/T_EnrollStudentList', 'DataTableController@getEnrollStudentList');
Route::post('/T_EnrollStudentList', 'DataTableController@postEnrollStudentList');

Route::get('/getStud/{id}', 'AdminController@getStud');
Route::get('/getLectur/{id}', 'AdminController@getLectur');
Route::get('/getClass/{id}', 'AdminController@getClass');

Route::get('/home/createStud', 'AdminController@createStud');
Route::get('/home/createLectur', 'AdminController@createLectur');
Route::get('/home/createClass', 'AdminController@createClass');

Route::get('/home/editStud/{id}', 'AdminController@editStud');
Route::get('/home/editLect/{id}', 'AdminController@editLect');

Route::post('/insertStud', 'AdminController@storeStud');
Route::post('/updateStud', 'AdminController@updateStud');
Route::post('/insertLect', 'AdminController@storeLect');
Route::post('/updateLect', 'AdminController@updateLect');
Route::post('/insertClass', 'AdminController@storeClass');
Route::post('/updateClass', 'AdminController@updateClass');
Route::post('/emailPass', 'AdminController@emailPass');
Route::get('/checkStudID/{id}', 'AdminController@checkStudID');
Route::post('/targetStatusChange', 'AdminController@targetStatusChange');

Route::get('/resetSingle/{id}', 'AdminController@resetSingle');
Route::get('/resetAllClass', 'AdminController@resetAllClass');
Route::get('/home/setupClass/{id}', 'AdminController@setupClass');
Route::get('/bkList', 'AdminController@bkList');
Route::get('/bkRecordCheck/{bkname}', 'AdminController@bkRecordCheck');
Route::get('/backupClasses/{bkname}', 'AdminController@backupClasses');

Route::get('/restoreList', 'AdminController@restoreList');
Route::get('/bkrestore/{bktimeID}', 'AdminController@bkrestore');

Route::post('/excelExtract', 'ExcelController@excelExtract');

//lecturer panel
Route::get('/lect/getClasses', 'LecturerController@getClasses');
Route::get('/lect/getTimeAdj', 'LecturerController@getTimeAdj');
Route::get('/lect/getDashboard', 'LecturerController@getDashboard');
Route::get('/home/class/{id}', 'LecturerController@classPage');

Route::get('/lect/setup_timeSch/{id}', 'LecturerController@setup_timeSch');
Route::get('/lect/setup_studList/{id}', 'DataTableController@getClassStudentsList');
Route::get('/lect/checkStudID/{id}/{classID}', 'LecturerController@checkStudID');
Route::get('/lect/enrollStudent/{id}/{classID}', 'LecturerController@enrollStudent');
Route::post('/lect/removeEnrollStud', 'LecturerController@removeEnrollStud');
Route::get('/lect/getPieString/{id}', 'LecturerController@getPieString');
Route::get('/lect/T_gradingTable/{id}', 'DataTableController@getGradTable');
Route::post('/lect/addGradingSch', 'LecturerController@addGradingSch');
Route::get('/lect/removeGradString/{id}/{gradingID}', 'LecturerController@removeGradString');
Route::get('/lect/getClassesCard/{id}', 'LecturerController@getClassesCard');
Route::get('/home/class/{id}/createExam', 'LecturerController@createExam');

Route::get('/lect/exam/addQuestion/{qNumb}', 'LecturerController@addQuestion');
Route::post('/lect/SaveExam', 'LecturerController@saveExam');
Route::post('/lect/updateExam', 'LecturerController@updateExam');
Route::get('/lect/class/getExamDetail/{id}', 'LecturerController@getExamDetail');
Route::get('/home/class/{classID}/exam/{id}', 'LecturerController@editExam');

Route::get('/home/createTimeAdj', 'LecturerController@createTimeAdj');
Route::get('/lect/getTimeSelect/{id}', 'LecturerController@getTimeSelect');
Route::post('/lect/saveTimeAdj', 'LecturerController@saveTimeAdj');
Route::get('/lect/getTimeAdjDetail/{id}', 'LecturerController@getTimeAdjDetail');

Route::get('/lect/exam/mark/{id}', 'LecturerController@examMark');
Route::post('/exam/getSubmition', 'LecturerController@getSubmition');
Route::post('/exam/saveExamMark', 'LecturerController@saveExamMark');

Route::get('/lect/getAssignCard/{id}', 'LecturerController@getAssignCard');
Route::get('/home/class/{id}/createAssign', 'LecturerController@createAssign');
Route::post('/lect/saveAssignment', 'LecturerController@saveAssignment');

Route::get('/lect/class/getAssignDetail/{id}', 'LecturerController@getAssignDetail');
Route::get('/home/class/{classID}/assign/{id}', 'LecturerController@editAssign');
Route::post('/lect/updateAssignment', 'LecturerController@updateAssignment');
Route::get('/lect/assign/mark/{id}', 'LecturerController@assignMark');
Route::post('/assign/getSubmission', 'DataTableController@getAssignSubmission');

Route::get('/assign/submitDownload/{id}', 'LecturerController@submitDownload');
Route::post('/assign/saveAssignMark', 'LecturerController@saveAssignMark');

Route::get('/assign/allAssignDownload/{id}', 'ZipController@allAssignDownload');
Route::post('/assign/saveAssignMarkAll', 'LecturerController@saveAssignMarkAll');



//student Panel
Route::get('/stud/getTimeSpecificTimeTable', 'StudentController@getTimeSpecificTimeTable');
Route::get('/stud/getClasses', 'StudentController@getClasses');
Route::get('/home/class/stud/{id}', 'StudentController@getStudClass');

Route::get('/stud/getInfor/{id}', 'StudentController@getInfor');
Route::get('/stud/getCarry/{id}', 'StudentController@getCarry');
Route::get('/stud/getTimeAdjDetail/{id}', 'LecturerController@getTimeAdjDetail');
Route::get('/stud/class/getExamDetail/{id}', 'LecturerController@getExamDetail');
Route::get('/stud/class/{classID}/exam/{id}', 'StudentController@examPage');
Route::get('/stud/checkExam/{classID}/{id}', 'StudentController@examCheck');
Route::post('/stud/submitExam', 'StudentController@submitExam');

Route::get('/stud/exam/submitSuccess', 'StudentController@submitSuccess');
Route::get('/stud/exam/submitReject', 'StudentController@submitReject');

Route::get('/stud/class/getAssignDetail/{id}', 'LecturerController@getAssignDetail');
Route::get('/stud/class/{classID}/assign/{id}', 'StudentController@assignPage');
Route::get('/stud/checkAssign/{classID}/{id}', 'StudentController@checkAssign');

Route::post('/stud/submitAssignment', 'StudentController@submitAssignment');

Route::get('/stud/assign/submitSuccess', 'StudentController@submitSuccess');
Route::get('/stud/assign/submitReject', 'StudentController@submitReject');


//fileDownload
Route::get('/fileDownload/{id}', 'LecturerController@fileDownload');
