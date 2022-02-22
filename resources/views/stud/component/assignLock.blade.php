</br>
</br>
<div class="row h-100">
    <div class="col-sm-12 my-auto">
        <div class="container">
            <div class="col-sm-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <h6><strong>Assignment ID:</strong> {{ $assignment->assignmentID }}</h6>
                                <h6><strong>Assignment Name:</strong> {{ $assignment->assignName }}</h6>
                            </div>

                            <div class="col-sm-7">
                                <h6><strong>Subject Code:</strong> {{ $assignment->classCode }}</h6>
                                <h6><strong>Subject Name:</strong> {{ $assignment->className }}</h6>
                            </div>
                        </div>

                        <div class="card innerCard">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <h6><strong>Deadline Date:</strong></h6>
                                        <h6><strong>Deadline Time:</strong></h6>
                                    </div>

                                    <div class="col-sm-8">
                                        <h6>{{ $assignment->assignDate }}</h6>
                                        <h6>{{ $assignment->endTime }}</h6>
                                    </div>
                                </div>
                                <p class="card-text">Student are unable to submit after the submission deadline / Submission already make</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
