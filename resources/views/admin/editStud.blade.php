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

div#modalContainer{
    -webkit-transition:all 800ms ease;
    overflow:hidden;
}

div.displayForm{
    height:13em;
    border-radius:10px;
}

div.loadingForm{
    height:10em;
    border-radius:75px;
}
</style>

<div class="container py-4">
<div class="row h-75" style="margin-top:1.5em;">
<div class="col-sm-12 my-auto">

<div class="card card-block col-xl-6 col-lg-6 col-md-9 col-sm-12 mx-auto container" style="border-radius: 25px;">
<div class="container" id="mainCard">

    <h1><strong>Edit Student Record</strong></h1>

    <form>
    @csrf
        <input type="hidden" name="companyID" value="">

        <div class="form-group">
            <label for="success" class="control-label">Student ID #</label>
            <input type="text" value="{{ $student[0]->idCode }}" name="studID" class="form-control" id="studID" readonly>
            <div id="studID_invalid" class="invalid-feedback">
            </div>
        </div>

        <div class="form-group">
            <label for="success" class="control-label">Student Name</label>
            <input type="text" value="{{ $student[0]->name }}" name="studName" class="form-control" id="studName">
            <div id="studName_invalid" class="invalid-feedback">
            </div>
        </div>

        <div class="form-group">
            <label for="success" class="control-label">Email</label>
            <input type="email" value="{{ $student[0]->email }}" name="email" class="form-control" id="email">
            <div id="email_invalid" class="invalid-feedback">
            </div>
        </div>

        <div class="form-group">
            <label>Contact</label>
            <div class="input-group" id="phone">
                <div class="input-group-prepend">
                    <select class="custom-select input-group-text" id="phonezone" name="phonezone">
                    @if($countryCode === "+60")
                        <option value="+60" selected>MY +60</option>
                        <option value="+65">SG +65</option>
                    @else
                        <option value="+60">MY +60</option>
                        <option value="+65" selected>SG +65</option>
                    @endif
                    </select>
                </div>
                <input type="text" value="{{ $contact }}" class="form-control" name="contact" id="contact">
                <div id="phone_invalid" class="invalid-feedback">
                </div>
            </div>
        </div>

        <div class="form-inline">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="change">
                <label class="custom-control-label" for="change">Change Password</label>
            </div>
        </div>

        <div class="card" style="background:#e1e3e4;">
            <div class="card-body">

                <div class="form-group">
                    <label for="success" class="control-label">Password</label>
                    <div class="input-group" id="show_hide_password">
                        <input type="password" value="" name="password" class="form-control" id="password" readonly>

                        <div class="input-group-append">
                            <a class="input-group-text" href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                        </div>
                        <div id="password_invalid" class="invalid-feedback">
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <label for="success" class="control-label">Comfirm Password</label>
                    <div class="input-group" id="show_hide_password">
                        <input type="password" value="" name="password_confirmation" class="form-control" id="password_confirmation" readonly>
                        <div class="input-group-append">
                            <a class="input-group-text" href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <br>

        <div class="form-inline">
            <button class="btn btn-primary col-md-4" id="btnComfirm" name="btnComfirm">COMFIRM</button>
            <a class="btn btn-secondary offset-md-4 col-md-4" href="/home" type="button" id="btnBack" name="back">BACK</a>
        </div>
        </form>
    </div>
</div>
</div>
</div>
</div>

</div>

<div class="modal fade" name="comfirmModal" id="comfirmModal" data-backdrop="static" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content displayForm" id="modalContainer">
      <div class="modal-header">
        <h5 class="modal-title">Email Notification</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Did you want to email the password through user email?</p>
      </div>
      <div class="modal-footer">
        <button type="button" id="yes" class="btn btn-success">YES</button>
        <button type="button" id="no" class="btn btn-danger" data-dismiss="modal">NO</button>
      </div>
    </div>
  </div>
</div>



<script>
$(document).ready(function() {
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }
    });
});

$('.custom-control').on('change', '#change', function(e){
    const attr = $('#password').attr('readonly');

    if (typeof attr !== 'undefined' && attr !== false) {

        $('#password').prop('readonly', false);
        $('#password_confirmation').prop('readonly', false);
        //$('#password').removeAttr('readonly');
        //$('#password_confirmation').removeAttr('readonly');
    }else{
        $('#password').val('');
        $('#password_confirmation').val('');
        $('#password').prop('readonly', true);
        $('#password_confirmation').prop('readonly', true);
    }

})

$('#mainCard').on('click','#btnComfirm',function(e){
    e.preventDefault();

    var phone;
    var changePass = false;
    var password = "";
    var password_confirmation = "";
    var studID = $('#studID').val();
    var studName = $('#studName').val();
    var email = $('#email').val();
    let _token   = $('meta[name="csrf-token"]').attr('content');

    if($('#contact').val().length === 0){
        phone = "";
    }else{
        phone = $('#phonezone').val() + $('#contact').val();
    }

    if($('#change').prop("checked") == true){
        changePass = true;
        password = $('#password').val();
        password_confirmation = $('#password_confirmation').val();
    }

    $.ajax({
        type: "POST",
        url: "/updateStud",
        data: {
            studID: studID,
            studName: studName,
            email: email,
            phone: phone,
            changePass, changePass,
            password: password,
            password_confirmation: password_confirmation,
            _token: _token
        },
        cache: false,
        success: function (data) {
            if($('#change').prop("checked") == true){
                $('#comfirmModal').modal('show');
            }else{
                window.location.href = "/home";
            }
        },
        error: function (err) {
            if (err.status == 422){
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').html();

                $.each(err.responseJSON.errors, function (id, error) {
                    $('#'+id).addClass('is-invalid');
                    $('#'+id+'_invalid').html(error);
                    if(id == 'password'){
                        $('#password_confirmation').addClass('is-invalid');
                    }else if(id == 'phone'){
                        $('#contact').addClass('is-invalid');
                    }
                });


            }
        }
    });
})

$('#modalContainer').on('click','#no',function(e){
    window.location.href = "/home";
})

$('#modalContainer').on('click','#yes',function(e){
    var studID = $('#studID').val();
    let _token   = $('meta[name="csrf-token"]').attr('content');

    document.getElementById('modalContainer').classList.remove('displayForm');
    document.getElementById('modalContainer').classList.add('loadingForm');

    var loading = "<div class='d-flex justify-content-center '><div style='margin-top:4em; margin-bottom:4em;' class='spinner-border' role='status'><span class='sr-only'>Loading...</span></div></div>";
    $('#modalContainer').html(loading);

    $.ajax({
        type: "POST",
        url: "/emailPass",
        data: {
            id: studID,
            _token: _token
        },
        cache: false,
        success: function (data2) {
            document.getElementById('modalContainer').classList.add('displayForm');
            document.getElementById('modalContainer').classList.remove('loadingForm');

            var loading = "<div class='d-flex justify-content-center '><div style='margin-top:4em; margin-bottom:4em;'><span class='fa fa-check'>Success</span></div></div>";
            $('#modalContainer').html(loading);

            window.location.href = "/home";
        },
    });
    //window.location.href = "/home";
})
</script>

@endsection
