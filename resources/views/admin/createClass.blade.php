@extends('layouts.app')

@section('content')
<style>
.multisteps-form__progress {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(0, 1fr));
}

.multisteps-form__progress-btn {
  transition-property: all;
  transition-duration: 0.15s;
  transition-timing-function: linear;
  transition-delay: 0s;
  position: relative;
  padding-top: 20px;
  color: rgba(108, 117, 125, 0.7);
  text-indent: -9999px;
  border: none;
  background-color: transparent;
  outline: none !important;
  cursor: pointer;
}

@media (min-width: 500px) {
  .multisteps-form__progress-btn {
    text-indent: 0;
  }
}

.multisteps-form__progress-btn:before {
  position: absolute;
  top: 0;
  left: 50%;
  display: block;
  width: 13px;
  height: 13px;
  content: '';
  -webkit-transform: translateX(-50%);
          transform: translateX(-50%);
  transition: all 0.15s linear 0s, -webkit-transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s;
  transition: all 0.15s linear 0s, transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s;
  transition: all 0.15s linear 0s, transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s, -webkit-transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s;
  border: 2px solid currentColor;
  border-radius: 50%;
  background-color: #fff;
  box-sizing: border-box;
  z-index: 3;
}

.multisteps-form__progress-btn:after {
  position: absolute;
  top: 5px;
  left: calc(-50% - 13px / 2);
  transition-property: all;
  transition-duration: 0.15s;
  transition-timing-function: linear;
  transition-delay: 0s;
  display: block;
  width: 100%;
  height: 2px;
  content: '';
  background-color: currentColor;
  z-index: 1;
}

.multisteps-form__progress-btn:first-child:after {
  display: none;
}

.multisteps-form__progress-btn.js-active {
  color: #007bff;
}

.multisteps-form__progress-btn.js-active:before {
  -webkit-transform: translateX(-50%) scale(1.2);
          transform: translateX(-50%) scale(1.2);
  background-color: currentColor;
}

.multisteps-form__form {
  position: relative;
}

.multisteps-form__panel {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 0;
  opacity: 0;
  visibility: hidden;
}

.multisteps-form__panel.js-active {
  height: auto;
  opacity: 1;
  visibility: visible;
}

.multisteps-form__panel[data-animation="scaleIn"] {
  -webkit-transform: scale(0.9);
          transform: scale(0.9);
}

.multisteps-form__panel[data-animation="scaleIn"].js-active {
  transition-property: all;
  transition-duration: 0.2s;
  transition-timing-function: linear;
  transition-delay: 0s;
  -webkit-transform: scale(1);
          transform: scale(1);
}

div#modalContainer{
    -webkit-transition:all 800ms ease;
    overflow:hidden;
}

div.loadingForm{
    height:10em;
    border-radius:75px;
}
</style>


<div class="multisteps-form py-4">
  <!--progress bar-->
  <div class="row">
    <div class="col-12 col-lg-8 ml-auto mr-auto mb-4">
    <h2><strong>Setup Classes</strong></h2>
    <br>
      <div class="multisteps-form__progress">
        <button class="multisteps-form__progress-btn js-active" type="button" title="User Info">Class Info</button>
        <button class="multisteps-form__progress-btn" type="button" title="Address">Time Schedule</button>
        <button class="multisteps-form__progress-btn" type="button" title="Order Info">Student List</button>
        <button class="multisteps-form__progress-btn" type="button" title="Comments">Comfirm</button>
      </div>
    </div>
  </div>
  <!--form panels-->
  <div class="row">
    <div class="col-12 col-lg-8 m-auto">
      <form class="multisteps-form__form" enctype="multipart/form-data">
        <!-- basic form panel -->
        <div class="multisteps-form__panel shadow p-4 rounded bg-white js-active" data-animation="scaleIn">
          <h3 class="multisteps-form__title">Basic Class Info</h3>
          <div class="multisteps-form__content">

            <div class="form-group">
                <label for="success" class="control-label">Class Code</label>
                <input type="text" value="" name="classCode" class="form-control" id="classCode">
                <div id="classCode_invalid" class="invalid-feedback">Class Code is Required</div>
            </div>

            <div class="form-group">
                <label for="success" class="control-label">Class Name</label>
                <input type="text" value="" name="className" class="form-control" id="className">
                <div id="className_invalid" class="invalid-feedback">Class Name is Required</div>
            </div>

            <div class="form-group">
                <label for="success" class="control-label">Faculty</label>
                <select class="custom-select my-1 mr-sm-2" id="faculty">
                @foreach($facultys as $faculty)
                    <option value='{{ $faculty->id }}'>{{ $faculty->facultyName }}</option>
                @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="success" class="control-label">Lecturer</label>
                <select class="custom-select my-1 mr-sm-2" id="lecturer">
                @foreach($lecturers as $lecturer)
                    <option value='{{ $lecturer->idCode }}'>{{ $lecturer->name }}</option>
                @endforeach
                </select>
            </div>

            <div class="form-inline">
                <a class="btn btn-secondary col-md-2" href="/home" type="button" id="btnBack" name="back">BACK</a>
                <button class="btn btn-primary ml-auto js-btn-next offset-8 col-md-2" type="button" title="Next">Next</button>
            </div>

          </div>
        </div>
        <!-- time form panel -->
        <div class="multisteps-form__panel shadow p-4 rounded bg-white" data-animation="scaleIn">
          <h3 class="multisteps-form__title">Class Time Schedule Setup</h3>
          <div class="multisteps-form__content">
          <br>

            <div class="timeScheduleT">

            </div>

            <br>
            <div class="form-inline">
                <button class="btn btn-primary js-btn-prev col-md-2" type="button" title="Prev">Prev</button>
                <button class="btn btn-primary ml-auto js-btn-next offset-8 col-md-2" type="button" title="Next">Next</button>
            </div>

          </div>
        </div>
        <!-- entoll form panel -->
        <div class="multisteps-form__panel shadow p-4 rounded bg-white" data-animation="scaleIn">
            <h3 class="multisteps-form__title">Enroll Students List</h3>
            <div class="multisteps-form__content">

            here can choose between two method to input the enroll student list.
            <br>
            <br>
            <h5><strong>Input using file</strong></h5>

            <div class="excelImport">

                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="uploadExcel">
                        <label class="custom-file-label" for="uploadExcel">Choose Excel File (exp: .xlsx, .xls, .csv)</label>
                    </div>
                    <button class="btn btn-info btn-sm mt-2 col-sm-2" type="button" id="btnImport" name="btnImport" >IMPORT</button>

            </div>

            <br>
            <br>
            <h5><strong>Input manually</strong></h5>
            <div class="StudentList">

            </div>

            <br>
            <div class="form-inline">
                <button class="btn btn-primary js-btn-prev col-md-2" type="button" title="Prev">Prev</button>
                <button class="btn btn-primary ml-auto js-btn-next offset-8 col-md-2" type="button" title="Next">Next</button>
            </div>

          </div>
        </div>
        <!-- comfirm form panel -->
        <div class="multisteps-form__panel shadow p-4 rounded bg-white" data-animation="scaleIn">
          <h3 class="multisteps-form__title">Comfirmation</h3>
          <div class="multisteps-form__content">

            <div>
            <!-- basic detail card -->
            <div class="card" style="background:#e1e3e4;">
                <div class="card-body">
                    <h5 class="card-title">Basic Class Detail</h5>

                    <div class="form-group">
                        <label for="success" class="control-label">Class Code</label>
                        <input type="text" value="" name="cf_classCode" class="form-control cf-form" id="cf_classCode" readonly>
                    </div>

                    <div class="form-group">
                        <label for="success" class="control-label">Class Name</label>
                        <input type="text" value="" name="cf_className" class="form-control cf-form"  id="cf_className" readonly>
                    </div>

                    <div class="form-group">
                        <label for="success" class="control-label">Faculty</label>
                        <input type="text" value="" name="cf_faculty" class="form-control cf-form"  id="cf_faculty" readonly>
                    </div>

                    <div class="form-group">
                        <label for="success" class="control-label">Lecturer</label>
                        <input type="text" value="" name="cf_lecturer" class="form-control cf-form"  id="cf_lecturer" readonly>
                    </div>
                </div>
            </div>

            <!-- Time Schedule card -->
            <div class="card mt-3" style="background:#e1e3e4;">
                <div class="card-body">
                    <h5 class="card-title">Time Schedule</h5>

                    <table id="timeTable_comfirm" class="table table-striped table-bordered"  cellspacing="0" style="width: 100%; margin:0px; background-color:white; table-layout: fixed;">
                        <thead>
                            <tr>
                                <th scope="col">Day</th>
                                <th scope="col">Start Time</th>
                                <th scope="col">Edit Time</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>
            </div>


            <!-- Enroll Students List card -->
            <div class="card mt-3" style="background:#e1e3e4;">
                <div class="card-body">
                    <h5 class="card-title">Enroll Students</h5>

                    <table id="enrollStudents_comfirm" class="table table-striped table-bordered"  cellspacing="0" style="width: 100%; margin:0px; background-color:white; table-layout: fixed;">
                        <thead>
                            <tr>
                                <th scope="col">StudentID</th>
                                <th scope="col">Student Name</th>
                                <th scope="col">batch</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>
            </div>


            </div>

            <div class="button-row d-flex mt-4" id="comfirmPanel">
                <button class="btn btn-primary js-btn-prev col-md-2" type="button" title="Prev">Prev</button>
                <button class="btn btn-success ml-auto offset-8 col-md-2" type="button" id="btnCreate" >Create</button>
            </div>
          </div>
        </div>
      </form>
     </div>
  </div>
</div>

<div class="modal fade" name="addTImeModal" id="addTImeModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Time Schedule</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="TimeSchedule modal-body">
        <div class="ml-2 mr-2">
            <div class="form-group row justify-content-center">
                <label for="success" class="control-label col-sm-6">Day</label>
                <select class="custom-select col-sm-6" id="day">
                    <option value='monday'>Monday</option>
                    <option value='tuesday'>Tuesday</option>
                    <option value='wednesday'>wednesday</option>
                    <option value='thursday'>Thursday</option>
                    <option value='friday'>Friday</option>
                </select>
            </div>
            <div class="form-group row">
                <label for="success" class="control-label col-sm-6">Start Time</label>
                <input id="startTime" class="form-control" width="240" required="required" readonly>
            </div>
            <div class="form-group row justify-content-center">
                <label for="success" class="control-label col-sm-6">End Time</label>
                <input id="endTime" class="form-control" width="240" required="required" readonly>
            </div>
        </div>

      </div>
      <div class="modal-footer timeFooter">
            <button class="btn btn-primary col-sm-2" type="button" id="btnTimeAdd" name="btnTimeAdd">ADD</button>
            <button class="btn btn-secondary col-sm-2" data-dismiss="modal" title="CLOSE">CLOSE</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" name="addEnrollModal" id="addEnrollModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Enroll Student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="EnrollStudent modal-body">

        <div class="ml-2 mr-2">

            <div class="form-group">
                <label for="success" class="control-label">Student ID</label>
                <input type="text" value="" name="studID" class="form-control" id="studID" placeholder="exp: D190030B">
                <div id="studID_invalid" class="invalid-feedback">
                </div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="Continue">
                    <label class="custom-control-label" for="Continue">Continue?</label>
                </div>
            </div>

        </div>

      </div>
      <div class="modal-footer studFooter" >
            <button class="btn btn-primary btn-sm col-sm-3" type="button" id="btnErollStud" name="btnErollStud">ADD</button>
            <button class="btn btn-secondary btn-sm col-sm-3" data-dismiss="modal" title="CLOSE">CLOSE</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" name="loadingModal" id="loadingModal" data-backdrop="static" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content loadingForm" id="modalContainer">
        <div class='d-flex justify-content-center '>
            <div style='margin-top:4em; margin-bottom:4em;' class='spinner-border' role='status'>
                <span class='sr-only'>Loading...</span>
            </div>
        </div>
    </div>
  </div>
</div>

<script>
//stage panel management/controller
const DOMstrings = {
  stepsBtnClass: 'multisteps-form__progress-btn',
  stepsBtns: document.querySelectorAll(`.multisteps-form__progress-btn`),
  stepsBar: document.querySelector('.multisteps-form__progress'),
  stepsForm: document.querySelector('.multisteps-form__form'),
  stepsFormTextareas: document.querySelectorAll('.multisteps-form__textarea'),
  stepFormPanelClass: 'multisteps-form__panel',
  stepFormPanels: document.querySelectorAll('.multisteps-form__panel'),
  stepPrevBtnClass: 'js-btn-prev',
  stepNextBtnClass: 'js-btn-next' };



const removeClasses = (elemSet, className) => {

  elemSet.forEach(elem => {

    elem.classList.remove(className);

  });

};


const findParent = (elem, parentClass) => {

  let currentNode = elem;

  while (!currentNode.classList.contains(parentClass)) {
    currentNode = currentNode.parentNode;
  }

  return currentNode;

};

const getActiveStep = elem => {
  return Array.from(DOMstrings.stepsBtns).indexOf(elem);
};


const setActiveStep = activeStepNum => {


  removeClasses(DOMstrings.stepsBtns, 'js-active');


  DOMstrings.stepsBtns.forEach((elem, index) => {

    if (index <= activeStepNum) {
      elem.classList.add('js-active');
    }

  });
};


const getActivePanel = () => {

  let activePanel;

  DOMstrings.stepFormPanels.forEach(elem => {

    if (elem.classList.contains('js-active')) {

      activePanel = elem;

    }

  });

  return activePanel;

};


const setActivePanel = activePanelNum => {


  removeClasses(DOMstrings.stepFormPanels, 'js-active');


  DOMstrings.stepFormPanels.forEach((elem, index) => {
    if (index === activePanelNum) {

      elem.classList.add('js-active');
      //current page
      //update time schedule table and student table in page 3
      if(index == 3){
        $("#timeTable_comfirm tbody").find("tr").remove();
        $("#enrollStudents_comfirm tbody").find("tr").remove();

        comfirmBasic();
        comfirmTime();
        comfirmEnroll();
      }

      setFormHeight(elem);

    }
  });

};


const formHeight = activePanel => {

  const activePanelHeight = activePanel.offsetHeight;

  DOMstrings.stepsForm.style.height = `${activePanelHeight}px`;

};

const setFormHeight = () => {
  const activePanel = getActivePanel();

  formHeight(activePanel);
};


DOMstrings.stepsBar.addEventListener('click', e => {


  const eventTarget = e.target;

  if (!eventTarget.classList.contains(`${DOMstrings.stepsBtnClass}`)) {
    return;
  }


  const activeStep = getActiveStep(eventTarget);


  setActiveStep(activeStep);


  setActivePanel(activeStep);
});


DOMstrings.stepsForm.addEventListener('click', e => {

  const eventTarget = e.target;


  if (!(eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`) || eventTarget.classList.contains(`${DOMstrings.stepNextBtnClass}`)))
  {
    return;
  }


  const activePanel = findParent(eventTarget, `${DOMstrings.stepFormPanelClass}`);

  let activePanelNum = Array.from(DOMstrings.stepFormPanels).indexOf(activePanel);


  if (eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`)) {
    activePanelNum--;

  } else {
    activePanelNum++;

    switch(activePanelNum) {
        case 1:
            $('.form-control').removeClass('is-invalid');
            if($('#classCode').val() === "" || $('#className').val() === ""){
                activePanelNum--;
                if($('#classCode').val() === ""){
                    $('#classCode').addClass('is-invalid');
                }

                if($('#className').val() === ""){
                    $('#className').addClass('is-invalid');
                }
            }
            break;
        case 2:
            if(tempTimeArray.length === 0){
                activePanelNum--;
                alert("no time");
            }
            break;
        case 3:
            if(tempErollArray.length === 0){
                activePanelNum--;
                alert("no enroll");
            }
            break;
    }



  }

  setActiveStep(activePanelNum);
  setActivePanel(activePanelNum);

});


window.addEventListener('load', setFormHeight, false);


window.addEventListener('resize', setFormHeight, false);

document.querySelector('.custom-file-input').addEventListener('change',function(e){
  var fileName = document.getElementById("uploadExcel").files[0].name;
  var nextSibling = e.target.nextElementSibling
  nextSibling.innerText = fileName
})

$('#startTime').timepicker({
    uiLibrary: 'bootstrap4'
    //showOtherMonths: true
});

$('#endTime').timepicker({
    uiLibrary: 'bootstrap4'
    //showOtherMonths: true
});

var tempTimeArray = [];
var tempErollArray = [];

$('.timeFooter').on('click','#btnTimeAdd',function(e){
    e.preventDefault();
    $('#startTime').removeClass("is-invalid");
    $('#endTime').removeClass("is-invalid");

    if($('#startTime').val() == ""){
      $('#startTime').addClass("is-invalid");
    }else if($('#endTime').val() == ""){
      $('#endTime').addClass("is-invalid");
    }else{

      let _token   = $('meta[name="csrf-token"]').attr('content');
      var Day = $('#day').val();
      var startTime = $('#startTime').val();
      var endTime = $('#endTime').val();

      tempTimeArray.push({Day:Day, startTime:startTime, endTime:endTime})

      $('#addTImeModal').modal('hide');

      //POST method for timeTable
      $.ajax({
          type: "POST",
          url: "/T_TimeClassCreate",
          data: {
              records: tempTimeArray,
              _token: _token
          },
          success:function (data) {
              $('.timeScheduleT').html(data);

              $('#day').val('Monday');
              $('#startTime').val('');
              $('#endTime').val('');
          }
      });
    }
});

$(document).ready(function uptable(){

    //GET method for timeTable
    $.ajax({
         type: "GET",
         url: "/T_TimeClassCreate",
         data: '_token = <?php echo csrf_token() ?>',
         success:function (data) {
             $('.timeScheduleT').html(data);
         }
    });

    //GET method for enrollStudent
    $.ajax({
         type: "GET",
         url: "/T_EnrollStudentList",
         data: '_token = <?php echo csrf_token() ?>',
         success:function (data) {
             $('.StudentList').html(data);
         }
    });

});

$('.timeScheduleT').on('click','.timeRemove',function(event){
    //var button = $(event.relatedTarget);
    var timeIndex = $(this).data('id');
    let _token   = $('meta[name="csrf-token"]').attr('content');
    tempTimeArray.splice(timeIndex,1);

    $.ajax({
         type: "POST",
         url: "/T_TimeClassCreate",
         data: {
             records: tempTimeArray,
             _token: _token
        },
         success:function (data) {
             $('.timeScheduleT').html(data);
         }
    });
});

$('.studFooter').on('click','#btnErollStud',function(e){
    e.preventDefault();
    $('#studID').removeClass("is-invalid");

    var studID = $('#studID').val();
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var dataString = "/checkStudID/" + studID;

    $.ajax({
        type: "GET",
        url: dataString,
        success: function (data){

            if(data.length > 0){
                var checkID = (element) => element.id === data[0]['idCode'];

                if(tempErollArray.some(checkID)){
                    $('#studID').addClass("is-invalid");
                    $('#studID_invalid').html("Student already enroll");
                }else{
                    tempErollArray.push(data[0]);

                    $.ajax({
                        type: "POST",
                        url: "/T_EnrollStudentList",
                        data: {
                            records: tempErollArray,
                            _token: _token
                        },
                        success:function (data) {
                            $('.StudentList').html(data);

                            $('#studID').val('');
                            $('#studID').focus();
                        }
                    });

                    if($('#Continue').prop("checked") !== true){
                        $('#addEnrollModal').modal('hide');
                    }
                }
            }else{
                $('#studID').addClass("is-invalid");
                $('#studID_invalid').html("Student Record Not Exist");
            }

        },
        error: function (err) {
            if (err.status == 404){
                $('#studID').addClass("is-invalid");
                $('#studID_invalid').html("Student ID field cannot been empty");
            }
        }
    });
});

$('.StudentList').on('click','.studRemove',function(event){
    //var button = $(event.relatedTarget);
    var studIndex = $(this).data('id');
    let _token   = $('meta[name="csrf-token"]').attr('content');
    tempErollArray.splice(studIndex,1);

    $.ajax({
         type: "POST",
         url: "/T_EnrollStudentList",
         data: {
             records: tempErollArray,
             _token: _token
        },
         success:function (data) {
             $('.StudentList').html(data);
         }
    });
});

$('.excelImport').on('click','#btnImport',function(event){
    var fd = new FormData();
    var excelFile = $('#uploadExcel')[0].files[0];
    let _token   = $('meta[name="csrf-token"]').attr('content');
    fd.append('excelFile', excelFile);
    fd.append('_token', _token);

    $('#loadingModal').modal('show');

    $.ajax({
        type: "POST",
        url: "/excelExtract",
        contentType: false,
        processData: false,
        data: fd,
        success:function (data) {
            //console.log(JSON.stringify(data));
            checkInsertData(data);

        }
      });

});

function checkInsertData(data){
    var promises = [];

    $.each(data, function(index, item){
        var studID = item[0];
        var dataString = "/checkStudID/" + studID;
        let _token   = $('meta[name="csrf-token"]').attr('content');

        promises.push($.ajax({
            type: "GET",
            url: dataString,
            success: function (data){

                if(data.length > 0){
                    var checkID = (element) => element.id === data[0]['idCode'];

                    if(!tempErollArray.some(checkID)){
                        console.log(JSON.stringify(data[0]));
                        tempErollArray.push(data[0]);

                        $.ajax({
                            type: "POST",
                            url: "/T_EnrollStudentList",
                            data: {
                                records: tempErollArray,
                                _token: _token
                            },
                            success:function (data) {
                                $('.StudentList').html(data);


                            }
                        });
                    }
                }

            }
        }));
    });

    $.when.apply($, promises).then(function(){
        $('#loadingModal').modal('hide');
    });


}

function comfirmTime(){
    $.each(tempTimeArray, function(index, value){
        $('#timeTable_comfirm tbody').append("<tr><td>"+value['Day']+"</td><td>"+value['startTime']+"</td><td>"+value['endTime']+"</td></tr>");
    });

}

function comfirmEnroll(){
    $.each(tempErollArray, function(index, value){
        $('#enrollStudents_comfirm tbody').append("<tr><td>"+value['idCode']+"</td><td>"+value['name']+"</td><td>"+value['batch']+"</td></tr>");
    });

}

function comfirmBasic(){
    $('.cf-form').val('');

    $('#cf_classCode').val($('#classCode').val());
    $('#cf_className').val($('#className').val());
    $('#cf_faculty').val($('#faculty option:selected').text());
    $('#cf_lecturer').val($('#lecturer option:selected').text());

}

$('#comfirmPanel').on('click','#btnCreate',function(e){
    e.preventDefault();

    var classCode = $('#classCode').val();
    var className = $('#className').val();
    var facultyID = $('#faculty').val();
    var lecturerID = $('#lecturer').val();
    var timeArray = tempTimeArray;
    var erollArray = tempErollArray;

    let _token   = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        type: "POST",
        url: "/insertClass",
        data: {
            classCode: classCode,
            className: className,
            facultyID: facultyID,
            lecturerID: lecturerID,
            timeArray: timeArray,
            erollArray: erollArray,
            _token: _token
        },
        cache: false,
        success: function (data) {
            window.location.href = "/home";
        }
    });
})

</script>


@endsection
