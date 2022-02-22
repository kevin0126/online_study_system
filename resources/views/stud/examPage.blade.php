@extends('layouts.header')

@section('content')
<style>
body,html,.panel_main{
    height:100%;
    background: lightblue;
}

.innerCard{
    background: skyblue;
}

</style>

<div id="panel_main" class="panel_main">
    <input id="classID" type="hidden" value="{{ $classID }}">
    <input id="examID" type="hidden" value="{{ $examID }}">
</div>

<script>
$(document).ready(function(){

    var classID = $('#classID').val();
    var examID = $('#examID').val();
    var getInfor = "/stud/checkExam/" + classID + "/" + examID;
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
