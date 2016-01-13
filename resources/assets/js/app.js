var atypicalApp = angular.module('atypical.app',

    ['ngSanitize'],

    function ($interpolateProvider, $httpProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');

        $httpProvider.interceptors.push(function($q, sharedMessageService) {
            return {
                'request': function(config) {
                    if(config.loader && config.loader == 'main'){
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
]).factory('helperGeneralService', ['$rootScope',
        function ($rootScope) {
            return {
                getNumberAsObject: function(num) {
                    return new Array(num);
                },
                parseGridStateToQueryString: function(json) {
                    var query = [], i=0;
                    for(var key in json){
                        if(json.hasOwnProperty(key)){
                            if(typeof json[key] == 'object'){
                                var item = json[key];
                                for(var keyItem in item){
                                    if(item.hasOwnProperty(keyItem)){
                                        query.push(encodeURIComponent(key) + '['+encodeURIComponent(keyItem)+']=' + encodeURIComponent(item[keyItem]));
                                    }
                                }
                                i++;
                            }else{
                                query.push(encodeURIComponent(key) + '=' + encodeURIComponent(json[key]));
                            }
                        }
                    }
                    return query.join('&');
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

