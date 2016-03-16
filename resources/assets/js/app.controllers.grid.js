/*jslint
 multivar: true, browser: true
 */
/*global
 window, angular, atypicalApp, componentHandler
 */
/*property
 $on, Accept, MaterialCheckbox, action, add, belletto, check, checkbox,
 checkboxData, checked, clearSelection, clickInner, clickOuter, close,
 collection, connection, controller, currentItem, current_page, data,
 dataSubmit, emitDataUpdate, error, filter, filterBy, forEach, formData,
 formDataErrors, formUrl, getItems, hasOwnProperty, headers, helper,
 htmlContent, id, indexOf, init, inputElement_, invokeAction,
 invokeDetailView, invokeHtmlAction, invokeMassAction, invokeNavAction,
 isVisible, items, keys, last_page, layout, length, loader, massAction,
 massCheckbox, method, name, navigation, next, nume, nutika, onClose,
 onDataUpdate, open, opened, orderBy, orderDirection, page, param,
 parseGridStateToQueryString, perPage, perPageCollection, post, prev, push,
 query, querySelector, querySelectorAll, remove, rowSelected, setPerPage,
 splice, status, stopPropagation, success, target, then, toString, token,
 trustAsHtml, uncheck, updateChildren, updateGrid, updateSelection,
 updateSortOrder, upgradeDom, url, urlBase, value, website, websites
 */


(function () {
    'use strict';

    atypicalApp.controller('GridController', ['$scope', '$http', 'sharedMessageService', 'helperGeneralService', function ($scope, $http, sharedMessageService, helperGeneralService) {

        $scope.helper = helperGeneralService;
        $scope.query = {
            page: 1,
            orderBy: 'id',
            orderDirection: 'DESC',
            filterBy: {}
        };

        $scope.massCheckbox = false;
        $scope.checkboxData = [];

        $scope.init = function (data) {
            $scope.updateGrid(window[data]);
            $scope.urlBase = window[data].urlBase;
            $scope.connection = window[data].connection;
            $scope.getItems();
        };

        $scope.updateSortOrder = function (field) {
            if ($scope.query.orderBy === field) {
                $scope.query.orderDirection = ($scope.query.orderDirection === 'ASC')
                    ? 'DESC'
                    : 'ASC';
            } else {
                $scope.query.orderBy = field;
            }
            $scope.getItems();
        };

        $scope.updateGrid = function (source) {
            $scope.data = source;
            sharedMessageService.emitDataUpdate('onUpdateGrid', $scope.data);
        };

        $scope.invokeAction = function (url, confirmation) {
            if (confirmation) {
                if(!confirm('Are you sure?')){
                    return;
                }
            }
                sharedMessageService.emitDataUpdate('onShowHorizontalLoader');
                var req = {
                    method: 'GET',
                    url: url + '?' + $scope.helper.parseGridStateToQueryString($scope.query)
                };
                $http(req).then(function (response) {
                    sharedMessageService.emitDataUpdate('onCloseHorizontalLoader');
                    $scope.updateGrid(response.data.collection);
                    $scope.checkbox.clearSelection();
                    setTimeout(componentHandler.upgradeDom, 10);
                }, function () {
                    sharedMessageService.emitDataUpdate('onCloseHorizontalLoader');
                });

        };

        $scope.invokeDetailView = function (item) {
            sharedMessageService.emitDataUpdate('onShowHorizontalLoader');
            var req = {
                method: 'GET',
                url: $scope.connection.url + item.id + '?api_token=' + encodeURI($scope.connection.token) +
                        '&' + $scope.helper.parseGridStateToQueryString($scope.query)
            };
            $http(req).then(function (response) {
                sharedMessageService.emitDataUpdate('onCloseHorizontalLoader');
                sharedMessageService.emitDataUpdate('onDetailViewOpen', response.data);

            }, function () {
                sharedMessageService.emitDataUpdate('onCloseHorizontalLoader');
            });
        };

        $scope.invokeHtmlAction = function (url) {
            var req = {
                method: 'GET',
                loader: 'round',
                url: url + '?' + $scope.helper.parseGridStateToQueryString($scope.query),
                headers: {'Accept': 'text/html, */*'}

            };
            $http(req).then(function (response) {
                setTimeout(componentHandler.upgradeDom, 100);
                sharedMessageService.emitDataUpdate('onShow', response.data);
            });
        };

        $scope.getItems = function () {
            var req;
            sharedMessageService.emitDataUpdate('onShowHorizontalLoader');

            //quick fix to handle api and database requests
            if (typeof $scope.connection === 'object') {
                req = {
                    method: 'GET',
                    url: $scope.connection.url + '?api_token=' + encodeURI($scope.connection.token) + '&' + $scope.helper.parseGridStateToQueryString($scope.query)
                };
            } else {
                req = {
                    method: 'GET',
                    url: '/' + $scope.urlBase + '/list?' + $scope.helper.parseGridStateToQueryString($scope.query)
                };
            }
            $http(req).then(function (response) {
                $scope.checkbox.clearSelection();
                //quick fix to handle api and database requests
                if (typeof $scope.connection === 'object') {
                    $scope.updateGrid(response.data);
                } else {
                    $scope.updateGrid(response.data.collection);
                }
                setTimeout(componentHandler.upgradeDom, 100);
                sharedMessageService.emitDataUpdate('onCloseHorizontalLoader');

            }, function () {
                sharedMessageService.emitDataUpdate('onCloseHorizontalLoader');
            });

        };

        $scope.rowSelected = function (id) {
            return $scope.checkboxData.indexOf(id.toString()) > -1;
        };

        $scope.massAction = function (action) {

            if (!$scope.checkboxData.length) {
                return;
            }

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
            });

        };

        $scope.checkbox = {
            add: function (id) {
                var elIndex = $scope.checkboxData.indexOf(id.toString());
                if (elIndex === -1) {
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
                if (event.target.checked) {
                    $scope.checkbox.add(id);
                } else {
                    $scope.checkbox.remove(id);
                }
                sharedMessageService.emitDataUpdate('onSelectionGrid', $scope.checkboxData);
            },

            massAction: function () {
                $scope.checkbox.updateChildren();
                if (!$scope.massCheckbox) {
                    $scope.checkbox.clearSelection();
                }
            },

            clearSelection: function () {
                var checkboxGrid = document.querySelector('.mdl-checkbox-grid');
                checkboxGrid.MaterialCheckbox.uncheck();
                $scope.massCheckbox = false;
                $scope.checkboxData = [];
                $scope.checkbox.updateChildren();
                sharedMessageService.emitDataUpdate('onSelectionGrid', $scope.checkboxData);
            },

            updateChildren: function () {
                var checkboxes = document.querySelectorAll('.mdl-data-table--body .mdl-checkbox');

                Object.keys(checkboxes).forEach(function (key) {
                    if ($scope.massCheckbox) {
                        checkboxes[key].MaterialCheckbox.check();
                        $scope.checkbox.add(checkboxes[key].MaterialCheckbox.inputElement_.value);
                    } else {
                        checkboxes[key].MaterialCheckbox.uncheck();
                    }
                });
                sharedMessageService.emitDataUpdate('onSelectionGrid', $scope.checkboxData);
            }
        };

        $scope.navigation = {
            prev: function () {
                if ($scope.query.page > 1) {
                    $scope.query.page -= 1;
                    $scope.getItems();
                }
            },
            next: function () {
                if ($scope.query.page < $scope.data.last_page) {
                    $scope.query.page += 1;
                    $scope.getItems();
                }
            },
            page: function (id) {
                if (id > 0 && $scope.query.page <= $scope.data.last_page && id !== $scope.data.current_page) {
                    $scope.query.page = id;
                    $scope.getItems();
                }
            }
        };

        sharedMessageService.onDataUpdate('onNavAction', $scope, function (message, data) {

            message.name += '.parsed';

            switch (data.action) {
            case 'navigation':
                $scope.navigation[data.param]();
                break;
            case 'perPage':
                $scope.query.page = 1;
                $scope.query[data.action] = data.param;
                $scope.getItems();
                break;
            case 'website':
                $scope.query.page = 1;
                $scope.query.filterBy[data.action] = data.param;
                $scope.getItems();
                break;
            case 'status':
                $scope.query.page = 1;
                $scope.query.filterBy[data.action] = data.param;
                $scope.getItems();
                break;
            default:
                $scope.getItems();
                break;
            }
        });

        sharedMessageService.onDataUpdate('onMassAction', $scope, function (message, data) {
            message.name += '.parsed';
            $scope.massAction(data.action);
        });

        sharedMessageService.onDataUpdate('onHtmlAction', $scope, function (message, data) {
            message.name += '.parsed';
            $scope.invokeHtmlAction(data);
        });

        sharedMessageService.onDataUpdate('onAction', $scope, function (message, data) {
            message.name += '.parsed';
            $scope.invokeAction(data);
        });

        $scope.$on('ngRepeatFinished', function () {
            componentHandler.upgradeDom();
        });

        sharedMessageService.onDataUpdate('onClose', $scope, function () {
            $scope.getItems();
        });

    }]);

    atypicalApp.controller('GridSecondaryController', ['$scope', '$http', 'sharedMessageService', 'helperGeneralService', function ($scope, $http, sharedMessageService, helperGeneralService) {

        $scope.helper = helperGeneralService;
        $scope.query = {
            page: 1,
            orderBy: 'id',
            perPage: 10,
            orderDirection: 'DESC',
            filterBy: {}
        };

        $scope.perPageCollection = [10, 20, 50, 100];

        $scope.massCheckbox = false;
        $scope.checkboxData = [];

        $scope.init = function (urlBase, selectedItems) {
            $scope.urlBase = urlBase;
            $scope.checkboxData = selectedItems;
            $scope.getItems();
        };

        $scope.updateSortOrder = function (field) {
            if ($scope.query.orderBy === field) {
                $scope.query.orderDirection = ($scope.query.orderDirection === 'ASC')
                    ? 'DESC'
                    : 'ASC';
            } else {
                $scope.query.orderBy = field;
            }
            $scope.getItems();
        };

        $scope.updateGrid = function (source) {
            $scope.data = source;
        };

        $scope.getItems = function () {
            sharedMessageService.emitDataUpdate('onShowHorizontalLoader');
            var req = {
                method: 'GET',
                url: '/' + $scope.urlBase + '/list?' + $scope.helper.parseGridStateToQueryString($scope.query)
            };
            $http(req).then(function (response) {
                $scope.updateGrid(response.data.collection);
                setTimeout(componentHandler.upgradeDom, 100);
                sharedMessageService.emitDataUpdate('onCloseHorizontalLoader');
                $scope.checkbox.updateSelection();
            }, function () {
                sharedMessageService.emitDataUpdate('onCloseHorizontalLoader');
            });

        };

        $scope.$on('ngRepeatFinished', function () {
            componentHandler.upgradeDom();
            $scope.checkbox.updateSelection();
        });

        $scope.rowSelected = function (id) {
            return $scope.checkboxData.indexOf(id.toString()) > -1;
        };

        $scope.setPerPage = function (count) {
            $scope.query.page = 1;
            $scope.query.perPage = count;
            $scope.getItems();
        };

        $scope.checkbox = {
            add: function (id) {
                var elIndex = $scope.checkboxData.indexOf(id.toString());
                if (elIndex === -1) {
                    $scope.checkboxData.push(id.toString());
                }
                sharedMessageService.emitDataUpdate('onSecondarySelectionGrid', $scope.checkboxData);
            },

            remove: function (id) {
                var elIndex = $scope.checkboxData.indexOf(id.toString());
                if (elIndex >= 0) {
                    $scope.checkboxData.splice(elIndex, 1);
                }
                sharedMessageService.emitDataUpdate('onSecondarySelectionGrid', $scope.checkboxData);
            },

            action: function (id, event) {
                if (event.target.checked) {
                    $scope.checkbox.add(id);
                } else {
                    $scope.checkbox.remove(id);
                }
                sharedMessageService.emitDataUpdate('onSecondarySelectionGrid', $scope.checkboxData);
            },

            massAction: function () {
                $scope.checkbox.updateChildren();
                if (!$scope.massCheckbox) {
                    $scope.checkbox.clearSelection();
                }
            },

            clearSelection: function () {
                var checkboxGrid = document.querySelector('.mdl-checkbox-grid-secondary');
                checkboxGrid.MaterialCheckbox.uncheck();
                $scope.massCheckbox = false;
                $scope.checkbox.updateChildren();
            },

            updateSelection: function () {
                var checkboxes = document.querySelectorAll('.mdl-data-table--body-secondary .mdl-checkbox'),
                    checkboxValue;
                Object.keys(checkboxes).forEach(function (key) {
                    checkboxValue = checkboxes[key].MaterialCheckbox.inputElement_.value;
                    if ($scope.checkboxData.indexOf(checkboxValue.toString()) !== -1) {
                        checkboxes[key].MaterialCheckbox.check();
                    }
                });
                sharedMessageService.emitDataUpdate('onSecondarySelectionGrid', $scope.checkboxData);
            },

            updateChildren: function () {
                var checkboxes = document.querySelectorAll('.mdl-data-table--body-secondary .mdl-checkbox');
                Object.keys(checkboxes).forEach(function (key) {
                    if ($scope.massCheckbox) {
                        checkboxes[key].MaterialCheckbox.check();
                        $scope.checkbox.add(checkboxes[key].MaterialCheckbox.inputElement_.value);
                    } else {
                        checkboxes[key].MaterialCheckbox.uncheck();
                        $scope.checkbox.remove(checkboxes[key].MaterialCheckbox.inputElement_.value);
                    }
                });
                sharedMessageService.emitDataUpdate('onSecondarySelectionGrid', $scope.checkboxData);
            }
        };

        $scope.navigation = {
            prev: function () {
                if ($scope.query.page > 1) {
                    $scope.query.page -= 1;
                    $scope.getItems();
                }
            },
            next: function () {
                if ($scope.query.page < $scope.data.last_page) {
                    $scope.query.page += 1;
                    $scope.getItems();
                }
            },
            page: function (id) {
                if (id > 0 && $scope.query.page <= $scope.data.last_page && id !== $scope.data.current_page) {
                    $scope.query.page = id;
                    $scope.getItems();
                }
            }
        };


    }]);

    atypicalApp.controller('GridBottomController', ['$scope', 'sharedMessageService', 'helperGeneralService', function ($scope, sharedMessageService, helperGeneralService) {

        $scope.perPageCollection = [10, 20, 50, 100];
        $scope.checkboxData = [];

        $scope.isVisible = true;
        $scope.helper = helperGeneralService;

        $scope.init = function (data) {
            $scope.data = window[data];
        };

        $scope.invokeNavAction = function (action, param) {
            sharedMessageService.emitDataUpdate('onNavAction', {'action': action, 'param': param});
        };

        $scope.invokeMassAction = function (action) {
            sharedMessageService.emitDataUpdate('onMassAction', {'action': action});
        };

        sharedMessageService.onDataUpdate('onUpdateGrid', $scope, function (message, data) {
            message.name += '.parsed';
            $scope.data = data;
        });

        sharedMessageService.onDataUpdate('onSelectionGrid', $scope, function (message, data) {
            message.name += '.parsed';
            $scope.checkboxData = data;
        });

    }]);

    atypicalApp.controller('GridLeftController', ['$scope', 'sharedMessageService', function ($scope, sharedMessageService) {

        $scope.data = {};

        $scope.init = function (data) {
            Object.keys(data).forEach(function (key) {
                $scope.data[key] = window[data[key]];
            });
        };

        $scope.filter = {
            'website': '',
            'status': ''
        };

        $scope.websites = {
            'nume': 'Nume Products',
            'belletto': 'Belletto Studio',
            'nutika': 'Nutika'
        };

        $scope.invokeNavAction = function (action, param) {
            sharedMessageService.emitDataUpdate('onNavAction', {'action': action, 'param': param});
            $scope.filter[action] = param;
        };

        $scope.invokeHtmlAction = function (url) {
            sharedMessageService.emitDataUpdate('onHtmlAction', url);
        };

        //not used for now
        //sharedMessageService.onDataUpdate('onUpdateGrid', $scope, function (message, data) {
        //    $scope.data.gridItems = data;
        //});


    }]);

    atypicalApp.controller('GridPopController', ['$scope', 'sharedMessageService', '$sce', function ($scope, sharedMessageService, $sce) {
        $scope.isVisible = false;
        $scope.htmlContent = '';

        $scope.clickOuter = function ($event) {
            $event.stopPropagation();
            $scope.isVisible = false;
        };

        $scope.clickInner = function ($event) {
            $event.stopPropagation();
        };

        $scope.onClose = function () {
            $scope.isVisible = false;
        };

        sharedMessageService.onDataUpdate('onShow', $scope, function (message, data) {
            message.name += '.parsed';
            $scope.isVisible = true;
            $scope.htmlContent = $sce.trustAsHtml(data);
        });

        sharedMessageService.onDataUpdate('onClose', $scope, function () {
            $scope.isVisible = false;
            $scope.htmlContent = $sce.trustAsHtml('');
        });

    }]);

    atypicalApp.controller('GridFormController', ['$scope', '$http', 'sharedMessageService', function ($scope, $http, sharedMessageService) {

        $scope.formData = {};
        $scope.formDataErrors = {};

        $scope.dataSubmit = function () {
            sharedMessageService.emitDataUpdate('onShowHorizontalLoader');
            $scope.formDataErrors = {};

            $http.post($scope.formUrl, $scope.formData).success(function (response, status) {

                if (status != 422) {
                    $scope.formData = {};
                    sharedMessageService.emitDataUpdate('onClose');
                    sharedMessageService.emitDataUpdate('onCloseHorizontalLoader');
                }

                $scope.formDataErrors = response;
                sharedMessageService.emitDataUpdate('onCloseHorizontalLoader');
            }).error(function (data) {
                $scope.formDataErrors = data;
                sharedMessageService.emitDataUpdate('onCloseHorizontalLoader');
            });
        };

        sharedMessageService.onDataUpdate('onSecondarySelectionGrid', $scope, function (message, data) {
            message.name += '.parsed';
            $scope.formData.checkboxData = data;
        });
    }]);

    atypicalApp.controller('DetailViewController', ['$scope', 'sharedMessageService', function ($scope, sharedMessageService) {

        $scope.layout = {
            opened: false,
            close: function () {
                $scope.layout.opened = false;
            },
            open: function () {
                $scope.layout.opened = true;
            }
        };

        $scope.formData = {};
        $scope.formDataErrors = {};
        $scope.currentItem = null;

        sharedMessageService.onDataUpdate('onDetailViewOpen', $scope, function (message, data) {
            message.name += '.parsed';
            $scope.currentItem = data;
            $scope.layout.open();
        });

        sharedMessageService.onDataUpdate('onDetailViewClose', $scope, function () {
            $scope.layout.close();
        });
    }]);

}());
