var atypicalApp = angular.module('atypical.app',

    ['ngSanitize'],

    function ($interpolateProvider, $httpProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');

        $httpProvider.interceptors.push(function($q, sharedMessageService) {
            return {
                'request': function(config) {
                    if(config.pop && config.pop == 'main'){
                        sharedMessageService.emitDataUpdate('onShowOverlay');
                    }
                    return config;
                },

                'response': function(response) {
                    sharedMessageService.emitDataUpdate('onCloseOverlay');
                    return response;
                }
            };
        });
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
]).directive('compileTemplate', function($compile, $parse){
    return {
        link: function(scope, element, attr){
            var parsed = $parse(attr.ngBindHtml);
            function getStringValue() { return (parsed(scope) || '').toString(); }

            //Recompile if the template changes
            scope.$watch(getStringValue, function() {
                $compile(element, null, -9999)(scope);  //The -9999 makes it skip directives so that we do not recompile ourselves
            });
        }
    }
});

