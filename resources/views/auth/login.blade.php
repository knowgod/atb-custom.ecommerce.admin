@extends('layouts.auth')

@section('content')

    <div class="login-card-wide mdl-card mdl-shadow--2dp">
        <div class="login-card-bg">
            <div class="mdl-card__title">
                <img src="/assets/images/atypical-logo.png" alt="" />
            </div>
        </div>
        <form autocomplete="off" class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
            {!! csrf_field() !!}
            <div class="mdl-card__supporting-text">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" name="email" type="email" id="login-card-email" value="" >
                    <label class="mdl-textfield__label" for="login-card-email">E-Mail</label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" name="password" type="password" id="login-card-password" value="">
                    <label class="mdl-textfield__label" for="login-card-password">Password</label>
                </div>
                <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="login-card-remember">
                    <input type="checkbox" id="login-card-remember" name="remember" class="mdl-checkbox__input" checked>
                    <span class="mdl-checkbox__label">Remember Me</span>
                </label>
                @if ($errors->has('email'))
                    <div class="mdl-color-text--red-500">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                @if ($errors->has('password'))
                    <div class="mdl-color-text--red-500">
                        {{ $errors->first('password') }}
                    </div>
                @endif
            </div>
            <div class="mdl-card__actions mdl-card--border">
                <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                    Sign In
                </button>
            </div>
            <div class="mdl-card__actions mdl-card--border login-card-google">
                <a class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" href="{{ url('/auth/social/login/google') }}">
                    Login with Google
                </a>
            </div>
        </form>
    </div>

@endsection
