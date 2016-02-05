<script src="/assets/js/angular.min.js"></script>
<script src="/assets/js/lib/angular-sanitize.min.js"></script>
<script src="/assets/js/lib/angular-animate.min.js"></script>
<script src="/assets/js/lib/datepickr.js"></script>
<script src="/assets/js/material.min.js"></script>
<script src="/assets/js/mdl.components.js"></script>
<script src="/assets/js/app.js"></script>
<script src="/assets/js/app.controllers.js"></script>
<script src="/assets/js/app.directives.js"></script>
<div class="main-loader-ctrl" ng-controller="OverlayController" ng-class="{'is-visible':isVisible}">
    <div class="mdl-spinner mdl-js-spinner is-active"></div>
</div>
<div id="horisontal-loader-ctrl" class="mdl-progress mdl-js-progress mdl-progress__indeterminate" ng-controller="HorizontalLoaderController" ng-class="{'is-visible':isVisible}"></div>

<ul class="main-notification-ctrl" ng-controller="NotificationController" ng-cloack>
    <li ng-repeat="message in messages track by message.hash" class="<% message.type %> animate-repeat" ng-click="removeMessage(message.hash)">
        <span ng-bind="message.text"></span>
    </li>
</ul>