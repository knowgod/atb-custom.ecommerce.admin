@extends('layouts.app')

@section('title', 'Excelsior!')

@section('content')
    <script>
        window['gridCollection'] = <?php echo json_encode($collection); ?>;
        window['gridCollection'].urlBase = 'order';
        window['gridCollection'].columns = {
            'increment_id':true,
            'status':true,
            'createdAt':true,
            'customer_name':true,
            'grand_total':true,
            'qty':true,
            'coupon_code':true,
            'payment_method':true
        }
    </script>

    <div class="main-content">
        <div class="grid-ctrl" ng-controller='GridController' ng-init='init("gridCollection");'>
            <div>
                <div class="mdl-cell mdl-cell--12-col mdl-shadow--2dp mdl-color--white mdl-data-table--container">

                    <table class="mdl-data-table wide-table mdl-data-table--selectable" ng-cloak>
                        <thead>
                        <tr>
                            <th class="narrow">
                                <label class="mdl-checkbox mdl-checkbox-grid mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-grid">
                                    <input type="checkbox" id="checkbox-grid" class="mdl-checkbox__input" ng-click="checkbox.massAction()" ng-model="massCheckbox">
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
                            <th class="mdl-data-table__cell--non-numeric mdl-data-table__cell--buttons filter-field" ng-click="updateSortOrder('customer_name')">
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-button-on-white"
                                        ng-show="query.orderBy=='customer_name'">
                                    <i class="material-icons"><% query.orderDirection=='DESC' ? 'arrow_downward' : 'arrow_upward' %></i>
                                </button>
                                Ship To Name
                            </th>
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
                            <th class="mdl-data-table__cell--non-numeric mdl-data-table__cell--buttons filter-field" ng-click="updateSortOrder('coupon_code')">
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-button-on-white"
                                        ng-show="query.orderBy=='coupon_code'">
                                    <i class="material-icons"><% query.orderDirection=='DESC' ? 'arrow_downward' : 'arrow_upward' %></i>
                                </button>
                                Coupon
                            </th>
                            <th class="mdl-data-table__cell--non-numeric mdl-data-table__cell--buttons filter-field" ng-click="updateSortOrder('payment_method')">
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-button-on-white"
                                        ng-show="query.orderBy=='payment_method'">
                                    <i class="material-icons"><% query.orderDirection=='DESC' ? 'arrow_downward' : 'arrow_upward' %></i>
                                </button>
                                Pay Method
                            </th>

                        </tr>
                        </thead>
                        <tbody class="mdl-data-table--body">
                        <tr ng-repeat="item in data.data track by item.id"  on-finish-render="ngRepeatFinished" ng-class="{'is-selected' : rowSelected(item.id)}">
                            <td class="narrow checkbox-data-holder" data-holder="<% item.id %>">
                                <div data-mdl-checkbox el="item" prefix="checkbox-grid"></div>
                            </td>
                            <td class="mdl-data-table__cell--non-numeric"><span class="open-view" ng-click="invokeDetailView()"><% item.increment_id %></span></td>
                            <td class="mdl-data-table__cell--non-numeric"><% item.status %></td>
                            <td class="mdl-data-table__cell--non-numeric"><% item.createdAt.date %></td>
                            <td class="mdl-data-table__cell--non-numeric narrow-all narrow-flag">
                                <flag-image code="item"></flag-image>
                            </td>
                            <td class="mdl-data-table__cell--non-numeric"><% item.customer_name %></td>
                            <td class="mdl-data-table__cell--non-numeric">$<% item.grand_total %></td>
                            <td class="mdl-data-table__cell--non-numeric"><% item.qty %></td>
                            <td class="mdl-data-table__cell--non-numeric"><% item.coupon_code %></td>
                            <td class="mdl-data-table__cell--non-numeric"><% item.payment_method %></td>

                        </tr>
                        </tbody>
                    </table>

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

@section('page.bottom')
    @include('layouts.shared.page_bottom')
@endsection

@section('navigation')
    @include('order.nav')
@endsection

@section('content.detail')
    @include('order.detail')
@endsection