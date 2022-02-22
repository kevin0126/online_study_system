@extends('layouts.app')

@section('content')
<style>


input[type=number] {
  -moz-appearance: textfield;
}

.dm{
    background-color: #a2f3a4;
}

.toolbar, .toolbar1, .toolbar2, .toolbar3, .toolbar4{
    float:right;
    margin-right:1em;
}

.dataTables_filter {
   float: right;
}

.dataTables_paginate{
    float: right;
}
</style>

<div class="container py-4">


        <div class="card">
            <div class="card-header" style="background:lightskyblue;">
                <strong>Assignment Basic Detail</strong>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <h2><strong>Assignment Submission</strong></h2>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <h5><Strong>Assignment ID</strong>: {{ $assignID }}</h5>
                        <input type="hidden" id="assignID" value="{{ $assignID }}">
                    </div>
                    <div class="col-sm-6">
                        <h5><Strong>Assignment Name</Strong>: {{ $assignment->assignDate }}</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <h5><Strong>Deadline</strong>: {{ $assignment->assignDate }} {{ $assignment->endTime }}</h5>
                    </div>
                    <div class="col-sm-6">
                        <h5><Strong>Total Mark</Strong>: {{ $assignment->gradingPercentage }}</h5>
                        <input type="hidden" id="max" value="{{ $assignment->gradingPercentage }}">
                    </div>
                </div>
            </div>

    </div>

    </br>
    </br>

    <div class="assignPanel mt-3">

    </div>

    <div class="fixed-bottom">
        <div class="toast m-4" role="alert" data-delay="2000" data-autohide="true">
            <div class="toast-body alert-success">
                <span><strong id="successID"></strong> Save Succesfully</span>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){

    getSubmission();
});

function getSubmission(){
    var assignID = $('#assignID').val();
    let _token   = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        type: "POST",
        url: "/assign/getSubmission",
        data: {
            assignID: assignID,
            _token: _token
        },
        cache: false,
        success: function (data) {
            $('.assignPanel').html(data);
        },
    });

}

$('#saveAssign').on('click', function(e){
    var assignID = $('#assignID').val();
    let _token   = $('meta[name="csrf-token"]').attr('content');


    //alert(tempQ.toString());

    // $.ajax({
    //      type: "POST",
    //      url: "/exam/saveExamMark",
    //      data: {
    //         tempQ: tempQ,
    //         examID: examID,
    //         _token: _token
    //     },
    //      success:function (data) {
    //         $('#submitList option[value="'+data+'"]').addClass('dm');
    //         $('.toast').toast('show');
    //          //window.location.href = "/home/class/"+classID;

    //      },
    // });
});

//rules for the addgradingModal '+' buttom
$(document).on('click', '.markAdd', function(event){
    $submissionID = $(this).data('id');
    $markValue = $('#mark' + $submissionID).val();
    $markMax = $('#max').val();

    if($markValue < parseInt($markMax)){
        $markValue++;
    }

    $('#mark' + $submissionID).val($markValue);
});

//rules for the addgradingModal '-' buttom
$(document).on('click', '.markSub', function(event){
    $submissionID = $(this).data('id');
    $markValue = $('#mark' + $submissionID).val();

    if($markValue>0){
        $markValue--;
    }

    $('#mark' + $submissionID).val($markValue);
});

//save single submission mark
$(document).on('click', '.btnSave', function(event){
    $submissionID = $(this).data('id');
    $mark = $('#mark'+$submissionID).val();
    let _token   = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
         type: "POST",
         url: "/assign/saveAssignMark",
         data: {
            submissionID: $submissionID,
            mark: $mark,
            _token: _token
        },
         success:function (data) {
            $('#successID').html(data);
            $('.toast').toast('show');
            //window.location.href = "/home/class/"+classID;
         },
    });

})

$(document).on('click', '#btnSVAL', function(event){
    $assignment = $(this).data('id');
    $ss = {!! json_encode($ss, JSON_HEX_TAG) !!}
    let _token   = $('meta[name="csrf-token"]').attr('content');

    $.each($ss, function(index, value){
        $submissionID = value['sbID'];
        $mark = $('#mark'+$submissionID).val();
        value['mark'] = $mark;
    });

    $.ajax({
         type: "POST",
         url: "/assign/saveAssignMarkAll",
         data: {
            ss: $ss,
            _token: _token
        },
         success:function (data) {
            $('#successID').html(data+' records');
            $('.toast').toast('show');
            //window.location.href = "/home/class/"+classID;
         },
    });
})
</script>


@endsection
