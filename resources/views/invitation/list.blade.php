@extends('layouts.app')

@section('title', 'Excelsior!')

@section('content')
    <script>
        window['gridCollection'] = <?php echo json_encode($collection); ?>;
        window['gridCollection'].urlBase = 'invitation';
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
                            <th class="mdl-data-table__cell--non-numeric mdl-data-table__cell--buttons filter-field" ng-click="updateSortOrder('email')">
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-button-on-white"
                                        ng-show="query.orderBy=='email'">
                                    <i class="material-icons"><% query.orderDirection=='DESC' ? 'arrow_downward' : 'arrow_upward' %></i>
                                </button>
                                Email
                            </th>
                            <th class="mdl-data-table__cell--non-numeric mdl-data-table__cell--buttons filter-field" ng-click="updateSortOrder('createdAt')">
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-button-on-white"
                                        ng-show="query.orderBy=='created_at'">
                                    <i class="material-icons"><% query.orderDirection=='DESC' ? 'arrow_downward' : 'arrow_upward' %></i>
                                </button>
                                Created At
                            </th>
                            <th class="mdl-data-table__cell--non-numeric mdl-data-table__cell--buttons filter-field" ng-click="updateSortOrder('updatedAt')">
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-button-on-white"
                                        ng-show="query.orderBy=='updated_at'">
                                    <i class="material-icons"><% query.orderDirection=='DESC' ? 'arrow_downward' : 'arrow_upward' %></i>
                                </button>
                                Updated At
                            </th>
                            <th class="mdl-data-table__cell--non-numeric mdl-data-table__cell--buttons filter-field" ng-click="updateSortOrder('status')">
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-button-on-white"
                                        ng-show="query.orderBy=='status'">
                                    <i class="material-icons"><% query.orderDirection=='DESC' ? 'arrow_downward' : 'arrow_upward' %></i>
                                </button>
                                Status
                            </th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="mdl-data-table--body">
                        <tr ng-repeat="item in data.data track by item.id">
                            <td class="narrow">
                                <div data-mdl-checkbox el="item" prefix="checkbox-grid"></div>
                            </td>
                            <td class="mdl-data-table__cell--non-numeric"><% item.email %></td>
                            <td class="mdl-data-table__cell--non-numeric"><% item.createdAt.date %></td>
                            <td class="mdl-data-table__cell--non-numeric"><% item.updatedAt.date %></td>
                            <td class="mdl-data-table__cell--non-numeric"><% (item.status==0) ? 'Pending':'Complete' %></td>
                            <td class="actions">
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-button-on-white" ng-click="invokeAction('/invitation/resend/id/'+item.id)">
                                    <i class="material-icons">cached</i>
                                </button>
                            </td>
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
    @include('invitation.nav')
@endsection