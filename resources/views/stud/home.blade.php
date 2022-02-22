@extends('layouts.app')

@section('content')
<style>
h2{
    margin-bottom:1em;
    font-style:bold;

}

#redText{
    color:red;
    font-weight:bold;
}

#greenText{
    color:green;
    font-weight:bold;
}

#orangeText{
    color:orange;
    font-weight:bold;
}

#wordTips{
    padding:1em;
}

.tab-pane{
    padding:1em;
}

#myTabContent{
    min-width: 780px;
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
div#modalContainer{
    -webkit-transition:all 800ms ease;
    overflow:hidden;
}

div.displayForm{
    border-radius:10px;
}

div.loadingForm{
    height:10em;
    border-radius:75px;
}

.classCard {
  background-color: #f5f5f5;
  color: black;
  transition: 0.3s;
}

.classCard:hover {
  background-color: #026cc7;
  color: white;
}

</style>
<script>document.getElementsByTagName("html")[0].className += " js";</script>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-sm-12" >

            <h2>
            <strong>Online Learning System</strong>
            <small class="h4 text-muted">Student Panel</small>
            </h2>




            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="dashboard-tab" data-toggle="tab" href="#timeTable" role="tab" aria-controls="timeTable" aria-selected="true"><strong>Time Table</strong></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="classes-tab" data-toggle="tab" href="#Classes" role="tab" aria-controls="Classes" aria-selected="false"><strong>Classes</strong></a>
                </li>
            </ul>

            <div class="tab-content border-left border-right border-bottom" id="myTabContent">

                <div class="tab-pane fade show active" id="timeTable" role="tabpanel" aria-labelledby="timeTable-tab">
                    <div id="wordTips">
                        <h5><strong>Time Table</strong></h5>
                        <span></span>
                    </div>

                    <div id="tTable_View">

                    </div>
                </div>

                <div class="tab-pane fade" id="Classes" role="tabpanel" aria-labelledby="Classes-tab">
                    <div id="wordTips">
                        <h5><strong>Classes</strong></h5>
                        <span></span>
                    </div>

                    <div id="classes_View">

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- time Adjustment Detail -->
<div class="modal fade" name="timeAdjModal" id="timeAdjModal" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content displayForm" id="l_modalContainer">

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

<script>
$(document).ready(function uptable(){
    //get Time Table
    $.ajax({
         type: "GET",
         url: "/stud/getTimeSpecificTimeTable",
         data: '_token = <?php echo csrf_token() ?>',
         success:function (data) {
             $('#tTable_View').html(data);

             assignColor();
         }
    });

    //classes card load
    $.ajax({
         type: "GET",
         url: "/stud/getClasses",
         data: '_token = <?php echo csrf_token() ?>',
         success:function (data) {
             $('#classes_View').html(data);
         }
    });

});



</script>



@endsection
