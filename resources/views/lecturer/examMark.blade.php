@extends('layouts.app')

@section('content')
<style>
textarea{
    width:400px;
}

input[type=number] {
  -moz-appearance: textfield;
}

.dm{
    background-color: #a2f3a4;
}
</style>

<div class="container py-4">
    <div class="row justify-content-center">

        <div class="col-sm-2 p-0">
            <div class="sticky-top">
                <input type="hidden" id="examID" value="{{ $examID }}">

                <div class="card">
                    <div class="card-header" style="background:lightskyblue;">
                        <strong>Control</strong>
                    </div>
                    <div class="card-body p-0">
                        <a class="dropdown-item mt-2" href="/home/class/{{ $cid }}" id="btnHome"><i class="fas fa-chevron-circle-left"></i> Home Page</a>
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item" id="submitPre"><i class="fas fa-plus-circle"></i> Previous</button>
                        <button class="dropdown-item" id="submitNext"><i class="fas fa-minus-circle"></i> Next</button>
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item mb-2" data-toggle="modal" id="saveMark"><i class="fas fa-save"></i> Save</button>
                    </div>
                </div></br>

                <div class="card">
                    <div class="card-header" style="background:lightskyblue;">
                        <strong>Control</strong>
                    </div>
                    <div class="card-body pt-1 pl-3 pr-3">
                        <strong>Submition List:</strong>

                        <select class="custom-select border border-dark p-0" size="15" id="submitList" name="submitList">
                        @foreach($examSubmissions as $examSubmission)
                            @empty($examSubmission->totalMark)
                                <option value="{{ $examSubmission->examSubID }}">{{ $examSubmission->idCode }}</option>
                            @else
                                <option class="dm" value="{{ $examSubmission->examSubID }}">{{ $examSubmission->idCode }}</option>
                            @endempty
                        @endforeach
                        </select>
                    </div>
                </div>
            </div>


        </div>

        <div class="col-sm-10">
            <div class="examPanel">

            </div>
        </div>
    </div>

    <div class="fixed-bottom">
        <div class="toast m-4" role="alert" data-delay="2000" data-autohide="true">
            <div class="toast-body alert-success">
                <strong>Save Succesfully</strong>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $("#submitList")[0].selectedIndex = 0;
    $('#submitList').change();

});

function getSubmission(){
    var examID = $('#examID').val();
    var submitID = $('#submitList option:selected').val();
    let _token   = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        type: "POST",
        url: "/exam/getSubmition",
        data: {
            submitID: submitID,
            examID: examID,
            _token: _token
        },
        cache: false,
        success: function (data) {
            $('.examPanel').html(data);
        },
    });

}

//submission list change
$(document).on('change','#submitList', function (event) {

    getSubmission();
});

//rules for the addgradingModal '+' buttom
$(document).on('click', '.markAdd', function(event){
    $questionNumber = $(this).data('id');
    $markValue = $('#qMark' + $questionNumber).val();
    $markMax = $('#maxMark' + $questionNumber).html();

    if($markValue < parseInt($markMax)){
        $markValue++;
    }

    $('#qMark' + $questionNumber).val($markValue);
});

//rules for the addgradingModal '-' buttom
$(document).on('click', '.markSub', function(event){
    $questionNumber = $(this).data('id');
    $markValue = $('#qMark' + $questionNumber).val();

    if($markValue>0){
        $markValue--;
    }

    $('#qMark' + $questionNumber).val($markValue);
});

$('#submitPre').on('click', function(e){
    $("#submitList")[0].selectedIndex = $("#submitList")[0].selectedIndex - 1;
    if($("#submitList")[0].selectedIndex < 0){
        $("#submitList")[0].selectedIndex = $('#submitList option').length-1;
    }

    $('#submitList').change();
});

$('#submitNext').on('click', function(e){
    $("#submitList")[0].selectedIndex = $("#submitList")[0].selectedIndex + 1;
    if($("#submitList")[0].selectedIndex < 0){
        $("#submitList")[0].selectedIndex = 0;
    }

    $('#submitList').change();
});

$('#saveMark').on('click', function(e){
    var tempQ = [];
    var examID = $('#examID').val();
    var qn = {!! json_encode($qn, JSON_HEX_TAG) !!};
    let _token   = $('meta[name="csrf-token"]').attr('content');

    for (i = 0; i < qn; i++) {
        var qIndex = $('#q'+(i+1)+'Index').val();
        var remark = $('#q'+(i+1)+'Remark').val();
        var mark = $('#qMark'+(i+1)).val();

        var temp = [qIndex, remark, mark];
        tempQ.push(temp);

    }

    //alert(tempQ.toString());

    $.ajax({
         type: "POST",
         url: "/exam/saveExamMark",
         data: {
            tempQ: tempQ,
            examID: examID,
            _token: _token
        },
         success:function (data) {
            $('#submitList option[value="'+data+'"]').addClass('dm');
            $('.toast').toast('show');
             //window.location.href = "/home/class/"+classID;

         },
    });
});
</script>


@endsection
