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

<div class="position-absolute w-100 p-4 d-flex flex-column align-items-end">
    <div class="w-25" style="position: relative;">
        <div class="toast ml-auto" role="alert" data-delay="2000" style="position: absolute; bottom: 0; right: 0;" data-autohide="true">
            <div class="toast-body alert-success">
                Lecturer Record <strong class="successID">xxxxxxx</strong> Save Succesfully
            </div>
        </div>
    </div>
</div>

<div class="container py-4">
<div class="row h-75" style="margin-top:1.5em;">
<div class="col-sm-12 my-auto">

<div class="card card-block col-xl-6 col-lg-6 col-md-9 col-sm-12 mx-auto container" style="border-radius: 25px;">
<div class="container" id="mainCard">

    <h1><strong>New Lecturer Record</strong></h1>

    <form>
    @csrf
        <input type="hidden" name="companyID" value="">

        <div class="form-group">
            <label for="success" class="control-label">Lecturer ID #</label>
            <input type="text" value="" name="lectID" class="form-control" id="lectID" placeholder="exp: ILE9203">
            <div id="lectID_invalid" class="invalid-feedback">
            </div>
        </div>

        <div class="form-group">
            <label for="success" class="control-label">Lecturer Name</label>
            <input type="text" value="" name="lectName" class="form-control" id="lectName">
            <div id="lectName_invalid" class="invalid-feedback">
            </div>
        </div>

        <div class="form-group">
            <label for="success" class="control-label">Email</label>
            <input type="email" value="" name="email" class="form-control" id="email" placeholder="exp: ILE9203@sc.edu.my">
            <div id="email_invalid" class="invalid-feedback">
            </div>
        </div>

        <div class="form-group">
            <label>Contact</label>
            <div class="input-group" id="phone">
                <div class="input-group-prepend">
                    <select class="custom-select input-group-text" id="phonezone" name="phonezone">
                        <option value="+60" selected>MY +60</option>
                        <option value="+65">SG +65</option>
                    </select>
                </div>
                <input type="text" class="form-control" name="contact" id="contact" placeholder="Exp: 1234567">
                <div id="phone_invalid" class="invalid-feedback">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="success" class="control-label">Password</label>
            <div class="input-group" id="show_hide_password">
                <input type="password" value="" name="password" class="form-control" id="password">

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
                <input type="password" value="" name="password_confirmation" class="form-control" id="password_confirmation">
                <div class="input-group-append">
                    <a class="input-group-text" href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="Continue">
                <label class="custom-control-label" for="Continue">Continue Create</label>
            </div>
        </div>

        <div class="form-inline">
            <button class="btn btn-primary col-md-4" id="btnCreate" name="btnCreate">CREATE</button>
            <a class="btn btn-secondary offset-md-4 col-md-4" href="/home" type="button" id="btnBack" name="back">BACK</a>
        </div>
        </form>
    </div>
</div>
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

$('#mainCard').on('click','#btnCreate',function(e){
    e.preventDefault();

    var phone;
    var studID = $('#lectID').val();
    var studName = $('#lectName').val();
    var email = $('#email').val();
    var password = $('#password').val();
    var password_confirmation = $('#password_confirmation').val();
    let _token   = $('meta[name="csrf-token"]').attr('content');

    if($('#contact').val().length === 0){
        phone = "";
    }else{
        phone = $('#phonezone').val() + $('#contact').val();
    }

    $.ajax({
        type: "POST",
        url: "/insertLect",
        data: {
            lectID: lectID,
            lectName: lectName,
            email: email,
            phone: phone,
            password: password,
            password_confirmation: password_confirmation,
            _token: _token
        },
        cache: false,
        success: function (data) {
            if($('#Continue').prop("checked") == true){
                $('.successID').html(lectID);
                $('.toast').toast('show');

                $('.form-control').removeClass('is-invalid');
                $('.form-control').val('');
                $('.invalid-feedback').html();

                $( "#lectID" ).focus();
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

</script>

@endsection
