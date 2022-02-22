@extends('layouts.app')

@section('content')
<style>
.wrapper {
    display: flex;
    align-items: stretch;
}

#sidebar {
    min-width: 250px;
    max-width: 250px;
    min-height: 100vh;
    z-index: 999;
    background: #7386D5;
    color: #fff;
    min-height: 100vh;
    transition: all 0.3s;
}

a[data-toggle="collapse"] {
    position: relative;
}

p {
    font-size: 1.1em;
    font-weight: 300;
    line-height: 1.7em;
    color: #999;
}

a, a:hover, a:focus {
    color: inherit;
    text-decoration: none;
    transition: all 0.3s;
}

#sidebar, a[aria-controls] {
    /* don't forget to add all the previously mentioned styles here too */
    background: #7386D5;
    color: #fff;
    transition: all 0.3s;
}

#sidebar .sidebar-header {
    padding: 20px;
    background: #6d7fcc;
}

#sidebar ul.components {
    padding: 20px 0;
    border-bottom: 1px solid #47748b;
}

#sidebar ul p {
    color: #fff;
    padding: 10px;
}

#sidebar ul li  {
    padding: 10px;
    font-size: 1.1em;
    display: block;
}
/* change color when hover above */
#sidebar ul li a:hover {
    color: #7386D5;
    background: #fff;
}
/* background color of drop down main item after click */
a[aria-expanded="true"] {
    color: #fff;
    background: #6d7fcc;
}

/* background color of drop down item */
ul ul a {
    font-size: 0.9em !important;
    padding-left: 30px !important;
    background: #6d7fcc;
}

.list-group-item-action.active {
    color: #fff;
    background: #6d7fcc;
    border-style: none;
}
.dataTables_filter {
   float: right;
}

.dataTables_paginate{
    float: right;
}
#btnAdd{
    float: right;
    margin-right:5px;
}

.textRed{
    color: red;
}

.textGreen{
    color: green;
}

.textOrange{
    color: orange;
}

.itemList{
    border-radius: 25px;
}

div.modal-content{
    -webkit-transition:all 800ms ease;
    overflow:hidden;
}

div.displayForm{
    height: 60em;
    border-radius:10px;
}

div.loadingForm{
    height:10em;
    border-radius:75px;
}

</style>
<script>document.getElementsByTagName("html")[0].className += " js";</script>

<div class="wrapper">
    <!-- Sidebar -->
    <nav id="sidebar">
    <br>


        <ul class="list-unstyled components sideul border-0" role="tablist">
            <div class="list-group border-0" id="list-tab" role="tablist">
                <a class="sideul list-group-item list-group-item-action border-0" id="list-timeSch-list" href="/home" role="tab" aria-controls="timeSch">Back  <i class="fas fa-chevron-circle-left"></i></a>

                <a class="sideul list-group-item list-group-item-action border-0 active" id="list-timeSch-list" data-toggle="list" href="#list-timeSch" role="tab" aria-controls="timeSch">Time Schedule</a>
                <a class="sideul list-group-item list-group-item-action border-0" id="list-studList-list" data-toggle="list" href="#list-studList" role="tab" aria-controls="studList">Students List</a>

                <a class="sideul list-group-item list-group-item-action border-0" id="list-exam-list" data-toggle="list" href="#list-exam" role="tab" aria-controls="exam">Exam Lists</a>
                <a class="sideul list-group-item list-group-item-action border-0" id="list-assign-list" data-toggle="list" href="#list-assign" role="tab" aria-controls="assign">Assignment Lists</a>

                <a class="sideul list-group-item list-group-item-action border-0" id="list-grading-list" data-toggle="list" href="#list-grading" role="tab" aria-controls="grading">Grading</a>
            </div>
        </ul>

    </nav>
    <!-- Page Content -->
    <div class="content py-4 w-75" >
        <input type="hidden" value="{{ $classDetail->classID }}" id="classID"/>
        <div class="tab-content" id="nav-tabContent">
            <!-- Dash Board -->
            <div class="tab-pane fade" id="list-dashboard" role="tabpanel" aria-labelledby="list-dashboard-list">
                Dashboard
            </div>

            <!-- time Board -->
            <div class="tab-pane fade show active" id="list-timeSch" role="tabpanel" aria-labelledby="list-timeSch-list">
                <h3 class="font-weight-bold ml-5">Classes Time Schedule</h3>
                <div id="TimeSch_panel">

                </div>
            </div>

            <!-- Students Board -->
            <div class="tab-pane fade ml-5" id="list-studList" role="tabpanel" aria-labelledby="list-studList-list">
                <h3 class="font-weight-bold mb-4">Classes Students List</h3>
                <div id="studList_panel">

                </div>
            </div>

            <!-- exam Board -->
            <div class="tab-pane fade ml-5" id="list-exam" role="tabpanel" aria-labelledby="list-exam-list">
                <h3 class="font-weight-bold ">Exam List</h3>
                <a href="\home\class\{{ $classDetail->classID }}\createExam" class="btn btn-primary mb-2">CREATE NEW EXAM</a>

                <div id="exam_panel">

                </div>

            </div>

            <!-- assignment Board -->
            <div class="tab-pane fade ml-5" id="list-assign" role="tabpanel" aria-labelledby="list-assign-list">
                <h3 class="font-weight-bold ">Assignment List</h3>
                <a href="\home\class\{{ $classDetail->classID }}\createAssign" class="btn btn-primary mb-2">CREATE ASSIGNMENT</a>

                <div id="assign_panel">

                </div>
            </div>

            <!-- carry Mark Board -->
            <div class="tab-pane fade ml-5" id="list-grading" role="tabpanel" aria-labelledby="list-grading-list">
                <h3 class="font-weight-bold mb-4">Grading Schema</h3>
                <div class="container justify-content-center" id="grading_panel">

                    <div class="row col-lg-4 col-md-6 col-sm-8 mx-auto">
                        <canvas id="gradingPie" width="400" height="400"></canvas>
                    </div>

                    <div id="gradingTablePanel" class="row col-sm-8 mx-auto">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ADD NEW student into the class -->
<div class="modal fade" name="addStudModal" id="addStudModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Enroll Student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

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
      <div class="modal-footer AddStudentFooter" >
            <button class="btn btn-primary btn-sm col-sm-3" type="button" id="btnErollStud" name="btnErollStud">ADD</button>
            <button class="btn btn-secondary btn-sm col-sm-3" data-dismiss="modal" title="CLOSE">CLOSE</button>
      </div>
    </div>
  </div>
</div>

<!-- remove existing student in the class -->
<div class="modal fade" name="removeComfirmModal" id="removeComfirmModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Comfirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <span>Are you sure you wanted to remove this student from the class?</span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" value="" id="btnRemoveComfirm">YES</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">NO</button>
      </div>
    </div>
  </div>
</div>

<!-- add grading schema model  -->
<div class="modal fade" name="addGradingModal" id="addGradingModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Grading Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="ml-2 mr-2">

            <div class="form-group">
                <label for="success" class="control-label">Grading Name</label>
                <input type="text" value="" name="gradingName" class="form-control" id="gradingName" placeholder="exp: Test 1">
                <div id="gradingName_invalid" class="invalid-feedback">Grading Name Cannot be empty</div>
            </div>

            <div class="form-group">

                    <label class="control-label">Grading Mark/%</label>
                    <span class="text-muted">( Max: <span id="maxGrad"></span> )</span>


                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="button" id="markSub">-</button>
                    </div>
                    <input type="text" class="form-control text-center" id="gradingMark" value="0" readonly>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="markAdd">+</button>
                    </div>

                    <div id="gradingMark_invalid" class="invalid-feedback">Grading Mark Cannot be 0</div>
                </div>

            </div>

        </div>

      </div>
      <div class="modal-footer" >
            <button class="btn btn-primary btn-sm col-sm-3" type="button" id="btnAddGradSch" name="btnAddGradSch">ADD</button>
            <button class="btn btn-secondary btn-sm col-sm-3" data-dismiss="modal" title="CLOSE">CLOSE</button>
      </div>
    </div>
  </div>
</div>

<!-- Exam Item Detail Modal -->
<div class="modal fade" name="examModal" id="examModal" tabindex="-1" role="dialog">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content loadingForm" id="e_modalContainer">
        <div class='d-flex justify-content-center '>
            <div style='margin-top:4em; margin-bottom:4em;' class='spinner-border' role='status'>
                <span class='sr-only'>
                    Loading...
                </span>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Assignment Item Detail Modal -->
<div class="modal fade" name="assignModal" id="assignModal" tabindex="-1" role="dialog">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content loadingForm" id="a_modalContainer">
        <div class='d-flex justify-content-center '>
            <div style='margin-top:4em; margin-bottom:4em;' class='spinner-border' role='status'>
                <span class='sr-only'>
                    Loading...
                </span>
            </div>
        </div>
    </div>
</div>
</div>


<script>
var myPieChart;

$(document).ready(function uptable(){
    var classID = $('#classID').val();
    var setTimeString = "/lect/setup_timeSch/" + classID;
    var setStudString = "/lect/setup_studList/" + classID;
    var getPieString = "/lect/getPieString/" + classID;
    var getGradTable = "/lect/T_gradingTable/" + classID;
    var getExamCard = "/lect/getClassesCard/" + classID;
    var getAssignCard = "/lect/getAssignCard/" + classID;

    var ctx = $('#gradingPie');
    //time schedule table
    $.ajax({
        type: "GET",
        url: setTimeString,
        data: '_token = <?php echo csrf_token() ?>',
        success:function (data) {
            $('#TimeSch_panel').html(data);
        }
    });

    //student List table
    $.ajax({
        type: "GET",
        url: setStudString,
        data: '_token = <?php echo csrf_token() ?>',
        success:function (data) {
            $('#studList_panel').html(data);
        }
    });

    //load Exam List/Card
    $.ajax({
        type: "GET",
        url: getExamCard,
        data: '_token = <?php echo csrf_token() ?>',
        success:function (data) {
            $('#exam_panel').html(data);
        }
    });

    //load Assignment List/Card
    $.ajax({
        type: "GET",
        url: getAssignCard,
        data: '_token = <?php echo csrf_token() ?>',
        success:function (data) {
            $('#assign_panel').html(data);
        }
    });

    //pie get data
    $.ajax({
        type: "GET",
        url: getPieString,
        data: '_token = <?php echo csrf_token() ?>',
        success:function (data) {
            var gradingValueSet = new Array();
            var gradingNameSet = new Array();
            var gradingColorSet = new Array();
            var emptyAmount = 100;

            $.each(data, function( index, value ) {
                emptyAmount -= value['gradingPercentage'];
                gradingNameSet.push(value['gradingType']);
                gradingValueSet.push(value['gradingPercentage']);
                gradingColorSet.push(getRandomColor());
            });

            gradingValueSet.push(emptyAmount);
            gradingNameSet.push('Empty');
            gradingColorSet.push('rgba(0, 0, 0, 0.1)');

            $('#maxGrad').html(emptyAmount);

            //pie
            myPieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    datasets: [{
                        data: gradingValueSet,
                        backgroundColor: gradingColorSet
                    }],


                    // These labels appear in the legend and in the tooltips when hovering different arcs
                    labels: gradingNameSet
                }
            });
        }
    });

    //getGradingTable
    $.ajax({
        type: "GET",
        url: getGradTable,
        data: '_token = <?php echo csrf_token() ?>',
        success:function (data) {
            $('#gradingTablePanel').html(data);
        }
    });

});

//@bStudentList->Addstudent Modal btn
$('.AddStudentFooter').on('click', '#btnErollStud', function(event){
    event.preventDefault();
    $('#studID').removeClass("is-invalid");

    var studID = $('#studID').val();
    var classID = $('#classID').val();
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var dataString = "/lect/checkStudID/" + studID + "/" + classID;

    $.ajax({
        type: "GET",
        url: dataString,
        success: function (data){
            //0 = have record, not enroll
            //1 = no record
            //2 = have record, enrolled
            if(data <= 0){
                var dataString = "/lect/enrollStudent/" + studID + "/" + classID;

                $.ajax({
                    type: "GET",
                    url: dataString,
                    success: function (data){

                        var setStudString = "/lect/setup_studList/" + classID;
                        //student List table
                        $.ajax({
                            type: "GET",
                            url: setStudString,
                            data: '_token = <?php echo csrf_token() ?>',
                            success:function (data) {
                                $('#studList_panel').html(data);
                            }
                        });

                        $('#studID').val('');
                        $('#studID').focus();
                    }
                });

                if($('#Continue').prop("checked") !== true){
                    $('#addStudModal').modal('hide');
                }
            }else{
                var errorString = "";

                if(data == 1){
                    errorString = "Student ID not Exist";
                }else{
                    errorString = "Student already Enrolled";
                }

                $('#studID').addClass("is-invalid");
                $('#studID_invalid').html(errorString);
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

//when the remove student comfirmation modal show up
$(document).on('shown.bs.modal', '#removeComfirmModal', function (event) {
    var button = $(event.relatedTarget)
    var student = button.data('id');

    $('#btnRemoveComfirm').val(student);
});

//when the remove student comfirmation modal show up
$('#examModal').on('shown.bs.modal', function (event) {
    var classID = $('#classID').val();
    var button = $(event.relatedTarget);
    var examID = button.data('id');
    var subRate = button.data('subrate');
    var getExamDetail = "/lect/class/getExamDetail/" + examID;

    $.ajax({
        type: "GET",
        url: getExamDetail,
        data: '_token = <?php echo csrf_token() ?>',
        success:function (data) {
            document.getElementById('e_modalContainer').classList.add('displayForm');
            document.getElementById('e_modalContainer').classList.remove('loadingForm');

            $('#e_modalContainer').html(data);
            $('.examFooter').html('<button class="btn btn-success" name="exam_mark" id="exam_mark" >MARK</button><a class="btn btn-danger" href="" name="exam_edit" id="exam_edit" >EDIT</a><button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>');

            $('#exam_mark').data( 'examID', examID);
            $('#exam_edit').attr('href', '/home/class/'+classID+'/exam/' + examID);

            if(subRate>0){
                $('#exam_mark').show();
                $('#exam_edit').hide();
            }else{
                $('#exam_mark').hide();
                $('#exam_edit').show();
            }
        }
    });

});

$('#examModal').on('hidden.bs.modal', function (event) {
    document.getElementById('e_modalContainer').classList.remove('displayForm');
    document.getElementById('e_modalContainer').classList.add('loadingForm');

    var loading = "<div class='d-flex justify-content-center '><div style='margin-top:4em; margin-bottom:4em;' class='spinner-border' role='status'><span class='sr-only'>Loading...</span></div></div>";
    $('#e_modalContainer').html(loading);
});

//when the remove student comfirmation modal show up
$('#assignModal').on('shown.bs.modal', function (event) {
    var classID = $('#classID').val();
    var button = $(event.relatedTarget);
    var assignID = button.data('id');
    var subRate = button.data('subrate');
    var getExamDetail = "/lect/class/getAssignDetail/" + assignID;

    $.ajax({
        type: "GET",
        url: getExamDetail,
        data: '_token = <?php echo csrf_token() ?>',
        success:function (data) {
            document.getElementById('a_modalContainer').classList.add('displayForm');
            document.getElementById('a_modalContainer').classList.remove('loadingForm');

            $('#a_modalContainer').html(data);
            $('.assignFooter').html('<button class="btn btn-success" name="assign_mark" id="assign_mark" >MARK</button><a class="btn btn-danger" href="" name="assign_edit" id="assign_edit" >EDIT</a><button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>');

            $('#assign_mark').data( 'assignID', assignID);
            $('#assign_edit').attr('href', '/home/class/'+classID+'/assign/' + assignID);

            if(subRate>0){
                $('#assign_mark').show();
                $('#assign_edit').hide();
            }else{
                $('#assign_mark').hide();
                $('#assign_edit').show();
            }
        }
    });

});

$('#assignModal').on('hidden.bs.modal', function (event) {
    document.getElementById('a_modalContainer').classList.remove('displayForm');
    document.getElementById('a_modalContainer').classList.add('loadingForm');

    var loading = "<div class='d-flex justify-content-center '><div style='margin-top:4em; margin-bottom:4em;' class='spinner-border' role='status'><span class='sr-only'>Loading...</span></div></div>";
    $('#a_modalContainer').html(loading);
});

//mark the exam paper
$(document).on('click', '#exam_mark', function(event){
    var examID = $('#exam_mark').data('examID');
    var goMarkExam = "/lect/exam/mark/" + examID;

    window.location.href = goMarkExam;
});

//mark the assign paper
$(document).on('click', '#assign_mark', function(event){
    var assignID = $('#assign_mark').data('assignID');
    var goMarkAssign = "/lect/assign/mark/" + assignID;

    window.location.href = goMarkAssign;
});

//@handle replace backup modal
$('#btnRemoveComfirm').on('click', function(event){
    var classID = $('#classID').val();
    var studentID = $('#btnRemoveComfirm').val();
    let _token   = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
         type: "POST",
         url: "/lect/removeEnrollStud",
         data: {
            classID: classID,
            studentID: studentID,
            _token: _token
        },
         success:function (data) {
            var setStudString = "/lect/setup_studList/" + classID;
            //student List table
            $.ajax({
                type: "GET",
                url: setStudString,
                data: '_token = <?php echo csrf_token() ?>',
                success:function (data) {
                    $('#studList_panel').html(data);

                    $('#removeComfirmModal').modal('hide');
                }
            });

         }
    });
});

//rules for the addgradingModal '+' buttom
$('#markAdd').on('click', function(event){
    $markValue = $('#gradingMark').val();
    $maxVal = parseInt($('#maxGrad').html());

    if($markValue < $maxVal){
        $markValue++;
    }

    $('#gradingMark').val($markValue);
});

//rules for the addgradingModal '-' buttom
$('#markSub').on('click', function(event){
    $markValue = $('#gradingMark').val();

    if($markValue>0){
        $markValue--;
    }

    $('#gradingMark').val($markValue);
});

$('#btnAddGradSch').on('click', function(event){
    $('#gradingName').removeClass('is-invalid');
    $('#gradingMark').removeClass('is-invalid');

    $classID = $('#classID').val();
    $gradName = $('#gradingName').val();
    $gradMark = $('#gradingMark').val();
    var getGradTable = "/lect/T_gradingTable/" + $classID;
    let _token   = $('meta[name="csrf-token"]').attr('content');

    if($gradName === ""||$gradMark == 0){
        if($gradName === ""){
            $('#gradingName').addClass('is-invalid');
        }

        if($gradMark == 0){
            $('#gradingMark').addClass('is-invalid');
        }
    }else{
        //update table 'grading' for new grading schema
        $.ajax({
            type: "POST",
            url: "/lect/addGradingSch",
            data: {
                classID: $classID,
                gradName: $gradName,
                gradMark: $gradMark,
                _token: _token
            },
            cache: false,
            success:function (data) {
                //getGradingTable
                $.ajax({
                    type: "GET",
                    url: getGradTable,
                    data: '_token = <?php echo csrf_token() ?>',
                    success:function (data2) {
                        $('#gradingTablePanel').html(data2);
                    }
                });
            }
        });


        $('#addGradingModal').modal('hide');
        addData(myPieChart, $gradName, $gradMark);
    }
});

$(document).on('click', '.btnGradRemove', function(event){
    $classID = $('#classID').val();
    var gradingName = $(this).data('name');
    var gradingID = $(this).data('id');
    var removeGradString = "/lect/removeGradString/"+$classID+"/"+gradingID;
    var getGradTable = "/lect/T_gradingTable/" + $classID;

    $.ajax({
        type: "GET",
        url: removeGradString,
        data: '_token = <?php echo csrf_token() ?>',
        success:function (data) {
            //getGradingTable
            $.ajax({
                type: "GET",
                url: getGradTable,
                data: '_token = <?php echo csrf_token() ?>',
                success:function (data2) {
                    $('#gradingTablePanel').html(data2);
                }
            });
        }
    });

    removeData(myPieChart, gradingName);
});

//remove selected data from pie chart
function removeData(chart, label){
    var dataIndex = chart.data.labels.indexOf(label);

    chart.data.labels.splice(dataIndex, 1);
    chart.data.datasets.forEach((dataset) => {
        dataset.data.splice(dataIndex, 1);
        dataset.backgroundColor.splice(dataIndex, 1);
    });
    chart.update();
}

//update data to pir chart
function addData(chart, label, data) {
    chart.data.labels.push(label);
    //alert(chart.data.labels.indexOf('Assignment 1'));
    chart.data.datasets.forEach((dataset) => {
        //dataset.indexOf(ds1);
        dataset.data.push(data);
        dataset.backgroundColor.push(getRandomColor());
    });
    chart.update();
};

//get random hexa color code
function getRandomColor() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

</script>

@endsection
