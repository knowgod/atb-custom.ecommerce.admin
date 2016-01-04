<header class="main-drawer-header">
    <img src="/assets/images/user.jpg" class="main-avatar">
    <div class="main-avatar-dropdown">
        <span>hello@example.com</span>
        <div class="mdl-layout-spacer"></div>
        <button id="accbtn" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
            <i class="material-icons" role="presentation">arrow_drop_down</i>
            <span class="visuallyhidden">Accounts</span>
        </button>
        <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="accbtn">
            <li class="mdl-menu__item" onclick="location.href='{{ url('/settings') }}';">Settings</li>
            <li class="mdl-menu__item" onclick="location.href='{{ url('/logout') }}';">Logout</li>
        </ul>
    </div>
</header>
