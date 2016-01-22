@extends('layouts.app')

@section('title', 'Excelsior!')

@section('content')

    <?php var_dump($collection) ?>

@endsection

@section('bodyend')
    <div class="grid-pop-ctrl" ng-controller="GridPopController" ng-class="{'is-visible':isVisible}" ng-click="clickOuter($event)">
        <div class="grid-pop" ng-click="clickInner($event)">
            <div ng-bind-html="htmlContent" compile-template></div>
        </div>
    </div>
@endsection

@section('navigation')
    @include('user.nav')
@endsection