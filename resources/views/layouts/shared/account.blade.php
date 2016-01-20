<header class="main-drawer-header">
    <div class="main-avatar-dropdown">
        <div class="mdl-layout-spacer"></div>
        <button id="accbtn" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">

            @if(Auth::user()->getGoogleAvatarImg())
                <img src="<?php echo Auth::user()->getGoogleAvatarImg() ?>" class="main-avatar">
            @else
                <i class="material-icons">person</i>
            @endif
            <span class="visuallyhidden">Account</span>
        </button>
        <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="accbtn">
            <li class="mdl-menu__item" disabled><?php echo Request::user()->getEmail(); ?></li>
            <li class="mdl-menu__item" onclick="location.href='{{ url('/profile') }}';">My Account</li>
            <li class="mdl-menu__item" onclick="location.href='{{ url('/logout') }}';">Logout</li>
        </ul>
    </div>
</header>
