@extends('layouts.app')

@section('content')
<style>
.questionHead{
    background:lightskyblue;
    cursor: pointer;
    color: black;
    transition: 0.3s;
}

.questionHead:hover{
    background-color: #026cc7;
    color: white;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

input[type=number] {
  -moz-appearance: textfield;
}

.divied {
    text-align: center;
}

.divied > span {
    position: relative;
}

.divied > span:before,
.divied > span:after {
    content: "";
    position: absolute;
    top: 50%;
    width: 200px;
    height: 2px;
    background: lightgray;
}

.divied > span:before {
    right: 100%;
    margin-right: 15px;
}

.divied > span:after {
    margin-left: 15px;
}


</style>

<div class="container py-4">
    <div class="row justify-content-center">

        <div class="col-sm-2 p-0">

        <div class="sticky-top card">
            <div class="card-header" style="background:lightskyblue;">
                <strong>Control</strong>
            </div>
            <div class="card-body p-0">
                <button class="dropdown-item mb-2" data-toggle="modal" data-target="#comfirmModal" id="saveExam"><i class="fas fa-save"></i> Save</button>
            </div>
        </div>

        </div>

        <div class="col-sm-10">

            <div class="card">
                <div class="card-header" style="background:lightskyblue;">
                    <strong>Assignment Basic Detail</strong>
                </div>
                <div class="card-body">
                    <input type="hidden" id="classID" value="{{ $classID }}" >

                    <div class="form-group row">
                        <label class="col-sm-3 col-md-3 col-lg-2 col-form-label">Assignment ID: </label>
                        <input class="form-control col-sm-5 col-md-5 col-lg-4" type="text" id="assignID" value="{{ $assignDetail->assignmentID }}" readonly>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-md-3 col-lg-2 col-form-label">Assignment Name</label>
                        <input class="form-control col-sm-6 col-md-6 col-lg-7" type="text" id="assignName" value="{{ $assignDetail->assignName }}" required>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-3 col-md-3 col-lg-2 col-form-label">Deadline (Date)</label>
                        <input class="form-control col-sm-6 col-md-6 col-lg-3" type="date" id="assignDate" value="{{ $assignDetail->assignDate }}" required>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-md-3 col-lg-2 col-form-label">Deadline (Time)</label>
                        <input class="form-control col-sm-3 col-md-3 col-lg-2" type="time" id="endTime" value="{{ $assignDetail->endTime }}" required>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-md-3 col-lg-2 col-form-label">Grading</label>
                        <select class="custom-select col-sm-6 col-md-6 col-lg-5" id="gradingID" value="{{ $assignDetail->gradingID }}" required>
                            <option disabled selected value> -- select an grading -- </option>
                        @foreach($gradings as $grading)
                            <option value='{{ $grading->gradingID }}'>{{ $grading->gradingType }} ({{ $grading->gradingPercentage }}%)</option>
                        @endforeach
                        </select>
                    </div>

                    <div class="custom-control custom-checkbox">
                    @if($assignDetail->lateSubmit >=1)
                        <input type="checkbox" class="custom-control-input" id="assignLateSubmit" checked="checked">
                    @else
                        <input type="checkbox" class="custom-control-input" id="assignLateSubmit">
                    @endif
                        <label class="custom-control-label" for="assignLateSubmit" required>Allow Late Submittion ?</label>
                    </div>

                    </br>
                    <div class="divied">
                        <span>Assignment Panel</span>
                    </div>
                    </br>

                    <div class="form-group row">
                        <label class="col-sm-3 col-md-3 col-lg-2 col-form-label">Description</label>
                        <textarea class="form-control col-sm-8 col-md-8 col-lg-8" id="assignDescrip" rows="2" required>{{ $assignDetail->description }}</textarea>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-md-3 col-lg-2 col-form-label">File Upload (Replace)</label>
                        <div class="col-sm-8 row">
                            <div class="custom-file col-sm-12 text-truncate">
                                <input type="file" class="custom-file-input" id="assignFile" multiple>
                                <label class="custom-file-label" for="assignFile">Choose File</label>
                            </div>

                            @if (count($assignFile[0]) > 0)
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
                            @endif

                        </div>
                    </div>

                </div>
            </div>
            <br>


            <br>
            <div id="questionPanel">

            </div>

        </div>
    </div>
</div>

<!-- remove existing student in the class -->
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
        <span>Are you sure done?</span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" value="" id="btnComfirm">YES</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">NO</button>
      </div>
    </div>
  </div>
</div>

<script>
var examArray = new Array();

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
    $('#gradingID').val('{{ $assignDetail->gradingID }}');

});

$('#btnComfirm').on('click', function(e){
    var fd = new FormData();
    var classID = $('#classID').val();
    var assignID = $('#assignID').val();
    var assignName = $('#assignName').val();
    var assignDate = $('#assignDate').val();
    var endTime = $('#endTime').val();
    var gradingID = $('#gradingID').val();
    var assignDescrip = $('#assignDescrip').val();
    var assignLateSubmit = $('#assignLateSubmit').is(':checked');
    var fileUpload = $('#assignFile')[0].files[0];
    let _token   = $('meta[name="csrf-token"]').attr('content');

    fd.append('classID', classID);
    fd.append('assignID', assignID);
    fd.append('assignName', assignName);
    fd.append('assignDate', assignDate);
    fd.append('endTime', endTime);
    fd.append('gradingID', gradingID);
    fd.append('assignDescrip', assignDescrip);
    fd.append('assignLateSubmit', assignLateSubmit);
    fd.append('fileUpload', fileUpload);
    fd.append('_token', _token);

    $.ajax({
        type: "POST",
        url: "/lect/updateAssignment",
        contentType: false,
        processData: false,
        data: fd,
        success:function (data) {
            $('#comfirmModal').modal('hide');
            window.location.href = "/home/class/"+classID;

        },
    });

    //alert(examID+examName+examDescrip+examDate);
});


</script>

@endsection
