var atypicalApp = angular.module('atypical.app',

    ['ngSanitize'],

    function ($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    }

).factory('sharedMessageService', ['$rootScope',
        function ($rootScope) {
            return {
                emitDataUpdate: function (message, data) {
                    $rootScope.$emit(message, data);
                },
                onDataUpdate: function (message, scope, func) {
                    var unbind = $rootScope.$on(message, func);
                    scope.$on('$destroy', unbind);
                }
            };
        }
    ]);

