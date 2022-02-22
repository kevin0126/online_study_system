@extends('layouts.app')

@section('content')
<style>
body,html,.panel_main{
    height:100%;
}

.innerCard{
    background: skyblue;
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

<div id="panel_main" class="panel_main">
    <input id="classID" type="hidden" value="{{ $classID }}">
    <input id="assignID" type="hidden" value="{{ $assignID }}">
</div>

<script>
$(document).ready(function(){

    var classID = $('#classID').val();
    var assignID = $('#assignID').val();
    var getInfor = "/stud/checkAssign/" + classID + "/" + assignID;
    //setup middle data
    $.ajax({
         type: "GET",
         url: getInfor,
         data: '_token = <?php echo csrf_token() ?>',
         success:function (data) {
             $('.panel_main').html(data);
         }
    });

});
</script>

@endsection
