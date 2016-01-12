atypicalApp.controller('GridController', ['$scope', '$http', 'sharedMessageService', function($scope, $http, sharedMessageService){

    $scope.query = {
        page: 1,
        sort: 'id',
        sortOrder: 'DESC'
    };

    $scope.massCheckbox = false;
    $scope.checkboxData = [];

    $scope.filters = [];

    $scope.openUpdate = function(url){
        var req = {
            method: 'GET',
            pop: 'main',
            url: url,
            headers: { 'Accept': 'text/html, */*'},
            params: $scope.query
        };
        $http(req).then(function(response){
            sharedMessageService.emitDataUpdate('onShow', response.data);
        }, function(){ });
    };

    $scope.openCreate = function(){
        var req = {
            method: 'GET',
            url: '/user/create',
            pop: 'main',
            headers: { 'Accept': 'text/html, */*'},
            params: $scope.query
        };
        $http(req).then(function(response){
            sharedMessageService.emitDataUpdate('onShow', response.data);
        }, function(){ });
    };

    sharedMessageService.onDataUpdate('onClose', $scope, function(message, data){
        $scope.getItems();
    });

    $scope.getItems = function(){
        var req = {
            method: 'GET',
            url: '/user/list',
            pop: 'main',
            headers: {  },
                params: $scope.query
        };
        $http(req).then(function(response){
            $scope.data = response.data.collection;
            $scope.checkbox.clearSelection();
            setTimeout(componentHandler.upgradeDom, 10);
        }, function(){ });

    };

    $scope.show = function(){
        sharedMessageService.emitDataUpdate('onShow', $scope.data);
    };

    $scope.massAction = function(action){
        if($scope.checkboxData.length) {
            alert(action + ' action for ' + $scope.checkboxData.join() + 'ids')
        }
    };

    $scope.checkbox = {
        add: function(id){
            var elIndex = $scope.checkboxData.indexOf(id.toString());
            if(elIndex == -1) {
                $scope.checkboxData.push(id.toString());
            }
        },

        remove: function(id){
            var elIndex = $scope.checkboxData.indexOf(id.toString());
            if(elIndex >= 0) {
                $scope.checkboxData.splice(elIndex, 1);
            }
        },

        action: function(id, event){
            (event.target.checked)
            ? $scope.checkbox.add(id)
            : $scope.checkbox.remove(id);
        },

        massAction: function(){
            $scope.checkbox.updateChildren();
            (!$scope.massCheckbox) && $scope.checkbox.clearSelection();
        },

        clearSelection: function(){
            var checkboxGrid = document.querySelector('.mdl-checkbox-grid');
            checkboxGrid.MaterialCheckbox.uncheck();
            $scope.checkboxData = [];
        },

        updateChildren: function(){
            var checkboxes = document.querySelectorAll('.mdl-data-table--body .mdl-checkbox');

            for(var index in checkboxes){
                if(checkboxes.hasOwnProperty(index)){
                    if($scope.massCheckbox){
                        checkboxes[index].MaterialCheckbox.check();
                        $scope.checkbox.add(checkboxes[index].MaterialCheckbox.inputElement_.value);
                    }else{
                        checkboxes[index].MaterialCheckbox.uncheck();
                    }
                }
            }

        }
    };

    $scope.navigation = {
        prev : function(){
            if($scope.query.page > 1) {
                $scope.query.page--;
                $scope.getItems();
            }
        },
        next : function(){
            if($scope.query.page < $scope.data.last_page) {
                $scope.query.page++;
                $scope.getItems();
            }
        },
        page: function(id){
            if(id > 0 && $scope.query.page <= $scope.data.last_page && id!= $scope.data.current_page) {
                $scope.query.page = id;
                $scope.getItems();
            }
        }
    };

    $scope.getNumber = function(num) {
        return new Array(num);
    }

}]).controller('GridPopController', ['$scope', '$http', 'sharedMessageService','$sce', function($scope, $http, sharedMessageService, $sce){
    $scope.isVisible = false;
    $scope.htmlContent = '';

    $scope.clickOuter = function($event){
        $event.stopPropagation();
        $scope.isVisible = false;
    };

    $scope.clickInner = function($event){
        $event.stopPropagation();
        $event.preventDefault();
    };

    $scope.onClose = function(){
        $scope.isVisible = false;
    };

    sharedMessageService.onDataUpdate('onShow', $scope, function(message, data){
        $scope.isVisible = true;
        $scope.htmlContent =  $sce.trustAsHtml(data);
        setTimeout(componentHandler.upgradeDom, 400);
    });

    sharedMessageService.onDataUpdate('onClose', $scope, function(message, data){
        $scope.isVisible = false;
        $scope.htmlContent =  $sce.trustAsHtml('');
        setTimeout(componentHandler.upgradeDom, 400);
    });

}]).controller('GridFormController', ['$scope', '$http', 'sharedMessageService', function($scope, $http, sharedMessageService){

    $scope.formData = {};
    $scope.formDataErrors = {};

    $scope.dataSubmit = function(){
        $scope.formDataErrors = {};
        $http.post($scope.formUrl, $scope.formData).success(function(data) {
            $scope.formData = {};
            sharedMessageService.emitDataUpdate('onClose');

        }).error(function(data){
            $scope.formDataErrors = data;
        });
    };

}]).controller('OverlayController', ['$scope', '$http', 'sharedMessageService', function($scope, $http, sharedMessageService){

    $scope.isVisible = false;

    sharedMessageService.onDataUpdate('onShowOverlay', $scope, function(message, data){
        $scope.isVisible = true;
    });

    sharedMessageService.onDataUpdate('onCloseOverlay', $scope, function(message, data){
        $scope.isVisible = false;
    });

}]);