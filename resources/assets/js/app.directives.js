atypicalApp.directive('compileTemplate', function($compile, $parse){
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
}).directive('onFinishRender', function ($timeout) {
    return {
        restrict: 'A',
        link: function (scope, element, attr) {
            if (scope.$last === true) {
                $timeout(function () {
                    scope.$emit('ngRepeatFinished');
                });
            }
        }
    }
})
    .directive('mdlCheckbox', function() {
        return {
            restrict: 'EA',
            scope: {
                el: '='
            },
            replace: true,
            template: '<label  class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-grid-<% el.id %>">' +
            '<input type="checkbox" ng-click="$parent.checkbox.action(el.id, $event)" id="checkbox-grid-<% el.id %>" value="<% el.id %>" class="mdl-checkbox__input">'+
            '</label>',
            compile: function() {
                return {
                    pre: function() { },
                    post: function() {
                        componentHandler.upgradeDom();
                    }
                };
            }

        };
    });

