@extends('layouts.app')

@section('title', 'Users Management')

@section('content')
    <div class="main-content">
        <div class="grid-ctrl" ng-controller='GridController' ng-init='data=<?php echo json_encode($collection) ?>'>
            <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--12-col mdl-shadow--2dp mdl-color--white">

                    <table class="mdl-data-table wide-table mdl-data-table--selectable">
                        <thead>
                        <tr>
                            <th class="narrow">
                                <label class="mdl-checkbox mdl-checkbox-grid mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-grid">
                                    <input type="checkbox" id="checkbox-grid" class="mdl-checkbox__input" ng-click="checkbox.massAction()" ng-model="massCheckbox">
                                </label>
                            </th>
                            <th class="mdl-data-table__cell--non-numeric">ID</th>
                            <th class="mdl-data-table__cell--non-numeric">User</th>
                            <th class="mdl-data-table__cell--non-numeric">Email</th>
                            <th>
                                <button id="grid-menu-lower-right" class="mdl-button mdl-js-button mdl-button--icon mdl-button-on-white">
                                    <i class="material-icons">more_vert</i>
                                </button>

                                <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
                                    for="grid-menu-lower-right">
                                    <li class="mdl-menu__item" ng-disabled="!checkboxData.length" ng-click="massAction('delete');">Delete</li>
                                    <li class="mdl-menu__item" ng-disabled="!checkboxData.length" ng-click="massAction('another_action');">Another Action</li>
                                </ul>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="mdl-data-table--body">
                        <tr ng-repeat="item in data.data track by item.id">
                            <td class="narrow">
                                <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-grid-<% item.id %>">
                                    <input type="checkbox" ng-click="checkbox.action(item.id, $event)" id="checkbox-grid-<% item.id %>" value="<% item.id %>" class="mdl-checkbox__input">
                                </label>
                            </td>
                            <td class="mdl-data-table__cell--non-numeric"><% item.id %></td>
                            <td class="mdl-data-table__cell--non-numeric"><% item.firstname %> <% item.lastname %></td>
                            <td class="mdl-data-table__cell--non-numeric"><% item.email %></td>
                            <td>
                                <a class="mdl-js-button mdl-button--primary " ng-click="openUpdate('/user/update/id/'+item.id)" href="">EDIT</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="pager" ng-show="data.total>data.per_page">
                        <ul class="pagination">
                            <li>
                                <a ng-click="navigation.prev()" ng-class="1 == data.current_page ? 'active' : ''" href="#">«</a>
                            </li>
                            <li ng-repeat="i in getNumber(data.last_page) track by $index">
                                <a ng-click="navigation.page($index+1)" ng-class="($index+1) == data.current_page ? 'active' : ''" href="#"><% $index+1 %></a>
                            </li>
                            <li>
                                <a ng-click="navigation.next()" ng-class="data.last_page == data.current_page ? 'active' : ''" href="#">»</a>
                            </li>
                        </ul>
                    </div>

                </div>
                <div class="fab-bottom">
                    <a href="" ng-click="openCreate()" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
                        <i class="material-icons">add</i>
                    </a>
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