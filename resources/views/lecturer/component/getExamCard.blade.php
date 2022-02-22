<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 ">

@foreach($examCards as $examCard)
<div class="col mb-4">
<div class="card h-100" data-toggle="modal" data-target="#examModal" data-id='{{ $examCard->examID }}' data-subRate='{{ $examCard->subCount }}'>
    <div class="card-body">

        <h6 class="card-subtitle mb-2 text-muted">{{ $examCard->examID }}</h6>
        <h3 class="card-title"><strong>{{ $examCard->examName }}</strong></h3>

        <h5 class="card-text">Date</h5>
        <p class="card-subtitle">{{ $examCard->date }}</p>

        <h5 class="card-text">Time</h5>
        <p class="card-subtitle">{{ substr($examCard->startTime, 0, -3) }} ~ {{ substr($examCard->endTime, 0, -3) }}</p>

    </div>
    <div class="card-footer">
    @if( $examCard->subCount <= (($studAmount->studNumb)/3) )
        <p class="card-subtitle text-muted">Submission Rate: <strong class="textRed">{{ $examCard->subCount }}/{{ $studAmount->studNumb }}</strong></p>
    @elseif( $examCard->subCount <= ((($studAmount->studNumb)/3)*2) )
        <p class="card-subtitle text-muted">Submission Rate: <strong class="textOrange">{{ $examCard->subCount }}/{{ $studAmount->studNumb }}</strong></p>
    @else
        <p class="card-subtitle text-muted">Submission Rate: <strong class="textGreen">{{ $examCard->subCount }}/{{ $studAmount->studNumb }}</strong></p>
    @endif
    </div>
</div>
</div>
@endforeach

</div>
