<div class="form-group">
    <label for="success" class="control-label">Class</label>
    <input type="text" value="{{ $tAdjDetail->classCode }} {{ $tAdjDetail->className }}" name="class" class="form-control" id="class" readonly>
</div>

<div class="form-group">
    <label for="success" class="control-label">Affected Time Slot</label>
    <input type="text" value="{{ $tAdjDetail->oldDay }} {{ substr($tAdjDetail->oldStart, 0, -3) }} ~ {{ substr($tAdjDetail->oldEnd, 0, -3) }}" name="oldTime" class="form-control" id="oldTime" readonly>
</div>

<div class="form-group">
    <label for="success" class="control-label">Reason</label>
    <textarea class="form-control" id="reason" rows="2" readonly>{{ $tAdjDetail->reason }}</textarea>
</div>

    <label for="success" class="control-label">Type: </label>
    @if($tAdjDetail->type == 'perm')
        <span>Permanent</span>
    @else
        <span>Temporary</span>
    @endif

<div class="card mb-3" style="background:#e1e3e4;">
    <div class="card-body">
        @if($tAdjDetail->type == 'perm')
        <div id="permPanel">
            <div class="form-group">
                <label class="control-label">Day</label>
                <input type="text" value="{{ $tAdjDetail->Day }}" name="day" class="form-control" id="day" readonly>
            </div>
            <div class="form-group">
                <label for="success" class="control-label">Time Slot</label>
                <input type="text" value="{{ substr($tAdjDetail->startTime, 0, -3) }} ~ {{ substr($tAdjDetail->endTime, 0, -3) }}" name="time" class="form-control" id="time" readonly>
            </div>
        </div>
        @else
        <div id="tempPanel">
            <div class="form-group">
                <label for="success" class="control-label">Affected Date</label>
                <input type="date" value="{{ $tAdjDetail->date }}" name="oriDate" class="form-control" id="oriDate" readonly>
            </div>
            <div class="form-group">
                <label for="success" class="control-label">New Date</label>
                <input type="date" value="{{ $tAdjDetail->newdate }}" name="newDate" class="form-control" id="newDate" readonly>
            </div>
            <div class="form-group">
                <label for="success" class="control-label">Time Slot</label>
                <input type="text" value="{{ substr($tAdjDetail->startTime, 0, -3) }} ~ {{ substr($tAdjDetail->endTime, 0, -3) }}" name="time" class="form-control" id="time" readonly>
            </div>
        </div>
        @endif
    </div>
</div>
