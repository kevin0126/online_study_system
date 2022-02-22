@extends('layouts.app')

@section('content')
<style>
.classInfoCard{
    cursor: pointer;
}

div.modal-content{
    -webkit-transition:all 800ms ease;
    overflow:hidden;
}

div.displayForm{
    height:60em;
    border-radius:10px;
}

div.loadingForm{
    height:10em;
    border-radius:75px;
}
</style>

<div class="wrapper">
    <div class="w-100 text-white" style="background: grey; height: 11em;">
        <div class="d-flex align-items-end h-100 w-100">
            <div class="container">
                <input type="hidden" id="classID" value="{{ $classDetail->classID }}">
                <span class="h4">{{ $classDetail->classCode }}</span>
                <h3 class="font-weight-bolder">{{ $classDetail->className }}</h3>
                <h5 class="pb-2">Lecturer : {{ $classDetail->name }}</h5>
            </div>
        </div>

    </div>

    <div class="container">
    <div class="row">
        <div class="col-sm-3 p-0 mt-3">
            <div class="sticky-top">

                <div class="card">
                    <div class="card-header bg-primary">
                        <strong>Control</strong>
                    </div>
                    <div class="card-body p-0">
                        <a class="dropdown-item mt-2 mb-2" href="/home" id="btnHome"><i class="fas fa-chevron-circle-left"></i> Home Page</a>
                    </div>
                </div>

                </br>

                <div class="card">
                    <div class="card-header bg-primary">
                        <strong>Carry Mark</strong>
                    </div>
                    <div class="card-body carryPanel">

                    </div>
                </div>

            </div>
        </div>

        <div class="inforSet col-sm-9">

        </div>
    </div>
    </div>

</div>

<!-- time Adjustment Detail -->
<div class="modal fade" name="timeAdjModal" id="timeAdjModal" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" id="l_modalContainer">

    <div class="modal-header">
        <span class="h5 modal-title" style=" margin-bottom: 0px; margin-top:0px;">Time Adjustment Detail</span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="timeAdjustDetail modal-body">

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
    </div>

    </div>
</div>
</div>

<!-- Exam Item Detail Modal -->
<div class="modal fade" name="examModal" id="examModal" tabindex="-1" role="dialog">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content loadingForm" id="e_modalContainer">
        <div class='d-flex justify-content-center '>
            <div style='margin-top:4em; margin-bottom:4em;' class='spinner-border' role='status'>
                <span class='sr-only'>
                    Loading...
                </span>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Assignment Item Detail Modal -->
<div class="modal fade" name="assignModal" id="assignModal" tabindex="-1" role="dialog">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content loadingForm" id="a_modalContainer">
        <div class='d-flex justify-content-center '>
            <div style='margin-top:4em; margin-bottom:4em;' class='spinner-border' role='status'>
                <span class='sr-only'>
                    Loading...
                </span>
            </div>
        </div>
    </div>
</div>
</div>

<script>
$(document).ready(function(){
    var classID = $('#classID').val();
    var getInfor = "/stud/getInfor/" + classID;
    var getCarryMark = "/stud/getCarry/" + classID;

    //setup middle data
    $.ajax({
         type: "GET",
         url: getInfor,
         data: '_token = <?php echo csrf_token() ?>',
         success:function (data) {
             $('.inforSet').html(data);
         }
    });

    //carry mark panel
    $.ajax({
         type: "GET",
         url: getCarryMark,
         data: '_token = <?php echo csrf_token() ?>',
         success:function (data) {
             $('.carryPanel').html(data);
         }
    });

});

$(document).on('show.bs.modal', '#timeAdjModal', function(event) {
   //get Time Adjustment Detail
    var button = $(event.relatedTarget)
    var timeAdjID = button.data('id');
    var getString = "/stud/getTimeAdjDetail/"+timeAdjID;

    $.ajax({
        type: "GET",
        url: getString,
        data: '_token = <?php echo csrf_token() ?>',
        success:function (data) {
            $('.timeAdjustDetail').html(data);
        }
    });

})

//exam modal
$(document).on('shown.bs.modal','#examModal', function (event) {
    var classID = $('#classID').val();
    var button = $(event.relatedTarget);
    var examID = button.data('id');
    var getExamDetail = "/stud/class/getExamDetail/" + examID;



    $.ajax({
        type: "GET",
        url: getExamDetail,
        data: '_token = <?php echo csrf_token() ?>',
        success:function (data) {
            document.getElementById('e_modalContainer').classList.add('displayForm');
            document.getElementById('e_modalContainer').classList.remove('loadingForm');

            $('#e_modalContainer').html(data);
            $('.examFooter').html('<a class="btn btn-success" href="" name="assign_proceed" id="exam_proceed" >PROCEED</a><button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>');

            $('#exam_proceed').attr('href', '/stud/class/'+classID+'/exam/' + examID);

        }
    });


});

$('#examModal').on('hidden.bs.modal', function (event) {
    document.getElementById('e_modalContainer').classList.remove('displayForm');
    document.getElementById('e_modalContainer').classList.add('loadingForm');

    var loading = "<div class='d-flex justify-content-center '><div style='margin-top:4em; margin-bottom:4em;' class='spinner-border' role='status'><span class='sr-only'>Loading...</span></div></div>";
    $('#e_modalContainer').html(loading);
});


//assignment modal
$(document).on('shown.bs.modal','#assignModal', function (event) {
    var classID = $('#classID').val();
    var button = $(event.relatedTarget);
    var assignID = button.data('id');
    var getExamDetail = "/stud/class/getAssignDetail/" + assignID;

    $.ajax({
        type: "GET",
        url: getExamDetail,
        data: '_token = <?php echo csrf_token() ?>',
        success:function (data) {
            document.getElementById('a_modalContainer').classList.add('displayForm');
            document.getElementById('a_modalContainer').classList.remove('loadingForm');

            $('#a_modalContainer').html(data);
            $('.assignFooter').html('<a class="btn btn-success" href="" name="assign_proceed" id="assign_proceed" >PROCEED</a><button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>');

            $('#assign_proceed').attr('href', '/stud/class/'+classID+'/assign/' + assignID);
        }
    });

});

$('#assignModal').on('hidden.bs.modal', function (event) {
    document.getElementById('a_modalContainer').classList.remove('displayForm');
    document.getElementById('a_modalContainer').classList.add('loadingForm');

    var loading = "<div class='d-flex justify-content-center '><div style='margin-top:4em; margin-bottom:4em;' class='spinner-border' role='status'><span class='sr-only'>Loading...</span></div></div>";
    $('#a_modalContainer').html(loading);
});



</script>

@endsection
