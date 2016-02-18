@extends('layouts.app')

@section('title', 'Excelsior!')

@section('content')
    <script>
        window['gridCollection'] = <?php echo json_encode($collection);?>;
        window['gridCollection'].urlBase = 'role';
    </script>

    <div class="main-content">
        <div class="grid-ctrl" ng-controller='GridController' ng-init='init("gridCollection")'>
            <div >
                <div class="mdl-cell mdl-cell--12-col mdl-shadow--2dp mdl-color--white mdl-data-table--container">

                    <table class="mdl-data-table wide-table mdl-data-table--selectable" ng-cloak>
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
                            <th class="mdl-data-table__cell--non-numeric mdl-data-table__cell--buttons filter-field" ng-click="updateSortOrder('name')">
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-button-on-white"
                                        ng-show="query.orderBy=='name'">
                                    <i class="material-icons"><% query.orderDirection=='DESC' ? 'arrow_downward' : 'arrow_upward' %></i>
                                </button>
                                Role Name
                            </th>
                            <th>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="mdl-data-table--body">
                        <tr ng-repeat="item in data.data track by item.id" ng-class="{'is-selected' : rowSelected(item.id)}" ng-cloak>
                            <td class="narrow">
                                <div data-mdl-checkbox el="item" prefix="checkbox-grid"></div>
                            </td>
                            <td class="mdl-data-table__cell--non-numeric"><% item.id %></td>
                            <td class="mdl-data-table__cell--non-numeric"><% item.name %></td>
                            <td class="actions">
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-button-on-white" ng-click="invokeHtmlAction('/role/update/id/'+item.id)">
                                    <i class="material-icons">create</i>
                                </button>
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-button-on-white" ng-click="invokeAction('/role/delete/id/'+item.id)">
                                    <i class="material-icons">block</i>
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
    @include('role.nav')
@endsection