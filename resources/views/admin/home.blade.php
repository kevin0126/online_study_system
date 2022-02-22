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

</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-sm-12">

            <h2>
            <strong>Online Learning System</strong>
            <small class="h4 text-muted">Admin Panel</small>
            </h2>




            <ul class="nav nav-tabs" id="myTab" role="tablist">

                <li class="nav-item">
                    <a class="nav-link active" id="student-tab" data-toggle="tab" href="#student" role="tab" aria-controls="student" aria-selected="false"><strong>Students Management</strong></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="lecturer-tab" data-toggle="tab" href="#lecturer" role="tab" aria-controls="home" aria-selected="true"><strong>Lecturers Management</strong></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="class-tab" data-toggle="tab" href="#class" role="tab" aria-controls="home" aria-selected="true"><strong>Classes Management</strong></a>
                </li>
            </ul>

            <div class="tab-content border-left border-right border-bottom" id="myTabContent">

                <div class="tab-pane fade show active" id="student" role="tabpanel" aria-labelledby="student-tab">
                    <div id="wordTips">
                        <h5><strong>Students List Management</strong></h5>
                        <span></span>
                    </div>

                    <div id="student_View">

                    </div>
                </div>

                <div class="tab-pane fade" id="lecturer" role="tabpanel" aria-labelledby="lecturer-tab">
                    <div id="wordTips">
                        <h5><strong>Lecturers List Management</strong></h5>
                        <span></span>
                    </div>

                    <div id="lecturer_View">

                    </div>
                </div>

                <div class="tab-pane fade" id="class" role="tabpanel" aria-labelledby="class-tab">
                    <div id="wordTips">
                        <h5><strong>Classes Management</strong></h5>
                        <span></span>
                    </div>

                    <div id="class_View">

                    </div>
                </div>


        </div>

        </div>
    </div>
</div>

<!-- bootstrap modal -->
<div class="modal fade" name="studModal" id="studModal" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content displayForm" id="s_modalContainer">

    <div class="modal-header">
        <span class="h5 modal-title" style=" margin-bottom: 0px; margin-top:0px;">Student Detail</span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="studentDetail modal-body" id="dataAll" name="dataAll">

    </div>
    <div class="modal-footer">
        <button name="s_activate" id="s_activate" value="" class="btn btn-success s_btnStatus">ACTIVATE</button>
        <button name="s_deactivate" id="s_deactivate" value="" class="btn btn-danger s_btnStatus">DEACTIVATE</button>

        <a name="s_edit" id="s_edit" href="" class="btn btn-primary">EDIT</a>

        <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
    </div>

    </div>
</div>
</div>

<div class="modal fade" name="lecturModal" id="lecturModal" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content displayForm" id="l_modalContainer">

    <div class="modal-header">
        <span class="h5 modal-title" style=" margin-bottom: 0px; margin-top:0px;">Lecturer Detail</span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="lecturerDetail modal-body" id="dataAll" name="dataAll">

    </div>
    <div class="modal-footer">
        <button name="l_activate" id="l_activate" value="" class="btn btn-success l_btnStatus">ACTIVATE</button>
        <button name="l_deactivate" id="l_deactivate" value="" class="btn btn-danger l_btnStatus">DEACTIVATE</button>

        <a name="l_edit" id="l_edit" href="" class="btn btn-primary">EDIT</a>

        <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
    </div>

    </div>
</div>
</div>

<div class="modal fade" name="classModal" id="classModal" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content displayForm" id="c_modalContainer">

    <div class="modal-header">
        <span class="h5 modal-title" style=" margin-bottom: 0px; margin-top:0px;">Class Detail</span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="classDetail modal-body" id="dataAll" name="dataAll">

    </div>
    <div class="modal-footer c_choice">
        <a name="c_activate" id="c_activate" href="" class="btn btn-success">SETUP</a>
        <button name="c_deactivate" id="c_deactivate" value="" data-toggle="modal" data-target="#resetSingleModal" class="btn btn-danger">RESET</button>

        <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
    </div>

    </div>
</div>
</div>

<!-- Reset all classes modal -->
<div class="modal fade" name="comfirmModal" id="comfirmModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Are you sure?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Did you want to proceed?</p>
        <p>( Information of every classes which exist such as class students and times will be remove )</p>
      </div>
      <div class="modal-footer resetAll">
        <button type="button" class="btn btn-primary" id="btnRstAll">PROCEED</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
      </div>
    </div>
  </div>
</div>

<!-- Reset Single classes modal -->
<div class="modal fade" name="resetSingleModal" id="resetSingleModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="resetModalTitle_Single">Reset Class ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Did you want to proceed?</p>
        <p>( Information such as class students and times will be remove )</p>
      </div>
      <div class="modal-footer resetSingle">
        <button type="button" class="btn btn-primary" value="" id="btnRstSingle">PROCEED</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
      </div>
    </div>
  </div>
</div>

<!-- Backup classes modal -->
<div class="modal fade" name="backupModal" id="backupModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Classes Schedule Backup</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="form-inline">
            <label for="success" class="control-label">BackUp Name</label>
            <input type="text" value="" name="bkName" class="form-control cf-form ml-4 col-sm-8" id="bkName"  placeholder="Exp: backup-yyyy-mm-dd">
        </div>

        <div class="control-form mt-2" id="bkList">

        </div>


      </div>
      <div class="modal-footer backupTime">
        <button type="button" class="btn btn-primary" id="btnBKComfirm">BACKUP</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
      </div>
    </div>
  </div>
</div>

<!-- backup record replace modal -->
<div class="modal fade" name="bkreplaceModal" id="bkreplaceModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Comfirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>We have found a backup record with that same name.</p>
        <p>Do you wanted too replace it with the new one?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" value="" id="replaceComfirm">YES</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">NO</button>
      </div>
    </div>
  </div>
</div>

<!-- Backup classes modal -->
<div class="modal fade" name="restoreModal" id="restoreModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Classes Schedule Backup Restore</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Please select the Backup you wanted to restore.</p>

        <div class="control-form mt-2" id="restoreList">

        </div>


      </div>
      <div class="modal-footer restoreTime">
        <button type="button" class="btn btn-primary" id="btnRestoreComfirm">RESTORE</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
      </div>
    </div>
  </div>
</div>


<script>
$(document).ready(function uptable(){

    //student table
    $.ajax({
         type: "GET",
         url: "/DT_stud",
         data: '_token = <?php echo csrf_token() ?>',
         success:function (data) {
             $('#student_View').html(data);
         }
    });

    //lecturer table
    $.ajax({
         type: "GET",
         url: "/DT_lectur",
         data: '_token = <?php echo csrf_token() ?>',
         success:function (data) {
             $('#lecturer_View').html(data);
         }
    });

    //Class Table
    $.ajax({
         type: "GET",
         url: "/DT_class",
         data: '_token = <?php echo csrf_token() ?>',
         success:function (data) {
             $('#class_View').html(data);
         }
    });

})

//student detail modal
$(document).on('show.bs.modal','#studModal', function (event) {
    var button = $(event.relatedTarget)
    var StudID = button.data('id');
    var dataString = "/getStud/" + StudID;
    var status = button.data('status');

    $.ajax({
        type: "GET",
        url: dataString,
        success: function (data){
            $('.studentDetail').html(data);
            //$('#applyApprove').val(companyID);
            $('#s_activate').val(StudID);
            $('#s_deactivate').val(StudID);
            $("#s_edit").attr("href", "/home/editStud/"+StudID);

            if(status == 1){
                document.getElementById('s_activate').style.display = 'none';
                document.getElementById('s_deactivate').style.display = 'inline';
            }else{
                document.getElementById('s_activate').style.display = 'inline';
                document.getElementById('s_deactivate').style.display = 'none';
            }



            //console.log(data);
        },
    });
})

//lecturer detail modal
$(document).on('show.bs.modal','#lecturModal', function (event) {
    var button = $(event.relatedTarget)
    var lecturID = button.data('id');
    var dataString = "/getLectur/" + lecturID;
    var status = button.data('status');

    $.ajax({
        type: "GET",
        url: dataString,
        success: function (data){
            $('.lecturerDetail').html(data);
            //$('#applyApprove').val(companyID);
            $('#l_activate').val(lecturID);
            $('#l_deactivate').val(lecturID);
            $("#l_edit").attr("href", "/home/editLect/"+lecturID);
            //alert(lecturID);

            if(status == 1){
                document.getElementById('l_activate').style.display = 'none';
                document.getElementById('l_deactivate').style.display = 'inline';
            }else{
                document.getElementById('l_activate').style.display = 'inline';
                document.getElementById('l_deactivate').style.display = 'none';
            }



            //console.log(data);
        }
    });
})

//class detail modal
$(document).on('show.bs.modal','#classModal', function (event) {
    var button = $(event.relatedTarget)
    var classID = button.data('id');
    var dataString = "/getClass/" + classID;
    var status = button.data('status');

    $.ajax({
        type: "GET",
        url: dataString,
        success: function (data){
            $('.classDetail').html(data);
            //$('#applyApprove').val(companyID);
            $('#c_activate').attr("href", "/home/setupClass/" + classID);

            $('#c_deactivate').val(classID);
            $('#btnStudList').val(classID);

            //alert(lecturID);

            if(status == 1){
                document.getElementById('c_activate').style.display = 'none';
                document.getElementById('c_deactivate').style.display = 'inline';
            }else{
                document.getElementById('c_activate').style.display = 'inline';
                document.getElementById('c_deactivate').style.display = 'none';
            }



            //console.log(data);
        },

    });
})

//@classDetailModal->btnStudentList
$('#c_modalContainer').on('click','#btnStudList',function(e){
    var classID = this.value;
    var dataString = "/ClassStudList/" + classID;

    window.open(dataString,'test','width=770px,height=400px');

})

//@StudentDetailModal->btnActivate
$('#s_modalContainer').on('click','.s_btnStatus',function(e){
    var targetID = this.value;
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var choice;

    if(this.id === 's_deactivate'){
        choice = "deactivate";
    }else{
        choice = "activate";
    }

    $.ajax({
        type: "POST",
        url: "/targetStatusChange",
        data: {
            targetID: targetID,
            choice: choice,
            _token: _token
        },
        cache: false,
        success: function (data2) {
            var dataString = "/getStud/" + targetID;

            $.ajax({
                type: "GET",
                url: dataString,
                success: function (data){
                    $('.studentDetail').html(data);
                    $('#s_activate').val(targetID);
                    $('#s_deactivate').val(targetID);
                    $("#s_edit").attr("href", "/home/editStud/"+targetID);

                    if(choice === 'activate'){
                        document.getElementById('s_activate').style.display = 'none';
                        document.getElementById('s_deactivate').style.display = 'inline';
                    }else{
                        document.getElementById('s_activate').style.display = 'inline';
                        document.getElementById('s_deactivate').style.display = 'none';
                    }

                    //student table
                    $.ajax({
                        type: "GET",
                        url: "/DT_stud",
                        data: '_token = <?php echo csrf_token() ?>',
                        success:function (data) {
                            $('#student_View').html(data);
                        }
                    });
                },
            });
        },
    });

});

//@LecturerDetailModal->btnActivate
$('#l_modalContainer').on('click','.l_btnStatus',function(e){
    var targetID = this.value;
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var choice;

    if(this.id === 'l_deactivate'){
        choice = "deactivate";
    }else{
        choice = "activate";
    }

    $.ajax({
        type: "POST",
        url: "/targetStatusChange",
        data: {
            targetID: targetID,
            choice: choice,
            _token: _token
        },
        cache: false,
        success: function (data2) {
            var dataString = "/getLectur/" + targetID;

            $.ajax({
                type: "GET",
                url: dataString,
                success: function (data){
                    $('.lecturerDetail').html(data);
                    $('#l_activate').val(targetID);
                    $('#l_deactivate').val(targetID);
                    $("#l_edit").attr("href", "/home/editLect/"+targetID);

                    if(choice === 'activate'){
                        document.getElementById('l_activate').style.display = 'none';
                        document.getElementById('l_deactivate').style.display = 'inline';
                    }else{
                        document.getElementById('l_activate').style.display = 'inline';
                        document.getElementById('l_deactivate').style.display = 'none';
                    }

                    //Lecturer table
                    $.ajax({
                        type: "GET",
                        url: "/DT_lectur",
                        data: '_token = <?php echo csrf_token() ?>',
                        success:function (data) {
                            $('#lecturer_View').html(data);
                        }
                    });
                },
            });
        },
    });

});

//@classDetailModal->btnResetSingle->resetSingleModal
$(document).on('show.bs.modal','#resetSingleModal', function (event) {
    var button = $(event.relatedTarget)
    var classID = button.val();
    $('#resetModalTitle_Single').html("Reset Class ( "+classID+" ) ?");
    $('#classModal').modal('hide');

    $('#btnRstSingle').val(classID);
});

//@classDetailModal->btnResetSingle->resetSingleModal->btnRstSingle
$('.resetSingle').on('click','#btnRstSingle',function(e){
    var targetID = this.value;
    let _token   = $('meta[name="csrf-token"]').attr('content');

    var dataString = "/resetSingle/" + targetID;

    $.ajax({
        type: "GET",
        url: dataString,
        success: function (data){
            //Class Table
            $.ajax({
                type: "GET",
                url: "/DT_class",
                data: '_token = <?php echo csrf_token() ?>',
                success:function (data) {
                    $('#class_View').html(data);
                }
            });

            $('#resetSingleModal').modal('hide');
        },
    });

});

//@classDetailModal->btnResetSingle->resetSingleModal->btnRstSingle
$('.resetAll').on('click','#btnRstAll',function(e){

    $.ajax({
        type: "GET",
        url: "/resetAllClass",
        success: function (data){
            //Class Table initial
            $.ajax({
                type: "GET",
                url: "/DT_class",
                data: '_token = <?php echo csrf_token() ?>',
                success:function (data) {
                    $('#comfirmModal').modal('hide');

                    $('#class_View').html(data);
                }
            });

        },
    });
});

//@get existing backup record
$(document).on('show.bs.modal','#backupModal', function (event) {

    //backup list
    $.ajax({
         type: "GET",
         url: "/bkList",
         data: '_token = <?php echo csrf_token() ?>',
         success:function (data) {
             $('#bkList').html(data);
         }
    });
});

//@get available restore record
$(document).on('show.bs.modal','#restoreModal', function (event) {
    //backup list
    $.ajax({
        type: "GET",
        url: "/restoreList",
        data: '_token = <?php echo csrf_token() ?>',
        success:function (data) {
            $('#restoreList').html(data);
        }
    });
});

//@bclass section backup modal -> select existing backup item
$(document).on('change','#bkListItem', function (event) {
    //alert($('#bkListItem option:selected').text());
    $('#bkName').val($('#bkListItem option:selected').text());

});

//@reset the bkname textfield status after change
$('#bkName').on('change', function(event){
    $('#bkName').removeClass('is-invalid');
});

//@bkclass modal -> save backup button
$('.backupTime').on('click', '#btnBKComfirm', function(event){
    var bkname = $('#bkName').val();
    if(bkname === ""){
        $('#bkName').addClass('is-invalid');
    }else{
        var dataString = "/bkRecordCheck/" + bkname;
        //alert(dataString);

        $.ajax({
            type: "GET",
            url: dataString,
            success: function (data){
                //alert(data);
                if(data == true){
                    $('#backupModal').modal('hide');
                    $('#bkreplaceModal').modal('show');
                }else{

                    dataString = "/backupClasses/" + bkname;
                    $.ajax({
                        type: "GET",
                        url: dataString,
                        success: function (data){
                            $('#backupModal').modal('hide');
                        }
                    });
                }
            },
        });
    }
});

//@handle replace backup modal
$('#replaceComfirm').on('click', function(event){

    dataString = "/backupClasses/" + $('#bkName').val();
    $.ajax({
        type: "GET",
        url: dataString,
        success: function (data){
            $('#bkreplaceModal').modal('hide');
        }
    });
});


//@bkclass modal -> save backup button
$('.restoreTime').on('click', '#btnRestoreComfirm', function(event){
    var dataString = "/bkrestore/" + $('#restoreListItem option:selected').val();

    $.ajax({
        type: "GET",
        url: dataString,
        success: function (data){
            $('#restoreModal').modal('hide');
        },
    });

});


</script>
@endsection

