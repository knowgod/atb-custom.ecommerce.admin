@extends('layouts.auth')

<!-- Main Content -->
@section('content')
    <div class="login-card-wide mdl-card mdl-shadow--2dp">
        <div class="login-card-bg">
            <div class="mdl-card__title">
                <img src="/assets/images/atypical-logo.png" alt="" />
            </div>
        </div>
        <form autocomplete="off" class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
            {!! csrf_field() !!}
            <div class="mdl-card__supporting-text">
                Please enter your email. We will send you a link to reset your password.
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" name="email" type="email" id="login-card-email" value="" >
                    <label class="mdl-textfield__label" for="login-card-email">E-Mail</label>
                </div>
                @if ($errors->has('email'))
                    <div class="mdl-color-text--red-500">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>

            <div class="mdl-card__actions mdl-card--border">
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                    Send
                </button>
            </div>
        </form>
    </div>
@endsection
