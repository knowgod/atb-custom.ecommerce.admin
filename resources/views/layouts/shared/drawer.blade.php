<header class="main-drawer-header">
    @if(Request::user()->google_avatar_img)
    <img src="<?php echo Request::user()->google_avatar_img ?>" class="main-avatar">
    @endif
    <div class="main-avatar-dropdown">
        <span class="max-width-175"><?php echo Request::user()->email; ?></span>
        <div class="mdl-layout-spacer"></div>
        <button id="accbtn" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
            <i class="material-icons" role="presentation">arrow_drop_down</i>
            <span class="visuallyhidden">Accounts</span>
        </button>
        <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="accbtn">
            <li class="mdl-menu__item" onclick="location.href='{{ url('/settings') }}';">My Account</li>
            <li class="mdl-menu__item" onclick="location.href='{{ url('/logout') }}';">Logout</li>
        </ul>
    </div>
</header>
