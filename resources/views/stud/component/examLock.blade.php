<div class="row h-100">
    <div class="col-sm-12 my-auto">
        <div class="container">
            <div class="col-sm-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <h6><strong>Exam ID:</strong> {{ $exam->examID }}</h6>
                                <h6><strong>Exam Name:</strong> {{ $exam->examName }}</h6>
                            </div>

                            <div class="col-sm-7">
                                <h6><strong>Subject Code:</strong> {{ $exam->classCode }}</h6>
                                <h6><strong>Exam Name:</strong> {{ $exam->className }}</h6>
                            </div>
                        </div>

                        <div class="card innerCard">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <h6><strong>Exam Date:</strong></h6>
                                        <h6><strong>Exam Time/Duration:</strong></h6>
                                    </div>

                                    <div class="col-sm-8">
                                        <h6>{{ $exam->date }}</h6>
                                        <h6> {{ $exam->startTime }} ~ {{ $exam->endTime }}</h6>
                                    </div>
                                </div>
                                <p class="card-text">You May Access to the Exam Paper when the Exam is Start / Submission already make</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
