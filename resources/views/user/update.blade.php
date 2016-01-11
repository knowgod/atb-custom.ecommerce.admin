    <div class="mdl-grid">
        <div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/user/update') }}">
                {!! csrf_field() !!}

                <input type="hidden" class="form-control" name="id" value="{{$user->id}}">
                <h3>Update User</h3>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" name="firstname" type="text" id="firstname" value="{{$user->firstname}}" >
                    <label class="mdl-textfield__label" for="firstname">First Name</label>
                </div>
                @if ($errors->has('firstname'))
                    <div class="mdl-color-text--red-500">{{ $errors->first('firstname') }}</div>
                @endif
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" name="lastname" type="text" id="lastname" value="{{$user->lastname}}" >
                    <label class="mdl-textfield__label" for="lastname">Last Name</label>
                </div>
                @if ($errors->has('lastname'))
                    <div class="mdl-color-text--red-500">{{ $errors->first('lastname') }}</div>
                @endif
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" name="email" type="text" id="email" value="{{$user->email}}" >
                    <label class="mdl-textfield__label" for="email">E-Mail Address</label>
                </div>
                @if ($errors->has('email'))
                    <div class="mdl-color-text--red-500">{{ $errors->first('email') }}</div>
                @endif

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" name="password" type="password" id="password" value="" >
                    <label class="mdl-textfield__label" for="password">Password</label>
                </div>
                @if ($errors->has('password'))
                    <div class="mdl-color-text--red-500">{{ $errors->first('password') }}</div>
                @endif

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" name="password_confirmation" type="password" id="password_confirmation" value="" >
                    <label class="mdl-textfield__label" for="password_confirmation">Confirm Password</label>
                </div>
                @if ($errors->has('password_confirmation'))
                    <div class="mdl-color-text--red-500">{{ $errors->first('password_confirmation') }}</div>
                @endif
                <div class="buttons">
                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
