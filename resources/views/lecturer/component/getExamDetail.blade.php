<div class="modal-header">
    <h5 class="modal-title">Exam Detail</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body" id="examDetail" name="examDetail">

    <div class="form-group">
        <label for="success" class="control-label">Exam ID</label>
        <input type="text" value="{{ $examDetail->examID }}" class="form-control" id="success" readonly>
    </div>

    <div class="form-group">
        <label for="success" class="control-label">Exam Name</label>
        <input type="text" value="{{ $examDetail->examName }}" class="form-control" id="success" readonly>
    </div>

    <div class="form-group">
        <label for="success" class="control-label">Date</label>
        <input type="text" value="{{ $examDetail->date }}" class="form-control" id="success" readonly>
    </div>

    <div class="form-group">
        <label class="control-label">Time</label>
        <div class="form-inline" >
        <input class="form-control col-sm-3 col-md-3 col-lg-2" value="{{ substr($examDetail->startTime, 0, -3) }}" type="text" id="startTime" readonly>
        <label class="ml-1 mr-1"> ~ </label>
        <input class="form-control col-sm-3 col-md-3 col-lg-2" value="{{ substr($examDetail->endTime, 0, -3) }}" type="text" id="endTime" readonly>
        </div>
    </div>

    <div class="form-group">
        <label for="success" class="control-label">Grading</label>
        <input type="email" value="{{ $examDetail->gradingType }} ({{ $examDetail->gradingPercentage }}%)" name="email" class="form-control" id="success" readonly>
    </div>

    <div class="form-group">
        <label for="success" class="control-label">Description</label>
        <textarea class="form-control" id="examDescrip" rows="2" readonly>{{ $examDetail->Detail }}</textarea>
    </div>

    <div class="custom-control custom-checkbox">


        @if($examDetail->lateSubmit >=1)
            <input type="checkbox" class="custom-control-input" id="examLateSubmit" disabled="disabled" checked="checked">
        @else
            <input type="checkbox" class="custom-control-input" id="examLateSubmit" disabled="disabled">
        @endif
        <label class="custom-control-label" for="examLateSubmit">Allow Late Submittion ?</label>
    </div>

    <div class="card" style="background:#e1e3e4;">
        <div class="card-body">
            <div class="form-group">
                <label for="success" class="control-label">Created At</label>
                <input type="text" value="{{ $examDetail->created_at }}" name="createTime" class="form-control" id="success" readonly>
            </div>

            <div class="form-group">
                <label for="success" class="control-label">Last Updated</label>
                <input type="text" value="{{ $examDetail->updated_at }}" name="updateTime" class="form-control" id="success" readonly>
            </div>
        </div>
    </div>

</div>
<div class="modal-footer examFooter">

</div>


