<script>
    window['gridOrderStatusCollection'] = <?php echo json_encode($order_statuses_count); ?>;

</script>
<div class="mdl-layout__drawer" ng-controller="GridLeftController" ng-init="init({'statusCount':'gridOrderStatusCollection'})">
    <nav class="mdl-navigation" ng-cloak>

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
            <i class="material-icons" ng-class="{'active':filter.status=='Pending'}" role="presentation">add_to_photos</i>
            <span class="text mdl-layout-spacer">Work Queue</span>
            <span class="count"><% data.statusCount['Pending'] %></span></a>

        <a class="mdl-navigation__link" href="" ng-click="invokeNavAction('status', 'Processing')">
            <i class="material-icons" ng-class="{'active':filter.status=='Processing'}" role="pretation">assignment_returned</i>
            <span class="text mdl-layout-spacer">Processing</span>
            <span class="count"><% data.statusCount['Processing'] %></span></a>

        <a class="mdl-navigation__link" href="" ng-click="invokeNavAction('status', 'Shipped')">
            <i class="material-icons" ng-class="{'active':filter.status=='Shipped'}" role="presentation">flight</i>
            <span class="text mdl-layout-spacer">Shipping</span>
            <span class="count"><% data.statusCount['Shipped'] %></span></a>

        <a class="mdl-navigation__link" href="" ng-click="invokeNavAction('status', 'Under Review')">
            <i class="material-icons" ng-class="{'active':filter.status=='Under Review'}" role="pretation">warning</i>
            <span class="text mdl-layout-spacer">Open Issues</span>
            <span class="count"><% data.statusCount['Under Review'] %></span></a>

        <a class="mdl-navigation__link" href="" ng-click="invokeNavAction('status', 'Closed')">
            <i class="material-icons" ng-class="{'active':filter.status=='Closed'}" role="presentation">done</i>
            <span class="text mdl-layout-spacer">Completed</span>
            <span class="count"><% data.statusCount['Closed'] %></span></a>

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
