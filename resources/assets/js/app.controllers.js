atypicalApp.controller('GridController', ['$scope', '$http', 'sharedMessageService', 'helperGeneralService',
    function ($scope, $http, sharedMessageService, helperGeneralService) {

        $scope.helper = helperGeneralService;
        $scope.query = {
            page: 1,
            orderBy: 'id',
            orderDirection: 'DESC',
            filterBy: {
                'website':'nume'
            }
        };

        $scope.massCheckbox = false;
        $scope.checkboxData = [];

        $scope.init = function (data) {
            $scope.updateGrid(window[data]);
            $scope.urlBase = window[data].urlBase;
        };

        $scope.updateSortOrder = function (field) {
            if ($scope.query.orderBy == field) {
                $scope.query.orderDirection = ($scope.query.orderDirection == 'ASC') ? 'DESC' : 'ASC';
            } else {
                $scope.query.orderBy = field;
            }
            $scope.getItems();
        };

        $scope.openUpdate = function (url) {
            var req = {
                method: 'GET',
                loader: 'round',
                url: url + '?' + $scope.helper.parseGridStateToQueryString($scope.query),
                headers: {'Accept': 'text/html, */*'}

            };
            $http(req).then(function (response) {
                sharedMessageService.emitDataUpdate('onShow', response.data);
            }, function () {
            });
        };

        $scope.updateGrid = function (source) {
            $scope.data = source;
            sharedMessageService.emitDataUpdate('onUpdateGrid', $scope.data);
        };

        $scope.invokeDelete = function (url) {
            var req = {
                method: 'GET',
                loader: 'round',
                url: url + '?' + $scope.helper.parseGridStateToQueryString($scope.query)
            };
            $http(req).then(function (response) {
                $scope.updateGrid(response.data.collection);
                $scope.checkbox.clearSelection();
                setTimeout(componentHandler.upgradeDom, 10);
            }, function () {
            });
        };

        $scope.openCreate = function () {
            var req = {
                method: 'GET',
                url: '/' + $scope.urlBase + '/create?' + $scope.helper.parseGridStateToQueryString($scope.query),
                loader: 'round',
                headers: {'Accept': 'text/html, */*'}
            };
            $http(req).then(function (response) {
                sharedMessageService.emitDataUpdate('onShow', response.data);
            }, function () {
            });
        };

        $scope.getItems = function () {
            sharedMessageService.emitDataUpdate('onShowHorizontalLoader');
            var req = {
                method: 'GET',
                url: '/' + $scope.urlBase + '/list?' + $scope.helper.parseGridStateToQueryString($scope.query)
            };
            $http(req).then(function (response) {
                $scope.checkbox.clearSelection();
                $scope.updateGrid(response.data.collection);
                //setTimeout(componentHandler.upgradeDom, 100);
                sharedMessageService.emitDataUpdate('onCloseHorizontalLoader');

            }, function () {
                sharedMessageService.emitDataUpdate('onCloseHorizontalLoader');
            });

        };

        $scope.rowSelected = function (id) {
            return $scope.checkboxData.indexOf(id.toString()) > -1;
        };

        $scope.massAction = function (action) {

            if (!$scope.checkboxData.length) return;

            var req = {
                method: 'POST',
                url: '/' + $scope.urlBase + '/mass/' + action,
                loader: 'round',
                headers: {},
                data: {
                    action: action,
                    items: $scope.checkboxData,
                    query: $scope.query
                }
            };
            $http(req).then(function (response) {
                $scope.checkbox.clearSelection();
                $scope.updateGrid(response.data.collection);
                setTimeout(componentHandler.upgradeDom, 10);
            }, function () {
            });

        };

        $scope.checkbox = {
            add: function (id) {
                var elIndex = $scope.checkboxData.indexOf(id.toString());
                if (elIndex == -1) {
                    $scope.checkboxData.push(id.toString());
                    sharedMessageService.emitDataUpdate('onSelectionGrid', $scope.checkboxData);
                }
            },

            remove: function (id) {
                var elIndex = $scope.checkboxData.indexOf(id.toString());
                if (elIndex >= 0) {
                    $scope.checkboxData.splice(elIndex, 1);
                    sharedMessageService.emitDataUpdate('onSelectionGrid', $scope.checkboxData);
                }
            },

            action: function (id, event) {
                (event.target.checked)
                    ? $scope.checkbox.add(id)
                    : $scope.checkbox.remove(id);
                sharedMessageService.emitDataUpdate('onSelectionGrid', $scope.checkboxData);
            },

            /*massAction: function () {
                $scope.checkbox.updateChildren();
                (!$scope.massCheckbox) && $scope.checkbox.clearSelection();
            },*/

            clearSelection: function () {
                var checkboxGrid = document.querySelector('.mdl-checkbox-grid');
                checkboxGrid.MaterialCheckbox.uncheck();
                $scope.checkboxData = [];
                sharedMessageService.emitDataUpdate('onSelectionGrid', $scope.checkboxData);
            },

            updateChildren: function () {
                var checkboxes = document.querySelectorAll('.mdl-data-table--body .mdl-checkbox');

                for (var index in checkboxes) {
                    if (checkboxes.hasOwnProperty(index)) {
                        if ($scope.massCheckbox) {
                            checkboxes[index].MaterialCheckbox.check();
                            $scope.checkbox.add(checkboxes[index].MaterialCheckbox.inputElement_.value);
                        } else {
                            checkboxes[index].MaterialCheckbox.uncheck();
                        }
                    }
                }
                sharedMessageService.emitDataUpdate('onSelectionGrid', $scope.checkboxData);
            }
        };

        $scope.navigation = {
            prev: function () {
                if ($scope.query.page > 1) {
                    $scope.query.page--;
                    $scope.getItems();
                }
            },
            next: function () {
                if ($scope.query.page < $scope.data.last_page) {
                    $scope.query.page++;
                    $scope.getItems();
                }
            },
            page: function (id) {
                if (id > 0 && $scope.query.page <= $scope.data.last_page && id != $scope.data.current_page) {
                    $scope.query.page = id;
                    $scope.getItems();
                }
            }
        };

        sharedMessageService.onDataUpdate('onNavAction', $scope, function (message, data) {
            switch(data.action){
                case 'navigation':
                    $scope.navigation[data.param]();
                    break;
                case 'perPage':
                    $scope.query[data.action] = data.param;
                    $scope.getItems();
                    break;
                case 'website':
                    $scope.query.filterBy[data.action] = data.param;
                    $scope.getItems();
                    break;
                case 'status':
                    $scope.query.filterBy[data.action] = data.param;
                    $scope.getItems();
                    break;
                default:
                    $scope.getItems();
                    break;
            }
        });

        sharedMessageService.onDataUpdate('onMassAction', $scope, function (message, data) {
            $scope.massAction(data.action);
        });

        $scope.$on('ngRepeatFinished', function (ngRepeatFinishedEvent) {
            componentHandler.upgradeDom();
        });

        sharedMessageService.onDataUpdate('onClose', $scope, function (message, data) {
            $scope.getItems();
        });

    }]).controller('GridBottomController', ['$scope', '$http', 'sharedMessageService', 'helperGeneralService',
    function ($scope, $http, sharedMessageService, helperGeneralService) {

        $scope.perPageCollection = [10,20,50,100];
        $scope.checkboxData = [];

        $scope.isVisible = true;
        $scope.helper = helperGeneralService;

        $scope.init = function (data) {
            $scope.data = window[data];
        };

        $scope.invokeNavAction = function(action, param){
            sharedMessageService.emitDataUpdate('onNavAction', {'action':action, 'param': param});
        };

        $scope.invokeMassAction = function(action){
            sharedMessageService.emitDataUpdate('onMassAction', {'action':action});
        };

        sharedMessageService.onDataUpdate('onUpdateGrid', $scope, function (message, data) {
            $scope.data = data;
        });

        sharedMessageService.onDataUpdate('onSelectionGrid', $scope, function (message, data) {
            $scope.checkboxData = data;
        });

    }]).controller('GridLeftController', ['$scope', 'sharedMessageService',
    function ($scope, sharedMessageService) {

        $scope.filter = {
            'website':'',
            'status':''
        };

        $scope.websites = {
            'nume':'Nume Products',
            'belletto': 'Belletto Studio',
            'nutika': 'Nutika'
        };

        $scope.invokeNavAction = function(action, param){
            sharedMessageService.emitDataUpdate('onNavAction', {'action':action, 'param': param});
            $scope.filter[action] = param;
        };

    }]).controller('GridPopController', ['$scope', '$http', 'sharedMessageService', '$sce',
    function ($scope, $http, sharedMessageService, $sce) {
        $scope.isVisible = false;
        $scope.htmlContent = '';

        $scope.clickOuter = function ($event) {
            $event.stopPropagation();
            $scope.isVisible = false;
        };

        $scope.clickInner = function ($event) {
            $event.stopPropagation();
            $event.preventDefault();
        };

        $scope.onClose = function () {
            $scope.isVisible = false;
        };

        sharedMessageService.onDataUpdate('onShow', $scope, function (message, data) {
            $scope.isVisible = true;
            $scope.htmlContent = $sce.trustAsHtml(data);
            setTimeout(componentHandler.upgradeDom, 400);
        });

        sharedMessageService.onDataUpdate('onClose', $scope, function (message, data) {
            $scope.isVisible = false;
            $scope.htmlContent = $sce.trustAsHtml('');
            setTimeout(componentHandler.upgradeDom, 400);
        });

    }]).controller('GridFormController', ['$scope', '$http', 'sharedMessageService',
    function ($scope, $http, sharedMessageService) {

        $scope.formData = {};
        $scope.formDataErrors = {};

        $scope.dataSubmit = function () {
            $scope.formDataErrors = {};
            $http.post($scope.formUrl, $scope.formData).success(function (data) {
                $scope.formData = {};
                sharedMessageService.emitDataUpdate('onClose');

            }).error(function (data) {
                $scope.formDataErrors = data;
            });
        };

    }]).controller('OverlayController', ['$scope', '$http', 'sharedMessageService',
    function ($scope, $http, sharedMessageService) {

        $scope.isVisible = false;

        sharedMessageService.onDataUpdate('onShowOverlay', $scope, function (message, data) {
            $scope.isVisible = true;
        });

        sharedMessageService.onDataUpdate('onCloseOverlay', $scope, function (message, data) {
            $scope.isVisible = false;
        });

    }]).controller('HorizontalLoaderController', ['$scope', '$http', 'sharedMessageService',
    function ($scope, $http, sharedMessageService) {

        $scope.isVisible = false;

        sharedMessageService.onDataUpdate('onShowHorizontalLoader', $scope, function (message, data) {
            $scope.isVisible = true;
        });

        sharedMessageService.onDataUpdate('onCloseHorizontalLoader', $scope, function (message, data) {
            $scope.isVisible = false;
        });

    }]);