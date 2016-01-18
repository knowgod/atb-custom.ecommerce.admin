@extends('layouts.app')

@section('title', 'Excelsior!')

@section('content')
    <script>
        window['gridCollection'] = <?php echo json_encode($collection); ?>;
        window['gridCollection'].urlBase = 'order';
        window['gridCollection'].columns = {
            'order_number':true,
            'order_status':true,
            'order_created':true,
            'order_shipping_name':true,
            'order_total':true,
            'order_qty':true,
            'order_coupon':true,
            'order_payment':true
        }
    </script>

    <div class="main-content">
        <div class="grid-ctrl" ng-controller='GridController' ng-init='init("gridCollection");'>
            <div >
                <div class="mdl-cell mdl-cell--12-col mdl-shadow--2dp mdl-color--white">

                    <table class="mdl-data-table wide-table mdl-data-table--selectable">
                        <thead>
                        <tr>
                            <th class="narrow">
                                <label class="mdl-checkbox mdl-checkbox-grid mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-grid">
                                    <input type="checkbox" id="checkbox-grid" class="mdl-checkbox__input" ng-click="checkbox.massAction()" ng-model="massCheckbox">
                                </label>
                            </th>
                            <th class="mdl-data-table__cell--non-numeric mdl-data-table__cell--buttons filter-field" ng-click="updateSortOrder('id')">
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-button-on-white"
                                        ng-show="query.orderBy=='id'">
                                    <i class="material-icons"><% query.orderDirection=='DESC' ? 'arrow_downward' : 'arrow_upward' %></i>
                                </button> ID
                            </th>
                            <th class="mdl-data-table__cell--non-numeric mdl-data-table__cell--buttons filter-field" ng-click="updateSortOrder('fullname')">
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-button-on-white"
                                        ng-show="query.orderBy=='fullname'">
                                    <i class="material-icons"><% query.orderDirection=='DESC' ? 'arrow_downward' : 'arrow_upward' %></i>
                                </button>
                                User
                            </th>
                            <th class="mdl-data-table__cell--non-numeric mdl-data-table__cell--buttons filter-field" ng-click="updateSortOrder('email')">
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-button-on-white"
                                        ng-show="query.orderBy=='email'">
                                    <i class="material-icons"><% query.orderDirection=='DESC' ? 'arrow_downward' : 'arrow_upward' %></i>
                                </button>
                                Email
                            </th>

                        </tr>
                        </thead>
                        <tbody class="mdl-data-table--body">
                        <tr ng-repeat="item in data.data track by item.id"  on-finish-render="ngRepeatFinished">
                            <td class="narrow checkbox-data-holder" data-holder="<% item.id %>">
                                <div data-mdl-checkbox el="item"></div>
                            </td>
                            <td class="mdl-data-table__cell--non-numeric"><% item.id %></td>
                            <td class="mdl-data-table__cell--non-numeric"><% item.firstname %> <% item.lastname %></td>
                            <td class="mdl-data-table__cell--non-numeric"><% item.email %></td>

                        </tr>
                        </tbody>
                    </table>
                    <div class="pager" ng-show="false && data.total>data.per_page">
                        <ul class="pagination">
                            <li>
                                <a ng-click="navigation.prev()" ng-class="1 == data.current_page ? 'active' : ''" href="#">«</a>
                            </li>
                            <li ng-repeat="i in helper.getNumberAsObject(data.last_page) track by $index">
                                <a ng-click="navigation.page($index+1)" ng-class="($index+1) == data.current_page ? 'active' : ''" href="#"><% $index+1 %></a>
                            </li>
                            <li>
                                <a ng-click="navigation.next()" ng-class="data.last_page == data.current_page ? 'active' : ''" href="#">»</a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('bodyend')
    <div class="grid-pop-ctrl" ng-controller="GridPopController" ng-class="{'is-visible':isVisible}" ng-click="clickOuter($event)">
        <div class="grid-pop" ng-click="clickInner($event)">
            <div ng-bind-html="htmlContent" compile-template></div>
        </div>
    </div>
@endsection

@section('pagination')
<div class="grid-bottom mdl-shadow--2dp" ng-controller="GridBottomController" ng-class="{'is-shown':isVisible}">
    <div class="grid-bottom--inner"></div>
</div>
@endsection

@section('navigation')
    @include('order.nav')
@endsection