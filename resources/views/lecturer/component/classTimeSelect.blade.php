
<option class="text-muted" disabled selected value> -- Select a Time Slot -- </option>
@foreach( $times as $time )
    <option value="{{ $time->timeID }}">{{ $time->Day }}  ( {{ substr($time->startTime, 0, -3) }} ~ {{ substr($time->endTime, 0, -3) }} )</option>
@endforeach
