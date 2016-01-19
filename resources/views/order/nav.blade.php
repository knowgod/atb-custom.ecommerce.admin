<div class="mdl-layout__drawer" ng-controller="GridLeftController">
    <nav class="mdl-navigation">

        <a id="website-switcher" class="mdl-navigation__link website-switcher">
            <i class="material-icons target" role="presentation">business</i><% (filter.website.length) ? websites[filter.website]:'All websites' %>
            <i class="material-icons small">arrow_drop_down</i>
        </a>
        <ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect website-switcher__menu"
            for="website-switcher">
            <li class="mdl-menu__item"><a href="" ng-click="invokeNavAction('website', '')">All Websites</a></li>
            <li class="mdl-navigation__separator"></li>
            <li class="mdl-menu__item"><a href="" ng-click="invokeNavAction('website', 'nume')">Nume Products</a></li>
            <li class="mdl-menu__item"><a href="" ng-click="invokeNavAction('website', 'belletto')">Belletto Studio</a></li>
            <li class="mdl-menu__item"><a href="" ng-click="invokeNavAction('website', 'nutika')">Nutika</a></li>
        </ul>


        <span class="mdl-navigation__separator"></span>

        <a class="mdl-navigation__link" href="" ng-click="invokeNavAction('status', 'Pending')">
            <i class="material-icons" ng-class="{'active':filter.status=='Pending'}" role="presentation">add_to_photos</i>Work
            Queue <span class="count">50</span></a>
        <a class="mdl-navigation__link" href="" ng-click="invokeNavAction('status', 'Processing')">
            <i class="material-icons" ng-class="{'active':filter.status=='Processing'}" role="pretation">assignment_returned</i>Processing
            <span class="count">1.5k</span></a>
        <a class="mdl-navigation__link" href="" ng-click="invokeNavAction('status', 'Shipping')">
            <i class="material-icons" ng-class="{'active':filter.status=='Shipping'}" role="presentation">flight</i>Shipping
            <span class="count">50</span></a>
        <a class="mdl-navigation__link" href="" ng-click="invokeNavAction('status', 'Under Review')">
            <i class="material-icons" ng-class="{'active':filter.status=='Under Review'}" role="pretation">warning</i>Open Issues
            <span class="count">23k</span></a>
        <a class="mdl-navigation__link" href="" ng-click="invokeNavAction('status', 'Shipped')">
            <i class="material-icons" ng-class="{'active':filter.status=='Shipped'}" role="presentation">done</i>Completed
            <span class="count">150k</span></a>

        <span class="mdl-navigation__separator"></span>

        <a class="mdl-navigation__link" href="/"><i class="material-icons target">equalizer</i>Reports</a>

        <span class="mdl-navigation__separator"></span>

        <a class="mdl-navigation__link" href="/"><i class="material-icons target">view_column</i>Grid Columns</a>
        <a class="mdl-navigation__link" href="/"><i class="material-icons target">filter_list</i>Manage Filters</a>

        <span class="mdl-navigation__separator"></span>

        <a class="mdl-navigation__link" href=""><i class="material-icons target">add</i>Create</a>
        <a class="mdl-navigation__link" href=""><i class="material-icons target">call_made</i>Import</a>
        <a class="mdl-navigation__link" href=""><i class="material-icons target">call_received</i>Export</a>

        <div class="mdl-layout-spacer"></div>

        <span class="mdl-navigation__separator"></span>
        <a class="mdl-navigation__link" href=""><i class="material-icons self-background target" role="presentation">info</i>Help</a>
    </nav>
</div>
