
<table id="exampleTable" class="table table-striped table-bordered" cellspacing="0" style="width: 100%">
                            <thead>
                                <tr>
                                    <th scope="col">Student ID</th>
                                    <th scope="col">File</th>
                                    <th scope="col">Late Submit?</th>
                                    <th scope="col">Mark</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach($assignSubmissions as $submission)
                                <tr>
                                    <td scope="row">{{ $submission->idCode }}</td>
                                    <td><a class="btn btn-outline-primary btn-sm" href='/assign/submitDownload/{{ $submission->submissionID }}'>Downlaod</a></td>
                                    <td>{{ $submission->lateSubmit }}</td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-outline-secondary markSub" type="button" data-id="{{ $submission->submissionID }}" id="markSub{{ $submission->submissionID }}">-</button>
                                            </div>
                                            <input class="form-control text-center" id="mark{{ $submission->submissionID }}" value="{{ $submission->totalMark }}" readonly>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary markAdd" type="button" data-id="{{ $submission->submissionID }}" id="markAdd{{ $submission->submissionID }}">+</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a class="btn btn-outline-primary btn-sm btnSave" type="button" data-id='{{ $submission->submissionID }}'></i>SAVE</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>


<script>
$(document).ready(function(){
    $('#exampleTable').DataTable({
        "dom": 'f<"toolbar"><"toolbar2">lrtpi'
    } );

    $("div.toolbar2").html('<a class="btn btn-info mb-2 text-white" href="/assign/allAssignDownload/{{ $assignID }}" id="btnDLAL">DOWNLOAD ALL</a>');
    $("div.toolbar").html('<button class="btn btn-info mb-2" id="btnSVAL" data-id="{{ $assignID }}" type="button">SAVE ALL</button>')
})
</script>
