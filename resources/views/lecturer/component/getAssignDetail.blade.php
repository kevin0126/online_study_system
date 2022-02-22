<div class="modal-header">
    <h5 class="modal-title">Assignment Detail</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body" id="assignDetail" name="assignDetail">
    <div class="form-group">
        <label for="success" class="control-label">Assignment ID</label>
        <input type="text" value="{{ $assignDetail->assignmentID }}" class="form-control" id="success" readonly>
    </div>

    <div class="form-group">
        <label for="success" class="control-label">Assignment Name</label>
        <input type="text" value="{{ $assignDetail->assignName }}" class="form-control" id="success" readonly>
    </div>

    <div class="form-group">
        <label for="success" class="control-label">Deadline (Date)</label>
        <input type="text" value="{{ $assignDetail->assignDate }}" class="form-control" id="success" readonly>
    </div>

    <div class="form-group">
        <label class="control-label">Deadline (Time)</label>
        <input class="form-control col-sm-3 col-md-3 col-lg-2" value="{{ substr($assignDetail->endTime, 0, -3) }}" type="text" id="endTime" readonly>
    </div>

    <div class="form-group">
        <label for="success" class="control-label">Grading</label>
        <input value="{{ $assignDetail->gradingType }} ({{ $assignDetail->gradingPercentage }}%)" class="form-control" id="success" readonly>
    </div>

    <div class="form-group">
        <label for="success" class="control-label">Description</label>
        <textarea class="form-control" id="assignDescrip" rows="2" readonly>{{ $assignDetail->description }}</textarea>
    </div>

    <div class="custom-control custom-checkbox">
        @if($assignDetail->lateSubmit >=1)
            <input type="checkbox" class="custom-control-input" id="assignLateSubmit" disabled="disabled" checked="checked">
        @else
            <input type="checkbox" class="custom-control-input" id="assignLateSubmit" disabled="disabled">
        @endif
        <label class="custom-control-label" for="examLateSubmit">Allow Late Submittion ?</label>
    </div>

    <div class="card" style="background:#e1e3e4;">
        <div class="card-body">
            <div class="form-group">
                <label for="success" class="control-label">Created At</label>
                <input type="text" value="{{ $assignDetail->created_at }}" name="createTime" class="form-control" id="success" readonly>
            </div>

            <div class="form-group">
                <label for="success" class="control-label">Last Updated</label>
                <input type="text" value="{{ $assignDetail->updated_at }}" name="updateTime" class="form-control" id="success" readonly>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer assignFooter">

</div>

