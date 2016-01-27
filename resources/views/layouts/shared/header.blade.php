<div class="mdl-layout__header-row">
    <span class="mdl-layout-title">@yield('title')</span>
    <div class="mdl-layout__search">
        <form action="#" class="mdl-layout__search-form">
            <button class="mdl-button mdl-js-button mdl-button--icon">
                <i class="material-icons">search</i>
            </button>
            <div class="mdl-textfield mdl-js-textfield">
                <input class="mdl-textfield__input" type="text" id="mdl-layout__search-form-q">
                <label class="mdl-textfield__label" for="mdl-layout__search-form-q">Search</label>
            </div>
            <button id="header-search-options"
                    class="mdl-button mdl-js-button mdl-button--icon">
                <i class="material-icons">more_vert</i>
            </button>

            <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
                for="header-search-options">
                <li class="mdl-menu__item">Some Filter</li>
                <li class="mdl-menu__item">Another Filter</li>
                <li disabled class="mdl-menu__item">Disabled Filter</li>
                <li class="mdl-menu__item">Yet Another Filter</li>
            </ul>
        </form>
    </div>
    <div class="mdl-layout-spacer"></div>

    <button class="mdl-button--apps mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon mdl-button--colored main-menu" id="hdrbtn">
        <i class="material-icons">apps</i>
    </button>
    <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right" for="hdrbtn">
        <li class="mdl-menu__item"><a href="{{ url('/') }}"><i class="material-icons">assessment</i>Dashboard</a></li>
        <li class="mdl-menu__item"><a href="{{ url('/user/list') }}"><i class="material-icons">supervisor_account</i>Users</a></li>
        <li class="mdl-menu__item"><a href="{{ url('/order/list') }}"><i class="material-icons">inbox</i>Orders</a></li>
        <li class="mdl-menu__item"><a href="{{ url('/invitation/list') }}"><i class="material-icons">add_box</i>Invitations</a></li>
    </ul>
    <span class="mdl-layout__header--notification material-icons mdl-badge" data-badge="0">notifications</span>
    @include('layouts.shared.account')
</div>
