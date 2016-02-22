/*jslint browser: true, multivar: true  */
/*global window, angular, componentHandler */
/*property
 $emit, $on, Math, common, data, defaults, emitDataUpdate, endSymbol,
 factory, forEach, getNumberAsObject, headers, href, interceptors, join,
 keys, loader, location, module, notifications, onDataUpdate,
 parseGridStateToQueryString, push, request, response, responseError,
 startSymbol, status, upgradeDom
 */

var atypicalApp;

(function () {

    'use strict';

    atypicalApp = angular.module('atypical.app', ['ngSanitize'], function ($interpolateProvider, $httpProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');

        $httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        delete $httpProvider.defaults.headers.common['X-Requested-With'];
        $httpProvider.interceptors.push(function (sharedMessageService) {
            return {
                'request': function (config) {
                    if (config.loader && config.loader === 'round') {
                        sharedMessageService.emitDataUpdate('onShowOverlay');
                    }
                    return config;
                },

                'response': function (response) {
                    sharedMessageService.emitDataUpdate('onCloseOverlay');
                    setTimeout(componentHandler.upgradeDom, 100);
                    if (response.data !== undefined && response.data.notifications !== undefined) {
                        sharedMessageService.emitDataUpdate('onNotification', response.data.notifications);
                    }
                    return response;
                },

                'responseError': function (response) {
                    if (response.status === 401) {
                        window.location.href = '/login';
                    }
                    return response;
                }
            };
        });
    });

    atypicalApp.factory('sharedMessageService', ['$rootScope', function ($rootScope) {
        return {
            emitDataUpdate: function (message, data) {
                $rootScope.$emit(message, data);
            },
            onDataUpdate: function (message, scope, func) {
                var unbind = $rootScope.$on(message, func);
                scope.$on('$destroy', unbind);
            }
        };
    }]);

    atypicalApp.factory('helperGeneralService', ['$rootScope', function () {
        return {
            Math: window.Math,
            getNumberAsObject: function (num) {
                return [num];
            },
            parseGridStateToQueryString: function (json) {
                var query = [], item;

                Object.keys(json).forEach(function (key) {
                    if (typeof json[key] === 'object') {
                        item = json[key];
                        Object.keys(item).forEach(function (keyItem) {
                            query.push(encodeURIComponent(key) + '[' + encodeURIComponent(keyItem) + ']=' + encodeURIComponent(item[keyItem]));
                        });
                    } else {
                        query.push(encodeURIComponent(key) + '=' + encodeURIComponent(json[key]));
                    }
                });

                return query.join('&');
            }
        };
    }]);
}());
