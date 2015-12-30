@extends('layouts.auth')

@section('content')

    <div class="login-card-wide mdl-card mdl-shadow--2dp">
        <div class="login-card-bg">
            <div class="mdl-card__title">
                <h2 class="mdl-card__title-text">Welcome</h2>
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
            </div>

            <div class="mdl-card__actions mdl-card--border">
                <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                    Sign In
                </button>
            </div>
        </form>

        <div class="mdl-card__menu">
            <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                <i class="material-icons">share</i>
            </button>
        </div>
    </div>

    <a class="btn btn-link" href="{{ url('/auth/social/login/google') }}">Login with Google</a>

@endsection
