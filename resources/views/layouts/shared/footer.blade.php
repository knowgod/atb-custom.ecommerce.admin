<script src="/assets/js/angular.min.js"></script>
<script src="/assets/js/material.min.js"></script>
<script src="/assets/js/angular-sanitize.min.js"></script>
<script src="/assets/js/app.js"></script>
<script src="/assets/js/app.controllers.js"></script>
<div class="main-loader-ctrl" ng-controller="OverlayController" ng-class="{'is-visible':isVisible}">
    <div class="mdl-spinner mdl-js-spinner is-active"></div>
</div>
<div id="horisontal-loader-ctrl" class="mdl-progress mdl-js-progress mdl-progress__indeterminate" ng-controller="HorizontalLoaderController" ng-class="{'is-visible':isVisible}"></div>

