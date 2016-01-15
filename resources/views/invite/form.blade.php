@extends('layouts.app')

@section('title', 'Send invite')

@section('content')

    <div class="mdl-grid">
        <div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
            <form action="/invite/store" method="POST" class="form-horizontal">
                {{ csrf_field() }}
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" name="email" type="text" id="email" value="{{ old('email') }}" >
                    <label class="mdl-textfield__label" for="email">E-Mail Address</label>
                </div>
                @include('invite.errors')

                <div class="buttons">
                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>


@endsection

