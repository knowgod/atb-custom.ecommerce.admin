@extends('layouts.app')

@section('title', 'Users Management')

@section('content')
    <div class="main-content">
        <div class="grid-ctrl" ng-controller='GridCtrl' ng-init='data=<?php echo json_encode($collection) ?>'>
            <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--12-col mdl-shadow--2dp mdl-color--white">

                    <table class="mdl-data-table wide-table mdl-data-table--selectable">
                        <thead>
                        <tr>
                            <th>
                                <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-grid">
                                    <input type="checkbox" id="checkbox-grid" class="mdl-checkbox__input" ng-click="massCheckboxClick()" ng-model="massCheckbox">
                                </label>
                            </th>
                            <th class="mdl-data-table__cell--non-numeric">User</th>
                            <th class="mdl-data-table__cell--non-numeric">Email</th>
                            <th>
                                <button id="grid-menu-lower-right" class="mdl-button mdl-js-button mdl-button--icon mdl-button-on-white">
                                    <i class="material-icons">more_vert</i>
                                </button>

                                <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
                                    for="grid-menu-lower-right">
                                    <li class="mdl-menu__item">Some Action</li>
                                    <li class="mdl-menu__item">Another Action</li>
                                    <li disabled class="mdl-menu__item">Disabled Action</li>
                                    <li class="mdl-menu__item">Yet Another Action</li>
                                </ul>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="item in data.data">
                            <td>
                                <!-- MDL checkbox will be added here -->
                            </td>
                            <td class="mdl-data-table__cell--non-numeric"><% item.firstname %> <% item.lastname %></td>
                            <td class="mdl-data-table__cell--non-numeric"><% item.email %></td>
                            <td>
                                <a class="mdl-js-button mdl-button--primary" ng-click="openUpdate('/user/update/id/'+item.id)" href="">EDIT</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="pager" ng-show="data.total>data.per_page">
                        <ul class="pagination">
                            <li>
                                <a ng-click="navigation.prev()" href="#">«</a>
                            </li>
                            <li ng-repeat="i in getNumber(data.last_page) track by $index">
                                <a ng-click="navigation.page($index+1)" href="#"><% $index+1 %></a>
                            </li>
                            <li>
                                <a ng-click="navigation.next()" href="#">»</a>
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
    <div class="grid-pop-ctrl" ng-controller="GridPopCtrl" ng-class="{'is-visible':isVisible}" ng-click="clickOuter($event)">
        <div class="grid-pop" ng-click="clickInner($event)">
            <div ng-bind-html="htmlContent"></div>
        </div>
    </div>
@endsection