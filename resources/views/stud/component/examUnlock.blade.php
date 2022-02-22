</br>
</br>
</br>

<div class="container py-4">
    <div class="row justify-content-center">

        <div class="col-sm-2 p-0">

        <div class="sticky-top card">
            <div class="card-header" style="background:lightskyblue;">
                <strong>Control</strong>
            </div>
            <div class="card-body p-0">
                <button class="dropdown-item mb-2" data-toggle="modal" data-target="#comfirmModal" id="comptExam"><i class="fas fa-check-circle"></i> Submit</button>
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

                    <div class="d-flex justify-content-end">
                        <h6 class="card-subtitle mb-2 text-muted ">{{ $exam->examID }}</h6>
                        <input id="examID" type="hidden" value="{{ $exam->examID }}">
                    </div>

                    <div class="d-flex justify-content-center">
                        <h2><strong>{{ $exam->examName }}</strong></h2>
                    </div>

                    <div class="row">
                        <div class="col-sm-7">
                            <h5><Strong>Exam Date</strong>: {{ $exam->date }}</h5>
                        </div>

                        <div class="col-sm-5">
                            <h5><Strong>Exam Time</strong>: {{ substr($exam->startTime, 0, -3) }} ~ {{ substr($exam->endTime, 0, -3) }}</h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-7">
                            <h5><Strong>Subject Code</strong>: {{ $exam->classCode }}</h5>
                            <input id="classID" type="hidden" value="{{ $classID }}">
                        </div>

                        <div class="col-sm-5">
                            <h5><Strong>Student ID</strong>: {{ $student->idCode }}</h5>
                            <input id="studentID" type="hidden" value="{{ $student->id }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-7">
                            <h5><Strong>Subject Name</strong>: {{ $exam->className }}</h5>
                        </div>

                        <div class="col-sm-5">
                            <h5><Strong>Student Name</strong>: {{ $student->name }}</h5>
                        </div>
                    </div>

                </div>
            </div>

            <br>

            <div id="questionPanel" class="card">
                <div class="card-header" style="background:lightskyblue;">
                    <strong>Question Panel</strong>
                </div>
                <div class="card-body">
                @foreach( $questions as $qindex => $question)
                    <div class="dropdown-divider"></div>

                    <div class="row ml-1">
                        <h5><strong>{{ $qindex+1 }}.&nbsp</strong></h5>

                        <div>
                            <h5>{!! nl2br(e($question['question'])) !!}</h5>
                            @if($question['type'] == 'mcq')
                                <div class="row ml-1">
                                    @foreach( $question['mcq'] as $mcqIndex => $mcq)
                                    <div class="custom-control custom-radio col-sm-6 col-md-6 col-lg-6">
                                        <input type="radio" id="q{{ $qindex+1 }}mcq{{ $mcqIndex+1 }}" value="{{ $question['mcqID'][$mcqIndex] }}" name="q{{ $qindex+1 }}mcq" class="custom-control-input">
                                        <label class="custom-control-label" for="q{{ $qindex+1 }}mcq{{ $mcqIndex+1 }}">{{ $mcq }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <textarea rows="5" name="q{{ $qindex+1 }}mcq" class="form-control" id="q{{ $qindex+1 }}mcq"></textarea>
                            @endif
                        </div>

                    </div>
                @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

<!-- confirm finish the exam modal -->
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
        <span>Are you sure done?</span><br/>
        <span>( Upon submit, you will unable to make any change later. please make sure every question is checked and answered )</span>
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

    setupExam();

});

$('#btnComfirm').on('click', function(e){
    var classID = $('#classID').val();
    var examID = $('#examID').val();
    var studentID = $('#studentID').val();
    let _token   = $('meta[name="csrf-token"]').attr('content');

    fillAnswer();

    $.ajax({
         type: "POST",
         url: "/stud/submitExam",
         data: {
            classID: classID,
            examID: examID,
            studentID: studentID,
            examArray: examArray,
            _token: _token
        },
         success:function (data) {
             $('#comfirmModal').modal('hide');
             if(data == 1){
                window.location.href = "/stud/exam/submitSuccess";
             }else{
                window.location.href = "/stud/exam/submitReject";
             }
             //window.location.href = "/home/class/"+classID;

         }
    });
});

function fillAnswer(){

    $.each(examArray, function(questionIndex, question){

        if(question['type'] === 'mcq'){
            question['answer'] = $("input[name=q"+(questionIndex+1)+"mcq]:checked").val();

            if(typeof question['answer'] === "undefined"){
                question['answer'] = "";
            }
        }else{
            question['answer'] = $('#q'+(questionIndex+1)+"mcq").val();
        }

    });
}

function setupExam(){
    var questions = {!! json_encode($questions, JSON_HEX_TAG) !!};

    $.each(questions, function(index, question){
        var QuestionNumb = index+1;

        var answer = "";

        var tempQuestion = {questionID:question['questionID'], type:question['type'], answer:answer};
        examArray.push(tempQuestion);
    });
}

</script>
