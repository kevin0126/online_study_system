@foreach ( $inforDetails as $inforDetail)
<div class="card mt-3">
    <div class="card-body">
        <div class="row">
    @if ( $inforDetail->info_type == 0 )

            <div class="col-sm-12 d-flex justify-content-between">
                <h6 class="card-subtitle text-muted">#{{ $inforDetail->examID }}</h6>
                <h6 class="card-subtitle text-muted text-right">post at {{ date_format($inforDetail->created_at, 'Y-m-d') }}</h6>
            </div>

            <div class="col-sm-8">
                <div>
                    <h3 class="card-title"><strong>Test : {{ $inforDetail->examName }}</strong></h3>
                </div>

                <div>
                    <h5>Exam Date : {{ $inforDetail->date }}</h5>
                </div>
            </div>

            <div class="col-sm-4">
                <h4 class="card-text"><strong>Exam Time :</strong></h4>
                <h5 class="offset-3">{{ substr($inforDetail->startTime, 0, -3) }} ~ {{ substr($inforDetail->endTime, 0, -3) }}</h5>
            </div>
            <a class="stretched-link examDetail classInfoCard" data-toggle="modal" data-target="#examModal"  data-id='{{ $inforDetail->examID }}'></a>

    @elseif ( $inforDetail->info_type == 1 )

    <div class="col-sm-12 d-flex justify-content-between">
                <h6 class="card-subtitle text-muted">#{{ $inforDetail->assignmentID }}</h6>
                <h6 class="card-subtitle text-muted text-right">post at {{ date_format($inforDetail->created_at, 'Y-m-d') }}</h6>
            </div>

            <div class="col-sm-8">
                <div>
                    <h3 class="card-title"><strong>Assignment : {{ $inforDetail->assignName }}</strong></h3>
                </div>

            </div>

            <div class="col-sm-4">

                <h4 class="card-text"><strong>Deadline Date :</strong></h4>
                <h5 class="offset-3">{{ $inforDetail->assignDate }}</h5>

                <h4 class="card-text"><strong>Deadline Time :</strong></h4>
                <h5 class="offset-3">{{ substr($inforDetail->endTime, 0, -3) }}</h5>
            </div>
            <a class="stretched-link assignDetail classInfoCard" data-toggle="modal" data-target="#assignModal"  data-id='{{ $inforDetail->assignmentID }}'></a>


    @else

            <div class="col-sm-12 d-flex justify-content-between">
                <h6 class="card-subtitle text-muted">#{{ $inforDetail->timeAdjID }}</h6>
                <h6 class="card-subtitle text-muted text-right">post at {{ date_format($inforDetail->created_at, 'Y-m-d') }}</h6>
            </div>

            <div class="col-sm-8">
                <div>
                    @if ($inforDetail->type == $temp)
                        <h3 class="card-title"><strong>Time Adjustment : Temporary Change</strong></h3>
                    @else
                        <h3 class="card-title"><strong>Time Adjustment : Permanent Change</strong></h3>
                    @endif
                </div>

                <div>
                    <h5>Affected Time Slot : {{ $inforDetail->oldDay }} ({{ substr($inforDetail->oldStart, 0, -3) }} ~ {{ substr($inforDetail->oldEnd, 0, -3) }})</h5>
                </div>
            </div>

            <div class="col-sm-4">
            @if ($inforDetail->type == $temp)
                <h4 class="card-text"><strong>Affected Date :</strong></h4>
                <h5 class="offset-3">{{ $inforDetail->date }}</h5>

                <h4 class="card-text"><strong>New Date :</strong></h4>
                <h5 class="offset-3">{{ $inforDetail->newdate }}</h5>
            @else
                <h4 class="card-text"><strong>New Time Slot :</strong></h4>
                <h5 class="offset-3">{{ $inforDetail->Day }} ({{ substr($inforDetail->startTime, 0, -3) }} ~ {{ substr($inforDetail->endTime, 0, -3) }})</h5>
            @endif

            </div>
            <a class="stretched-link timeAdjDetail classInfoCard" data-toggle="modal" data-target="#timeAdjModal"  data-id='{{ $inforDetail->timeAdjID }}'></a>
    @endif
        </div>
    </div>
</div>
@endforeach
