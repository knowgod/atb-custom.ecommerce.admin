<div class="grid-bottom mdl-shadow--2dp" ng-controller="GridBottomController" ng-class="{'is-shown':isVisible}" ng-init='init("gridCollection")'>
    <div class="grid-bottom--inner">
        <div class="grid-selected" ng-show="checkboxData.length">
            Selected: <% checkboxData.length %>
            <button id="grid-menu-lower-right" class="mdl-button mdl-js-button mdl-button--icon mdl-button-on-white">
            <i class="material-icons">more_vert</i>
            </button>

            <ul class="mdl-menu mdl-menu--top-right mdl-js-menu mdl-js-ripple-effect"
            for="grid-menu-lower-right">
            <li class="mdl-menu__item" ng-disabled="!checkboxData.length" ng-click="invokeMassAction('delete');">Delete</li>
            <li class="mdl-menu__item" ng-disabled="!checkboxData.length" ng-click="invokeMassAction('another_action');">Another Action</li>
            </ul>

        </div>
        <div class="mdl-layout-spacer"></div>
        <div class="pager">
            <div class="per_page">Rows per page
                <a id="pager_per-page"><span><% data.per_page %></span><i class="material-icons">arrow_drop_down</i></a>
                <ul class="mdl-menu mdl-menu--top-right mdl-js-menu mdl-js-ripple-effect per-page--menu"
                    for="pager_per-page">
                    <li class="mdl-menu__item" ng-repeat="item in perPageCollection" ng-disabled="data.per_page == item">
                        <a ng-click="invokeNavAction('perPage',item)" href=""><% item %></a>
                    </li>
                </ul>
            </div>
            <div class="pages"><% (data.current_page-1)*data.per_page+1 %>-<% helper.Math.min(data.current_page*data.per_page, data.total) %>
                of <% data.total %></div>

            <div ng-show="data.total>data.per_page" class="pagination">
                <a ng-click="invokeNavAction('navigation','prev')" ng-class="1 == data.current_page ? 'active' : ''" href="#" class="mdl-button mdl-js-button mdl-button--icon">
                    <i class="material-icons">chevron_left</i>
                </a>
                <a ng-click="invokeNavAction('navigation','next')" ng-class="data.last_page == data.current_page ? 'active' : ''" href="#" class="mdl-button mdl-js-button mdl-button--icon">
                    <i class="material-icons">chevron_right</i>
                </a>
            </div>
        </div>
    </div>
</div>
