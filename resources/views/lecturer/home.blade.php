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
        <div class="col-sm-12">

            <h2>
            <strong>Online Learning System</strong>
            <small class="h4 text-muted">Lecturer Panel</small>
            </h2>




            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="dashboard-tab" data-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="true"><strong>Dashboard</strong></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="classes-tab" data-toggle="tab" href="#classes" role="tab" aria-controls="classes" aria-selected="false"><strong>Classes Management</strong></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="timeAdj-tab" data-toggle="tab" href="#timeAdj" role="tab" aria-controls="timeAdj" aria-selected="true"><strong>Times Adjustment</strong></a>
                </li>
            </ul>

            <div class="tab-content border-left border-right border-bottom" id="myTabContent">
                <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                    <div id="wordTips">
                        <h5><strong>Dashboard</strong></h5>
                        <span></span>
                    </div>

                    <div id="dashboard_View">

                    </div>
                </div>

                </br>

                <div class="tab-pane fade" id="classes" role="tabpanel" aria-labelledby="classes-tab">
                    <div id="wordTips">
                        <h5><strong>Classes Management</strong></h5>
                        <span></span>
                    </div>

                    <div id="classes_View">

                    </div>
                </div>

                <div class="tab-pane fade" id="timeAdj" role="tabpanel" aria-labelledby="timeAdj-tab">
                    <div id="wordTips">
                        <h5><strong>Time Adjustment</strong></h5>
                        <span></span>
                    </div>

                    <div id="timeAdj_View">

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
    //Dashboard load
    $.ajax({
         type: "GET",
         url: "/lect/getDashboard",
         data: '_token = <?php echo csrf_token() ?>',
         success:function (data) {
             $('#dashboard_View').html(data);

             assignColor();
         }
    });

    //classes card load
    $.ajax({
         type: "GET",
         url: "/lect/getClasses",
         data: '_token = <?php echo csrf_token() ?>',
         success:function (data) {
             $('#classes_View').html(data);
         }
    });

    //Time Adjustment Datatable
    $.ajax({
         type: "GET",
         url: "/lect/getTimeAdj",
         data: '_token = <?php echo csrf_token() ?>',
         success:function (data) {
             $('#timeAdj_View').html(data);
         }
    });
});

$(document).on('show.bs.modal', '#timeAdjModal', function(event) {
   //get Time Adjustment Detail
    var button = $(event.relatedTarget)
    var timeAdjID = button.data('id');
    var getString = "/lect/getTimeAdjDetail/"+timeAdjID;

    $.ajax({
        type: "GET",
        url: getString,
        data: '_token = <?php echo csrf_token() ?>',
        success:function (data) {
            $('.timeAdjustDetail').html(data);
        }
    });

})
</script>



@endsection
