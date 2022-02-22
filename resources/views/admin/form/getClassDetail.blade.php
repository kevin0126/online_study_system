


        <div class="form-group">
            <label for="success" class="control-label">Class ID</label>
            <input type="text" value="{{ $class[0]->classID }}" name="classID" class="form-control" id="success" readonly>
        </div>

        <div class="form-group">
            <label for="success" class="control-label">Class Code</label>
            <input type="email" value="{{ $class[0]->classCode }}" name="classCode" class="form-control" placeholder="E-mail" required="required" id="success" readonly>
        </div>

        <div class="form-group">
            <label for="success" class="control-label">Class Name</label>
            <input type="text" value="{{ $class[0]->className  }}" name="className" class="form-control" id="success" readonly>
        </div>

        <div class="form-group">
            <label for="success" class="control-label">Faculty</label>
            <input type="text" value="{{ $class[0]->facultyName }}" name="facultyName" class="form-control" id="success" readonly>
        </div>

        <div class="form-group">
            <label for="success" class="control-label">Assign Lecturer</label>
            <input type="email" value="{{ $class[0]->name }}" name="lecName" class="form-control" placeholder="E-mail" required="required" id="success" readonly>
        </div>

        <div class="form-group">
            <label for="success" class="control-label">Last Update</label>
            <input type="text" value="{{ $class[0]->updated_at }}" name="LastUpdated" class="form-control" id="success" readonly>
        </div>

        <div class="form-inline">
        <label for="success" class="control-label">Status :</label>
            @if($class[0]->status == 1)
                <label id='greenText' class='control-label'>&nbspActive</label>
            @else
                <label id='redText' class='control-label'>&nbspInactive</label>
            @endif
        </div>

        @if($class[0]->status == 1)
        <div class="card" style="background:#e1e3e4;">
            <div class="card-body">
                <div class="form-group">
                    <label for="success" class="control-label">Time Table</label>
                    <table class="table table-sm bg-light table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Day</th>
                                <th scope="col">Start Hour</th>
                                <th scope="col">End Hour</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($times as $time)
                            <tr>
                                <th scope="row">{{ $time->Day }}</th>
                                <td>{{ $time->startTime }}</td>
                                <td>{{ $time->endTime }}</td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <button name="btnStudList" id="btnStudList" value="{{ $class[0]->classID }}" class="btn btn-primary col-sm-12 mt-0">ENROLL STUDENTS LIST</button>
                </div>
            </div>
        </div>
        @endif

