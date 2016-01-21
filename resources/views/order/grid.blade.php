<div class="mdl-grid">
    <div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
        <div class="grid-pop-header mdl-color--blue-500 ">
            <div class="mdl-layout-title">
                <h4>Grid in Popup Example</h4>
            </div>
            <button ng-click="onClose()" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored">
                <i class="material-icons">close</i>
            </button>
        </div>

        <form class="form-horizontal" role="form" method="POST" action="{{ url('/order/update') }}" ng-controller="GridFormController" ng-init="formUrl='{{ url("/order/update") }}';" onsubmit="return false;">

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" ng-class="{'is-invalid': formDataErrors.sample}">
                <input class="mdl-textfield__input" name="sample" ng-model="formData.sample" type="text" id="sample" value="" >
                <label class="mdl-textfield__label" for="sample">Sample field</label>
                <span class="mdl-textfield__error"><% formDataErrors.sample[0] %></span>
            </div>

            <input type="hidden" name="_token" ng-model="formData._token" id="csrf-token" value="{{ csrf_token() }}" />

            <div class="grid-ctrl" ng-controller='GridSecondaryController' ng-init='init("order", ["101","98"]);'>
                <input type="hidden" name="ids" ng-model="formData.ids" id="ids" value="<% checkboxData.join() %>" />
                <div class="mdl-data-table--container">
                <table class="mdl-data-table wide-table mdl-data-table--selectable" ng-cloak>
                    <thead>
                    <tr>
                        <th class="narrow">
                            <label class="mdl-checkbox mdl-checkbox-grid mdl-checkbox-grid-secondary mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-grid-secondary">
                                <input type="checkbox" id="checkbox-grid-secondary" class="mdl-checkbox__input" ng-click="checkbox.massAction()" ng-model="massCheckbox">
                            </label>
                        </th>
                        <th class="mdl-data-table__cell--non-numeric mdl-data-table__cell--buttons filter-field" ng-click="updateSortOrder('increment_id')">
                            <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-button-on-white"
                                    ng-show="query.orderBy=='increment_id'">
                                <i class="material-icons"><% query.orderDirection=='DESC' ? 'arrow_downward' : 'arrow_upward' %></i>
                            </button>
                            Order #
                        </th>
                        <th class="mdl-data-table__cell--non-numeric mdl-data-table__cell--buttons filter-field" ng-click="updateSortOrder('status')">
                            <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-button-on-white"
                                    ng-show="query.orderBy=='status'">
                                <i class="material-icons"><% query.orderDirection=='DESC' ? 'arrow_downward' : 'arrow_upward' %></i>
                            </button>
                            Status
                        </th>
                        <th class="mdl-data-table__cell--non-numeric mdl-data-table__cell--buttons filter-field" ng-click="updateSortOrder('createdAt')">
                            <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-button-on-white"
                                    ng-show="query.orderBy=='createdAt'">
                                <i class="material-icons"><% query.orderDirection=='DESC' ? 'arrow_downward' : 'arrow_upward' %></i>
                            </button>
                            Created At
                        </th>
                        <th class="narrow-all"></th>
                        <th class="mdl-data-table__cell--non-numeric mdl-data-table__cell--buttons filter-field" ng-click="updateSortOrder('grand_total')">
                            <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-button-on-white"
                                    ng-show="query.orderBy=='grand_total'">
                                <i class="material-icons"><% query.orderDirection=='DESC' ? 'arrow_downward' : 'arrow_upward' %></i>
                            </button>
                            Total
                        </th>
                        <th class="mdl-data-table__cell--non-numeric mdl-data-table__cell--buttons filter-field" ng-click="updateSortOrder('qty')">
                            <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-button-on-white"
                                    ng-show="query.orderBy=='qty'">
                                <i class="material-icons"><% query.orderDirection=='DESC' ? 'arrow_downward' : 'arrow_upward' %></i>
                            </button>
                            Qty
                        </th>

                    </tr>
                    </thead>
                    <tbody class="mdl-data-table--body-secondary">
                    <tr ng-repeat="item in data.data track by item.id"  on-finish-render="ngRepeatFinished" ng-class="{'is-selected' : rowSelected(item.id)}">
                        <td class="narrow checkbox-data-holder" data-holder="<% item.id %>">
                            <data-mdl-checkbox el="item" prefix="checkbox-secondary" ></data-mdl-checkbox>
                        </td>
                        <td class="mdl-data-table__cell--non-numeric"><% item.increment_id %></td>
                        <td class="mdl-data-table__cell--non-numeric"><% item.status %></td>
                        <td class="mdl-data-table__cell--non-numeric"><% item.createdAt.date %></td>
                        <td class="mdl-data-table__cell--non-numeric narrow-all narrow-flag">
                            <flag-image code="item"></flag-image>
                        </td>
                        <td class="mdl-data-table__cell--non-numeric">$<% item.grand_total %></td>
                        <td class="mdl-data-table__cell--non-numeric"><% item.qty %></td>

                    </tr>
                    </tbody>
                </table>
                </div>
                <div class="grid-bottom grid-bottom-secondary" ng-show="data.total>0">
                    <div class="grid-bottom--inner">
                        <div class="grid-selected" ng-show="checkboxData.length">
                            Selected: <% checkboxData.length %>
                        </div>
                        <div class="mdl-layout-spacer"></div>
                        <div class="pager">
                            <div class="per_page">Rows per page
                                <a id="pager_per-page-pop"><span><% data.per_page %></span><i class="material-icons">arrow_drop_down</i></a>
                                <ul class="mdl-menu mdl-menu--top-right mdl-js-menu mdl-js-ripple-effect per-page--menu"
                                    for="pager_per-page-pop">
                                    <li class="mdl-menu__item" ng-repeat="item in perPageCollection" ng-disabled="data.per_page == item">
                                        <a ng-click="setPerPage(item)" href=""><% item %></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="pages"><% (data.current_page-1)*data.per_page+1 %>-<% helper.Math.min(data.current_page*data.per_page, data.total) %>
                                of <% data.total %></div>

                            <div ng-show="data.total>data.per_page" class="pagination">
                                <a ng-click="navigation.prev()" ng-class="1 == data.current_page ? 'active' : ''" href="#" class="mdl-button mdl-js-button mdl-button--icon">
                                    <i class="material-icons">chevron_left</i>
                                </a>
                                <a ng-click="navigation.next()" ng-class="data.last_page == data.current_page ? 'active' : ''" href="#" class="mdl-button mdl-js-button mdl-button--icon">
                                    <i class="material-icons">chevron_right</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="buttons">
                <button ng-click="onClose()" class="mdl-button mdl-js-button mdl-js-ripple-effect">
                    Cancel
                </button>
                <button ng-click="dataSubmit()" class="mdl-button mdl-js-button mdl-js-ripple-effect">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>