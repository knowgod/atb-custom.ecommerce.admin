/*jslint
 browser: true
 */
/*global
 angular, componentHandler, atypicalApp
 */
/*property
 $apply, $emit, $last, $watch, bind, code, compile, directive, el, element,
 height, layout, link, ngBindHtml, offsetHeight, onResizeFunction, opened,
 post, prefix, querySelector, replace, restrict, scope, style, template,
 toString, upgradeDom
 */

(function () {
    'use strict';

    atypicalApp.directive('compileTemplate', function ($compile, $parse) {
        return {
            link: function (scope, element, attr) {
                var parsed = $parse(attr.ngBindHtml);

                function getStringValue() {
                    return (parsed(scope).toString() || '');
                }

                //Recompile if the template changes
                scope.$watch(getStringValue, function () {
                    $compile(element, null, -9999)(scope);  //The -9999 makes it skip directives so that we do not recompile ourselves
                });
            }
        };
    });

    atypicalApp.directive('onFinishRender', function ($timeout) {
        return {
            restrict: 'A',
            link: function (scope) {
                if (scope.$last === true) {
                    $timeout(function () {
                        scope.$emit('ngRepeatFinished');
                    });
                }
            }
        };
    });

    atypicalApp.directive('rightLayout', function ($window) {
        return {
            restrict: 'A',
            link: function (scope, element) {
                var sampleAlignContainer = document.querySelector('.mdl-layout__content');

                scope.onResizeFunction = function () {
                    element[0].style.height = sampleAlignContainer.offsetHeight + 'px';
                };

                scope.onResizeFunction();

                angular.element($window).bind('resize', function () {
                    if (!scope.layout.opened) {
                        return;
                    }
                    scope.onResizeFunction();
                    scope.$apply();
                });
            }
        };
    });

    atypicalApp.directive('mdlCheckbox', function () {
        return {
            restrict: 'EA',
            scope: {
                el: '=',
                prefix: '='
            },
            replace: true,
            template: function (element, attributes) {
                return '<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="' + attributes.prefix + '-<% el.id %>">' +
                        '<input type="checkbox" ng-click="$parent.checkbox.action(el.id, $event)" id="' + attributes.prefix + '-<% el.id %>" value="<% el.id %>" class="mdl-checkbox__input">' +
                        '</label>';
            },
            compile: function () {
                return {
                    post: function () {
                        componentHandler.upgradeDom();
                    }
                };
            }
        };
    });

    atypicalApp.directive('flagImage', function () {
        return {
            restrict: 'EA',
            scope: {
                code: '='
            },
            replace: true,
            template: '<img ng-src="/assets/images/flags/<%  code.shipping_country_code | lowercase %>.png" alt="<% code.shipping_country_code %>" />'
        };
    });

}());
