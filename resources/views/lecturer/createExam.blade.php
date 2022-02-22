@extends('layouts.app')

@section('content')
<style>
.questionHead{
    background:lightskyblue;
    cursor: pointer;
    color: black;
    transition: 0.3s;
}

.questionHead:hover{
    background-color: #026cc7;
    color: white;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

input[type=number] {
  -moz-appearance: textfield;
}

ul.mcqul {
    list-style: upper-alpha;

}

.addMcq, .removeMcq {
    border-radius: 20px;
}

.mcqPanel li{
    height: 0;
    margin: 0;
    padding: 0 0.5em;
    line-height: 2em;
    display: content;
}

.mcqul li.show {
    height: 2em;
    margin: 2px 0;
}

.mcqPanel {
    margin: 0;
    padding: 0 0.5em;
    line-height: 2em;
    max-height: 0;

}

.mcqPanel.current {
    margin: 2px 0;
    max-height: 500px;
}

.hide {
    transition: all 0.4s ease-out;
    opacity: 0;
}

.hide.current {
    opacity: 1;

}

.fadeMcq li {
    transition: all 0.2s ease-out;
    opacity: 0;
}

.fadeMcq li.show {
    opacity: 1;
}

.divied {
    text-align: center;
}

.divied > span {
    position: relative;
}

.divied > span:before,
.divied > span:after {
    content: "";
    position: absolute;
    top: 50%;
    width: 200px;
    height: 2px;
    background: lightgray;
}

.divied > span:before {
    right: 100%;
    margin-right: 15px;
}

.divied > span:after {
    margin-left: 15px;
}


</style>

<div class="container py-4">
    <div class="row justify-content-center">

        <div class="col-sm-2 p-0">

        <div class="sticky-top card">
            <div class="card-header" style="background:lightskyblue;">
                <strong>Control</strong>
            </div>
            <div class="card-body p-0">
                <button class="dropdown-item mt-2" id="addQuestion"><i class="fas fa-plus-circle"></i> Add</button>
                <button class="dropdown-item" id="removeQuestion"><i class="fas fa-minus-circle"></i> Remove</button>
                <div class="dropdown-divider"></div>
                <button class="dropdown-item mb-2" data-toggle="modal" data-target="#comfirmModal" id="saveExam"><i class="fas fa-save"></i> Save</button>
            </div>
        </div>

        </div>

        <div class="col-sm-10">

            <div class="card">
                <div class="card-header" style="background:lightskyblue;">
                    <strong>Exam Basic Detail</strong>
                </div>
                <div class="card-body">
                    <input type="hidden" id="classID" value="{{ $classID }}" >

                    <div class="form-group row">
                        <label class="col-sm-3 col-md-3 col-lg-2 col-form-label">ExamID: </label>
                        <input class="form-control col-sm-5 col-md-5 col-lg-4" type="text" id="examID" readonly>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-md-3 col-lg-2 col-form-label">Exam Name</label>
                        <input class="form-control col-sm-6 col-md-6 col-lg-7" type="text" id="examName" required>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-3 col-md-3 col-lg-2 col-form-label">Date</label>
                        <input class="form-control col-sm-6 col-md-6 col-lg-3" type="date" id="examDate" required>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-md-3 col-lg-2 col-form-label">Time</label>
                        <input class="form-control col-sm-3 col-md-3 col-lg-2" type="time" id="startTime" required>
                        <label class="ml-1 mr-1"> ~ </label>
                        <input class="form-control col-sm-3 col-md-3 col-lg-2" type="time" id="endTime" required>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-md-3 col-lg-2 col-form-label">Grading</label>
                        <select class="custom-select col-sm-6 col-md-6 col-lg-5" id="gradingID" required>
                            <option disabled selected value> -- select an grading -- </option>
                        @foreach($gradings as $grading)
                            <option value='{{ $grading->gradingID }}'>{{ $grading->gradingType }} ({{ $grading->gradingPercentage }}%)</option>
                        @endforeach
                        </select>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-md-3 col-lg-2 col-form-label">Description</label>
                        <textarea class="form-control col-sm-8 col-md-8 col-lg-8" id="examDescrip" rows="2" required></textarea>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="examLateSubmit">
                        <label class="custom-control-label" for="examLateSubmit" required>Allow Late Submittion ?</label>
                    </div>

                </div>
            </div>
            <br>

            <div class="divied">
                <span>Question Panel</span>
            </div>

            <br>
            <div id="questionPanel">

            </div>

        </div>
    </div>
</div>

<!-- remove existing student in the class -->
<div class="modal fade" name="comfirmModal" id="comfirmModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Comfirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <span>Are you sure done?</span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" value="" id="btnComfirm">YES</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">NO</button>
      </div>
    </div>
  </div>
</div>

<script>
var examArray = new Array();

$(document).ready(function(){

    addQuestion();
    assignExamID();
});

$(document).on('click', '.questionHead', function(e){
    var questionNumber = $(this).data('id');
    var caretIcon = "caret" + questionNumber;

    if($( "#"+caretIcon ).hasClass( "fa-caret-up" )){
        $( "#"+caretIcon ).removeClass("fa-caret-up");
        $( "#"+caretIcon ).addClass("fa-caret-down");
    }else{
        $( "#"+caretIcon ).removeClass("fa-caret-down");
        $( "#"+caretIcon ).addClass("fa-caret-up");
    }
});

$(document).on('click', '.qType', function(e){
    //prevent the triggrt of collapes event
    e.stopPropagation();
});

//rules for the addgradingModal '+' buttom
$(document).on('click', '.markAdd', function(event){
    $questionNumber = $(this).data('id');
    $markValue = $('#qMark' + $questionNumber).val();

    $markValue++;

    $('#qMark' + $questionNumber).val($markValue);
});

//rules for the addgradingModal '-' buttom
$(document).on('click', '.markSub', function(event){
    $questionNumber = $(this).data('id');
    $markValue = $('#qMark' + $questionNumber).val();

    if($markValue>0){
        $markValue--;
    }

    $('#qMark' + $questionNumber).val($markValue);
});

$(document).on('click', '.addMcq', function(e){
    $questionNumber = $(this).data('id');

    addMSQ($questionNumber);
});

$(document).on('click', '.removeMcq', function(e){
    $questionNumber = $(this).data('id');

    removeMSQ($questionNumber);
});

$(document).on('change', '.qType', function(e){
    $questionNumber = $(this).data('id');
    $typeValue = $(this).val();
    $targetQuestion = $('#mcqPanel'+$questionNumber);

    if($typeValue === 'mcq'){
        if(!$targetQuestion.hasClass('current')){
            setTimeout(function() {
                $targetQuestion.addClass('current');
            }, 10);
        }
    }else{
        if($targetQuestion.hasClass('current')){
            setTimeout(function() {
                $targetQuestion.removeClass('current');
            }, 10);
        }
    }
    //$('#mcqul'+$questionNumber).removeClass('current');
    //alert($questionNumber+"::"+$typeValue);
});

$('#addQuestion').on('click', function(e){
    addQuestion();
});

$('#removeQuestion').on('click', function(e){
    removeQuestion();
});

$('#btnComfirm').on('click', function(e){
    var classID = $('#classID').val();
    var examID = $('#examID').val();
    var examName = $('#examName').val();
    var examDate = $('#examDate').val();
    var startTime = $('#startTime').val();
    var endTime = $('#endTime').val();
    var gradingID = $('#gradingID').val();
    var examDescrip = $('#examDescrip').val();
    var examLateSubmit = $('#examLateSubmit').is(':checked');
    let _token   = $('meta[name="csrf-token"]').attr('content');

    //alert(examLateSubmit);

    setupQuestionArray();
    $.ajax({
         type: "POST",
         url: "/lect/SaveExam",
         data: {
            classID: classID,
            examID: examID,
            examName: examName,
            examDate: examDate,
            startTime: startTime,
            endTime: endTime,
            gradingID: gradingID,
            examDescrip: examDescrip,
            examLateSubmit: examLateSubmit,
            examArray: examArray,
            _token: _token
        },
         success:function (data) {
             $('#comfirmModal').modal('hide');
             window.location.href = "/home/class/"+classID;

         },
         error: function (err) {
            $('#comfirmModal').modal('hide');
            if (err.status == 422){
                $('.form-control').removeClass('is-invalid');

                $.each(err.responseJSON.errors, function (id, error) {
                    $('#'+id).addClass('is-invalid');
                });
            }
        }
    });

    //alert(examID+examName+examDescrip+examDate);
});

function setupQuestionArray(){
    //var questionNumb = examArray.length;

    $.each(examArray, function(questionIndex, question){
        question['qType'] = $('#qType'+(questionIndex+1)).val();
        question['mark'] = $('#qMark'+(questionIndex+1)).val();
        question['question'] = $('#question'+(questionIndex+1)).val();

        //alert(examArray[questionIndex]['question']+"::"+(questionIndex+1));

        $.each(question['mcq'], function(mcqIndex, mcq){
            question['mcq'][mcqIndex] = $('#q'+(questionIndex+1)+'mcq'+(mcqIndex+1)).val();
            //alert(question['mcq'][mcqIndex]);
        })

    });
}

function addMSQ($qNumber){

    var questionMCQ = examArray[$qNumber-1]['mcq'];
    var mcqNumber = questionMCQ.length + 1;

    questionMCQ.push("");

    $("#mcqul"+$qNumber).append('<li><div class="input-group input-group-sm col-sm-5 mb-1"><input type="text" value="" name="q'+$qNumber+'mcq'+mcqNumber+'" class="form-control" id="q'+$qNumber+'mcq'+mcqNumber+'"></div></li>');
    setTimeout(function() {
        $('#q'+$qNumber+'mcq'+mcqNumber).parent().parent().addClass("show");
    }, 10);
}

function removeMSQ($qNumber){
    var questionMCQ = examArray[$qNumber-1]['mcq'];
    var mcqNumber = questionMCQ.length;

    if(mcqNumber>1){
        $('#q'+$qNumber+'mcq'+mcqNumber).parent().parent().removeClass("show");

        setTimeout(function() {
            questionMCQ.pop();
            $('#q'+$qNumber+'mcq'+mcqNumber).parent().parent().remove();
        }, 500);
    }
}

function addQuestion(){
    var answer = new Array("");
    var tempQuestion = {qType:"mcq", question:"", mark:"", mcq:answer};
    examArray.push(tempQuestion);

    var QuestionNumb = examArray.length;
    var addQuestionString = "/lect/exam/addQuestion/" + QuestionNumb;

    $.ajax({
        type: "GET",
        url: addQuestionString,
        data: '_token = <?php echo csrf_token() ?>',
        success:function (data) {
            $('#questionPanel').append(data);
        }
    });
}

function removeQuestion(){
    var questionNumb = examArray.length;

    if(questionNumb>1){
        examArray.pop();
        $('#questionHead'+questionNumb).parent().remove();
    }
}

function assignExamID(){
    var d = new Date();
    var code = d.getMilliseconds()+""+d.getSeconds()+""+d.getMinutes()+""+d.getHours()+""+d.getDate()+""+d.getMonth()+""+d.getYear();

    $('#examID').val(code);
}
</script>

@endsection
