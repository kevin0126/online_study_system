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
                <button class="dropdown-item mb-2" data-toggle="modal" data-target="#comfirmModal" id="updateExam"><i class="fas fa-save"></i> Update</button>
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
                        <input class="form-control col-sm-5 col-md-5 col-lg-4" type="text" id="examID" value="{{ $examDetail->examID }}" readonly>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-md-3 col-lg-2 col-form-label">Exam Name</label>
                        <input class="form-control col-sm-6 col-md-6 col-lg-7" type="text" id="examName" value="{{ $examDetail->examName }}" required>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-3 col-md-3 col-lg-2 col-form-label">Date</label>
                        <input class="form-control col-sm-6 col-md-6 col-lg-3" type="date" id="examDate" value="{{ $examDetail->date }}" required>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-md-3 col-lg-2 col-form-label">Time</label>
                        <input class="form-control col-sm-3 col-md-3 col-lg-2" type="time" id="startTime" value="{{ $examDetail->startTime }}" required>
                        <label class="ml-1 mr-1"> ~ </label>
                        <input class="form-control col-sm-3 col-md-3 col-lg-2" type="time" id="endTime" value="{{ $examDetail->endTime }}" required>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-md-3 col-lg-2 col-form-label">Grading</label>
                        <select class="custom-select col-sm-6 col-md-6 col-lg-5" id="gradingID" value="{{ $examDetail->gradingID }}" required>
                            <option disabled selected value> -- select an grading -- </option>
                        @foreach($gradings as $grading)
                            <option value='{{ $grading->gradingID }}'>{{ $grading->gradingType }} ({{ $grading->gradingPercentage }}%)</option>
                        @endforeach
                        </select>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-md-3 col-lg-2 col-form-label">Description</label>
                        <textarea class="form-control col-sm-8 col-md-8 col-lg-8" id="examDescrip" rows="2" required>{{ $examDetail->Detail }}</textarea>
                    </div>

                    <div class="custom-control custom-checkbox">
                    @if($examDetail->lateSubmit >=1)
                        <input type="checkbox" class="custom-control-input" id="examLateSubmit" checked="checked">
                    @else
                        <input type="checkbox" class="custom-control-input" id="examLateSubmit">
                    @endif
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
            @foreach( $questions as $qindex => $question)

            <div class="card mb-3">
                <div class="card-header questionHead" id="questionHead{{ $qindex+1 }}" data-id="{{ $qindex+1 }}" data-toggle="collapse" data-target="#collapse{{ $qindex+1 }}" href="#">

                    <!-- question head -->
                    <a class="card-link align-middle">
                        <strong>Question #{{ $qindex+1 }}</strong>
                    </a>

                    <div class="float-right w-25" >
                        <select id="qType{{ $qindex+1 }}" data-id="{{ $qindex+1 }}" value="{{ $question['type'] }}" class="form-control form-control-sm float-left w-75 qType">
                            <option value="mcq">MCQ Question</option>
                            <option value="subj">Subjective Question</option>
                        </select>
                        <div class="float-right align-middle">
                            <i id="caret{{ $qindex+1 }}" class="fas fa-caret-up fa-lg"></i>
                        </div>
                    </div>

                </div>
                <div id="collapse{{ $qindex+1 }}" class="collapse">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Question</label>
                            <textarea class="form-control" id="question{{ $qindex+1 }}" rows="2">{{ $question['question'] }}</textarea>
                        </div>

                        <div class="mcqPanel hide current" id="mcqPanel{{ $qindex+1 }}">
                            <div class="form-group">
                                <label>MCQ Choice</label>
                                    <ul class="mcqul fadeMcq" id="mcqul{{ $qindex+1 }}">
                                @if($question['type'] == 'mcq')
                                @foreach( $question['mcq'] as $mcqIndex => $mcq)


                                    <li class="show">
                                        <div class="input-group input-group-sm col-sm-5 mb-1">
                                            <input type="text" value="{{ $mcq }}" name="q{{ $qindex+1 }}mcq{{ $mcqIndex+1 }}" class="form-control" id="q{{ $qindex+1 }}mcq{{ $mcqIndex+1 }}">
                                        </div>
                                    </li>


                                @endforeach
                                @else

                                    <li class="show">
                                        <div class="input-group input-group-sm col-sm-5 mb-1">
                                            <input type="text" value="" name="q{{ $qindex+1 }}mcq1" class="form-control" id="q{{ $qindex+1 }}mcq1">
                                        </div>
                                    </li>

                                @endif
                                </ul>
                                <ul>
                                    <li>
                                        <div class="col-sm-5">
                                            <button type="buttom" class="btn btn-outline-primary btn-sm font-weight-bold addMcq" id="addMcq{{ $qindex+1 }}" style="width:30px;" data-id="{{ $qindex+1 }}"> + </button>
                                            <button type="buttom" class="btn btn-outline-primary btn-sm font-weight-bold removeMcq" id="removeMcq{{ $qindex+1 }}" style="width:30px;" data-id="{{ $qindex+1 }}"> - </button>
                                        </div>
                                    </li>
                                </ul>

                            </div>
                        </div>

                        <div class="form-group d-flex justify-content-end">
                                <div class="d-flex align-items-center">
                                    <label>Mark:</label>
                                </div>

                                <div class="input-group col-sm-4 col-md-3 col-lg-2">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary markSub" type="button" data-id="{{ $qindex+1 }}" id="markSub{{ $qindex+1 }}">-</button>
                                    </div>
                                    <input type="number" class="form-control text-center" id="qMark{{ $qindex+1 }}" value="{{ $question['mark'] }}" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary markAdd" type="button" data-id="{{ $qindex+1 }}" id="markAdd{{ $qindex+1 }}">+</button>
                                    </div>
                                </div>

                        </div>

                    </div>
                </div>
            </div>

            @endforeach
            </div>

        </div>
    </div>
</div>

<!-- comfirm the modification modal -->
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

    $('#gradingID').val('{{ $examDetail->gradingID }}');

    setupExam();
    //addQuestion();
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
         url: "/lect/updateExam",
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
    var answer = [];
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

function setupExam(){
    var questions = {!! json_encode($questions, JSON_HEX_TAG) !!};

    $.each(questions, function(index, question){
        var QuestionNumb = index+1;

        $('#qType'+QuestionNumb).val(question['type']);
        $('#qType'+QuestionNumb).change();

        var answer = [];

        if(question['type'] == 'mcq'){
            $.each(question['mcq'], function(index2, mcq){
                answer.push("");
            })
        }else{
            answer.push("");
        }

        var tempQuestion = {qType:question['type'], question:"", mark:"", mcq:answer};
        examArray.push(tempQuestion);
    });
}

</script>

@endsection
