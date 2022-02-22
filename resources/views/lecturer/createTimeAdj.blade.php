@extends('layouts.app')

@section('content')
<style>
#mainCard{
    margin-top:10px;
    margin-bottom:15px;
}

textarea{
    height:300px;
}

a, a:hover{
  color:#333;
  text-decoration: none;
}
</style>

<div class="container py-4">
<div class="row h-75" style="margin-top:1.5em;">
<div class="col-sm-12 my-auto">

<div class="card card-block col-xl-6 col-lg-6 col-md-9 col-sm-12 mx-auto container" style="border-radius: 25px;">
<div class="container" id="mainCard">

    <h1><strong>New Time Adjustment Record</strong></h1>



        <div class="form-group">
            <label for="success" class="control-label">Class ID</label>
            <select class="custom-select input-group-text text-left" id="classID" name="classID">
                <option disabled selected value> -- Select a Class -- </option>
                @foreach( $classes as $class )
                    <option value="{{ $class->classID }}">{{ $class->classCode }}  {{ $class->className }}</option>
                @endforeach
            </select>
            <div id="classID_invalid" class="invalid-feedback">
            </div>
        </div>

        <div class="form-group">
            <label for="success" class="control-label">Original Time</label>
            <select class="custom-select input-group-text text-left" id="timeID" name="timeID" disabled>
                <option class="text-muted" disabled selected value> -- Class not Selected -- </option>
            </select>
            <div id="timeID_invalid" class="invalid-feedback">
            </div>
        </div>

        <div class="form-group">
            <label for="success" class="control-label">Reason</label>
            <textarea class="form-control" id="reason" rows="2"></textarea>
            <div id="reason_invalid" class="invalid-feedback">
            </div>
        </div>

        <div class="form-group">
            <label for="success" class="control-label">Type</label>
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input rbButton" id="rdTemp" name="radio-stacked" checked>
                <label class="custom-control-label" for="rdTemp">Temporary (One-Time)</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input rbButton" id="rdPerm" name="radio-stacked">
                <label class="custom-control-label" for="rdPerm">Permanent</label>
                <div class="invalid-feedback">More example invalid feedback text</div>
            </div>
        </div>

        <div class="card mb-3" style="background:#e1e3e4;">
            <div class="card-body">
                <div id="tempPanel">
                    <div class="form-group">
                        <label for="success" class="control-label">Original Date</label>
                        <input type="date" value="" name="oriDate" class="form-control" id="oriDate">
                    </div>

                    <div class="form-group">
                        <label for="success" class="control-label">New Date</label>
                        <input type="date" value="" name="newDate" class="form-control" id="newDate">
                    </div>

                    <div class="form-group">
                        <label for="success" class="control-label">Time Slot</label>
                        <div class="form-inline">
                            <input class="form-control col-sm-4 col-md-4 col-lg-4" type="time" id="t_startTime" required>
                            <label class="ml-1 mr-1"> ~ </label>
                            <input class="form-control col-sm-4 col-md-4 col-lg-4" type="time" id="t_endTime" required>
                        </div>
                    </div>
                </div>

                <div id="permPanel" style="display:none;">
                    <div class="form-group">
                        <label class="control-label">Day</label>
                        <select class="custom-select" id="day">
                            <option value='monday'>Monday</option>
                            <option value='tuesday'>Tuesday</option>
                            <option value='wednesday'>wednesday</option>
                            <option value='thursday'>Thursday</option>
                            <option value='friday'>Friday</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="success" class="control-label">Time Slot</label>
                        <div class="form-inline">
                            <input class="form-control col-sm-4 col-md-4 col-lg-4" type="time" id="p_startTime">
                            <label class="ml-1 mr-1"> ~ </label>
                            <input class="form-control col-sm-4 col-md-4 col-lg-4" type="time" id="p_endTime">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-inline">
            <button class="btn btn-primary col-md-4" id="btnCreate" name="btnCreate">CREATE</button>
            <a class="btn btn-secondary offset-md-4 col-md-4" href="/home" type="button" id="btnBack" name="back">BACK</a>
        </div>

    </div>
</div>
</div>
</div>
</div>

</div>



<script>
$(document).ready(function() {


});

$('#classID').on('change', function(e){

    var classID =  $('#classID').val();
    var getString = "/lect/getTimeSelect/" + classID;
    //classes card load
    $.ajax({
         type: "GET",
         url: getString,
         data: '_token = <?php echo csrf_token() ?>',
         success:function (data) {
            $("#timeID").prop( "disabled", false );
            $('#timeID').html(data);
         }
    });
})

$('#mainCard').on('click','#btnCreate',function(e){
    var classID = $('#classID').val();
    var timeID = $('#timeID').val();
    var reason = $('#reason').val();
    var tempType = $('#rdTemp').prop('checked');
    var permType = $('#rdPerm').prop('checked');
    var type;
    var startTime;
    var endTime;
    var addInfo;
    var date;
    let _token   = $('meta[name="csrf-token"]').attr('content');

    if(tempType){
        type = 'temp';
        addInfo = $('#newDate').val();
        date = $('#oriDate').val();
        startTime = $('#t_startTime').val();
        endTime = $('#t_endTime').val();
    }else if(permType){
        type = 'perm';
        addInfo = $('#day').val();
        startTime = $('#p_startTime').val();
        endTime = $('#p_endTime').val();
    }

    $.ajax({
        type: "POST",
        url: "/lect/saveTimeAdj",
        data: {
            classID: classID,
            timeID: timeID,
            reason: reason,
            type: type,
            date: date,
            startTime: startTime,
            endTime: endTime,
            addInfo: addInfo,
            _token: _token
        },
        success:function (data) {
            window.location.href = "/home";
        }
    });
})

$('.rbButton').on('change', function(e){
    var sourceID = $(this).attr('id');

    if(sourceID == 'rdPerm'){
        $('#permPanel').show();
        $('#tempPanel').hide();
    }else{
        $('#permPanel').hide();
        $('#tempPanel').show();
    }
})


</script>

@endsection
