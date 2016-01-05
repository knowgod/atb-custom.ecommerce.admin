@extends('layouts.app')

@section('title', 'Profile')

@section('content')

    <div class="mdl-grid">
        <div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/updateProfile') }}">
                {!! csrf_field() !!}
                <p>Some stuff here ...</p>
                <div class="buttons">
                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
