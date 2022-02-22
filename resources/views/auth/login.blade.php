@extends('layouts.header')

@section('content')

<style>
body,html{
    height:100%;
}
.btnLogin{
    border-radius: 0px 0px 15px 15px;
    font-size: 120%
}
</style>


<div class="row h-100">
    <div class="col-sm-12 my-auto">
        <div class="container">
        <div class="card card-block col-lg-5 col-md-7 col-sm-8 mx-auto" style="border-radius: 15px;">
        <img src="/img/education_logo.png" class="card-img-top col-sm-10 offset-sm-1" alt="logo">
            <form method="POST" action="{{ route('login') }}">
                <div class="row">
                    <div class="card-body pb-0" >
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-3 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row" >
                            <div class="col-md-6 offset-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary btnLogin pt-2 col-sm-12 font-weight-bold" >
                        {{ __('LOGIN') }}
                    </button>
                </div>
            </form>

        </div>

        <!-- <div class="row justify-content-center">
        @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        @endif
        </div> -->
        </div>
    </div>
</div>
@endsection
