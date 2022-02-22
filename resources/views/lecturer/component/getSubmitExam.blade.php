<div class="card">
    <div class="card-header" style="background:lightskyblue;">
        <strong>Exam Basic Detail</strong>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-center">
            <h2><strong>Exam Submission</strong></h2>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <h5><Strong>Examinee ID</strong>: {{ $examSubmission->idCode }}</h5>
            </div>
            <div class="col-sm-6">
                <h5><Strong>Examinee Name</Strong>: {{ $examSubmission->name }}</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <h5><Strong>Late Submit ?</strong>: {{ $examSubmission->lateSubmit }}</h5>
            </div>
            <div class="col-sm-6">
                <h5><Strong>Submit Time</Strong>: {{ $examSubmission->created_at }}</h5>
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
        @foreach ($submissionQ as $qindex => $question)
        <div class="dropdown-divider"></div>

        <div class="row ml-1 w-100">
            <h5><strong>{{ $qindex+1 }}.&nbsp</strong></h5>
            <input type="hidden" id="q{{ $qindex+1 }}Index" value="{{ $question->examSubAnsID }}">

            <div>
                <h5>{!! nl2br(e($question['question'])) !!}</h5>
                @if($question->type == 'mcq')
                <p><strong>ANS: </strong>{{ $question->choiceName }}</p>
                @else
                <strong>ANS: </strong>
                <p class="w-100">{!! nl2br(e($question->answer)) !!}</p>
                @endif

                <strong>Remark</strong>
                <textarea rows="2" cols="50" name="q{{ $qindex+1 }}Remark" placeholder="(Optional)" class="form-control" id="q{{ $qindex+1 }}Remark">{{ $question->remark }}</textarea>
            </div>
        </div>
        </br>
        <div class="form-group d-flex justify-content-end">
                <div class="d-flex align-items-center">
                    <label>Mark:</label>
                </div>

                <div class="input-group col-sm-4 col-md-3 col-lg-2">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary markSub" type="button" data-id="{{ $qindex+1 }}" id="markSub{{ $qindex+1 }}">-</button>
                    </div>
                    <input type="number" class="form-control text-center" id="qMark{{ $qindex+1 }}" value="{{ $question->assignMark }}" readonly>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary markAdd" type="button" data-id="{{ $qindex+1 }}" id="markAdd{{ $qindex+1 }}">+</button>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <label>/<strong id="maxMark{{ $qindex+1 }}">{{ $question['mark'] }}</strong></label>
                </div>

        </div>

        @endforeach
    </div>
</div>
