/*jslint
 multivar: true, browser: true, for: true
 */
/*global
 window, angular, atypicalApp, componentHandler
 */
/*property
 $on, addMessages, cancel, controller, forEach, getTime, hash, isDefined,
 isVisible, keys, length, messages, name, onDataUpdate, push, random,
 removeMessage, splice, stopInterval, text, type
 */

(function () {

    'use strict';

    atypicalApp.controller('OverlayController', ['$scope', 'sharedMessageService', function ($scope, sharedMessageService) {

        $scope.isVisible = false;

        sharedMessageService.onDataUpdate('onShowOverlay', $scope, function () {
            $scope.isVisible = true;
        });

        sharedMessageService.onDataUpdate('onCloseOverlay', $scope, function () {
            $scope.isVisible = false;
        });

    }]);

    atypicalApp.controller('HorizontalLoaderController', ['$scope', 'sharedMessageService', function ($scope, sharedMessageService) {

        $scope.isVisible = false;

        sharedMessageService.onDataUpdate('onShowHorizontalLoader', $scope, function () {
            $scope.isVisible = true;
        });

        sharedMessageService.onDataUpdate('onCloseHorizontalLoader', $scope, function () {
            $scope.isVisible = false;
        });

    }]);

    atypicalApp.controller('NotificationController', ['$scope', '$interval', 'sharedMessageService', function ($scope, $interval, sharedMessageService) {

        var stop;
        $scope.messages = [];

        $scope.removeMessage = function (hash) {

            Object.keys($scope.messages).forEach(function (key) {
                if ($scope.messages[key].hash === hash) {
                    $scope.messages.splice(key, 1);
                }
            });
        };

        $scope.addMessages = function (data) {
            var date = new Date(), i;

            for (i = 0; i < data.length; i += 1) {
                $scope.messages.push({
                    type: data[i].type,
                    text: data[i].text,
                    hash: date.getTime() + Math.random()
                });
            }
        };

        sharedMessageService.onDataUpdate('onNotification', $scope, function (message, data) {

            message.name += '.parsed';

            $scope.stopInterval();

            $scope.addMessages(data);

            stop = $interval(function () {
                if ($scope.messages.length) {
                    $scope.messages.splice(0, 1);
                } else {
                    $scope.stopInterval();
                }
            }, 2000);
        });

        $scope.stopInterval = function () {
            if (angular.isDefined(stop)) {
                $interval.cancel(stop);
                stop = undefined;
            }
        };

        $scope.$on('$destroy', function () {
            $scope.stopInterval();
        });

    }]);
}());
