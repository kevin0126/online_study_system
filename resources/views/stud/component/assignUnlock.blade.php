

<div class="container py-4">
    <div class="row justify-content-center">

        <div class="col-sm-2 p-0">

        <div class="sticky-top card">
            <div class="card-header" style="background:lightskyblue;">
                <strong>Control</strong>
            </div>
            <div class="card-body p-0">
                <button class="dropdown-item mb-2" data-toggle="modal" data-target="#comfirmModal" id="comptAssign"><i class="fas fa-check-circle"></i> Submit</button>
            </div>
        </div>

        </div>

        <div class="col-sm-10">

            <div class="card">
                <div class="card-header" style="background:lightskyblue;">
                    <strong>Assign Detail</strong>
                </div>
                <div class="card-body">
                    <input type="hidden" id="classID" value="{{ $classID }}" >

                    <div class="d-flex justify-content-end">
                        <h6 class="card-subtitle mb-2 text-muted ">{{ $assignment->assignmentID }}</h6>
                        <input id="assignmentID" type="hidden" value="{{ $assignment->assignmentID }}">
                    </div>

                    <div class="d-flex justify-content-center">
                        <h2><strong>{{ $assignment->assignName }}</strong></h2>
                    </div>

                    <div class="row">
                        <div class="col-sm-7">
                            <h5><Strong>Deadline Date</strong>: {{ $assignment->assignDate }}</h5>
                        </div>

                        <div class="col-sm-5">
                            <h5><Strong>Deadline Time</strong>: {{ substr($assignment->endTime, 0, -3) }}</h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-7">
                            <h5><Strong>Subject Code</strong>: {{ $assignment->classCode }}</h5>
                            <input id="classID" type="hidden" value="{{ $classID }}">
                        </div>

                        <div class="col-sm-5">
                            <h5><Strong>Student ID</strong>: {{ $student->idCode }}</h5>
                            <input id="studentID" type="hidden" value="{{ $student->id }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-7">
                            <h5><Strong>Subject Name</strong>: {{ $assignment->className }}</h5>
                        </div>

                        <div class="col-sm-5">
                            <h5><Strong>Student Name</strong>: {{ $student->name }}</h5>
                        </div>
                    </div>

                    </br></br>
                    <div class="divied">
                        <span>Assignment Panel</span>
                    </div>
                    </br></br>

                    <div class="form-group row">
                        <h5 class="col-sm-4 col-md-4 col-lg-3"><Strong>Description:</strong></h5>
                        <h5 class="">{!! nl2br(e($assignment->description)) !!}</h5>
                    </div>

                    <div class="form-group row">

                        @if (count($assignFile) > 0)
                        <h5 class="col-sm-4 col-md-4 col-lg-3"><Strong>Attachement:</strong></h5>
                            <div class="col-sm-7 col-md-7 col-lg-7 row">
                            @foreach ($assignFile as $file)
                                <div class="card mt-2 ">
                                    <div class="card-body p-2 pt-3 ">
                                        <div class="d-flex justify-content-center ">
                                            <p class="card-text mb-1"><i class="fas fa-5x fa-file"></i></p>

                                        </div>
                                        <h6 class="card-text ">{{ $file[1] }}</h6>
                                        <a href="/fileDownload/{{ $file[0] }}" class="stretched-link"></a>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        @endif

                        </br>
                    </div>


                    <div class="form-group row">
                        <h5 class="col-sm-4 col-md-4 col-lg-3"><Strong>Submission:</strong></h5>
                        <div class="col-sm-8 row">
                            <div class="custom-file col-sm-12 text-truncate">
                                <input type="file" class="custom-file-input" id="assignFile" multiple>
                                <label class="custom-file-label" for="assignFile">Choose File</label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- confirm finish the exam modal -->
<div class="modal fade" name="comfirmModal" id="comfirmModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Comfirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <span>Are you sure done?</span><br/>
        <span>( Upon submit, you will unable to make any change later. please make sure the submission is correct )</span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" value="" id="btnComfirm">YES</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">NO</button>
      </div>
    </div>
  </div>
</div>

<script>

document.querySelector('.custom-file-input').addEventListener('change',function(e){
    var fileName = document.getElementById("assignFile").files[0].name;
    var file = document.getElementById("assignFile").files;
    var text = file.length + " file selected (";

    $.each(file, function( index, value ) {
        text += value.name + ", ";
    });

    text += ")";

    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = text;
});

$(document).ready(function(){


});

$('#btnComfirm').on('click', function(e){
    var fd = new FormData();
    var classID = $('#classID').val();
    var assignmentID = $('#assignmentID').val();
    var studentID = $('#studentID').val();
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var fileUpload = $('#assignFile')[0].files[0];

    fd.append('classID', classID);
    fd.append('assignmentID', assignmentID);
    fd.append('studentID', studentID);
    fd.append('fileUpload', fileUpload);
    fd.append('_token', _token);

    $.ajax({
        type: "POST",
        url: "/stud/submitAssignment",
        contentType: false,
        processData: false,
        data: fd,
        success:function (data) {
            $('#comfirmModal').modal('hide');
            if(data == 1){
                window.location.href = "/stud/assign/submitSuccess";
             }else{
                window.location.href = "/stud/assign/submitReject";
             }
        },
    });

});


</script>
