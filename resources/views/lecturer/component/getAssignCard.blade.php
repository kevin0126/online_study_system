<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 ">

@foreach($assignCards as $assignCard)
<div class="col mb-4">
<div class="card h-100" data-toggle="modal" data-target="#assignModal" data-id='{{ $assignCard->assignmentID }}' data-subRate='{{ $assignCard->subCount }}'>
    <div class="card-body">

        <h6 class="card-subtitle mb-2 text-muted">{{ $assignCard->assignmentID }}</h6>
        <h3 class="card-title"><strong>{{ $assignCard->assignName }}</strong></h3>

        <h5 class="card-text">Date</h5>
        <p class="card-subtitle">{{ $assignCard->assignDate }}</p>

        <h5 class="card-text">Time</h5>
        <p class="card-subtitle">{{ substr($assignCard->endTime, 0, -3) }}</p>

    </div>
    <div class="card-footer">
    @if( $assignCard->subCount <= (($studAmount->studNumb)/3) )
        <p class="card-subtitle text-muted">Submission Rate: <strong class="textRed">{{ $assignCard->subCount }}/{{ $studAmount->studNumb }}</strong></p>
    @elseif( $assignCard->subCount <= ((($studAmount->studNumb)/3)*2) )
        <p class="card-subtitle text-muted">Submission Rate: <strong class="textOrange">{{ $assignCard->subCount }}/{{ $studAmount->studNumb }}</strong></p>
    @else
        <p class="card-subtitle text-muted">Submission Rate: <strong class="textGreen">{{ $assignCard->subCount }}/{{ $studAmount->studNumb }}</strong></p>
    @endif
    </div>
</div>
</div>
@endforeach

</div>
