

    <div class="form-group">
        <label for="success" class="control-label">Lecturer ID</label>
        <input type="text" value="{{ $lecturer[0]->idCode }}" class="form-control" id="success" readonly>
    </div>

    <div class="form-group">
            <label for="success" class="control-label">Lecturer Name</label>
            <input type="text" value="{{ $lecturer[0]->name }}" class="form-control" id="success" readonly>
        </div>

        <div class="form-group">
            <label for="success" class="control-label">Lecturer Contact</label>
            <input type="text" value="{{ $lecturer[0]->contact }}" class="form-control" id="success" readonly>
        </div>

        <div class="form-group">
            <label for="success" class="control-label">E-mail</label>
            <input type="email" value="{{ $lecturer[0]->email }}" name="email" class="form-control" placeholder="E-mail" required="required" id="success" readonly>
        </div>

        <div class="d-flex justify-content-between">
            <div class="form-inline">
                <label for="success" class="control-label">Record Info</label>
            </div>

            <div class="form-inline">
                <label for="success" class="control-label">Status :</label>
                    @if($lecturer[0]->status == 1)
                        <label id='greenText' class='control-label'>&nbspActive</label>
                    @else
                        <label id='redText' class='control-label'>&nbspInactive</label>
                    @endif
            </div>
        </div>

        <div class="card" style="background:#e1e3e4;">
            <div class="card-body">
                <div class="form-group">
                    <label for="success" class="control-label">Created At</label>
                    <input type="text" value="{{ $lecturer[0]->created_at }}" name="createTime" class="form-control" id="success" readonly>
                </div>

                <div class="form-group">
                    <label for="success" class="control-label">Last Updated</label>
                    <input type="text" value="{{ $lecturer[0]->updated_at }}" name="updateTime" class="form-control" id="success" readonly>
                </div>
            </div>
        </div>
