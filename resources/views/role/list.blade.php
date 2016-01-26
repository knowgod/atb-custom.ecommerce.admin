@extends('layouts.app')

@section('title', 'Excelsior!')

@section('content')

    @foreach ($collection->all() as $role)
        <div class="mdl-color-text--red-500"><?php var_dump($role) ?></div>
    @endforeach
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