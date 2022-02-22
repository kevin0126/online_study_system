

    <div class="form-group">
        <label for="success" class="control-label">Student ID</label>
        <input type="text" value="{{ $student[0]->idCode }}" name="companyID" class="form-control" id="success" readonly>
    </div>

    <div class="form-group">
            <label for="success" class="control-label">Student Name</label>
            <input type="text" value="{{ $student[0]->name }}" name="companyName" class="form-control" id="success" readonly>
        </div>

        <div class="form-group">
            <label for="success" class="control-label">Student Contact</label>
            <input type="text" value="{{ $student[0]->contact }}" name="contact_number" class="form-control" id="success" readonly>
        </div>

        <div class="form-group">
            <label for="success" class="control-label">E-mail</label>
            <input type="email" value="{{ $student[0]->email }}" name="email" class="form-control" placeholder="E-mail" required="required" id="success" readonly>
        </div>

        <div class="d-flex justify-content-between">
            <div class="form-inline">
                <label for="success" class="control-label">Record Info</label>
            </div>

            <div class="form-inline">
                <label for="success" class="control-label">Status :</label>
                    @if($student[0]->status == 1)
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
                    <input type="text" value="{{ $student[0]->created_at }}" name="createTime" class="form-control" id="success" readonly>
                </div>

                <div class="form-group">
                    <label for="success" class="control-label">Last Updated</label>
                    <input type="text" value="{{ $student[0]->updated_at }}" name="updateTime" class="form-control" id="success" readonly>
                </div>
            </div>
        </div>
