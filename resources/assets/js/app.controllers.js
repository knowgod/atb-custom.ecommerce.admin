atypicalApp.controller('GridCtrl', ['$scope', '$http', 'sharedMessageService', function($scope, $http, sharedMessageService){

    $scope.actions = {
        'openCreate': '',
        'openUpdate':'',
        'create':'',
        'update':'',
        'delete':'',
        'get':''
    };

    $scope.query = {
        page: 1,
        sort: 'id',
        sortOrder: 'DESC'
    };

    $scope.massCheckbox = false;


    $scope.filters = [];

    $scope.openUpdate = function(url){
        var req = {
            method: 'GET',
            url: url,
            headers: {
                'Accept': 'text/html, */*'
            },
            params: $scope.query
        };
        $http(req).then(function(response){
            sharedMessageService.emitDataUpdate('onShow', response.data);
        }, function(){

        });
    };

    $scope.openCreate = function(){
        var req = {
            method: 'GET',
            url: '/user/create',
            headers: {
                'Accept': 'text/html, */*'
            },
            params: $scope.query
        };
        $http(req).then(function(response){
            sharedMessageService.emitDataUpdate('onShow', response.data);
        }, function(){

        });
    };

    $scope.getItems = function(){
        var req = {
            method: 'GET',
            url: '/user/list',
            headers: {
                //'Accept': 'text/html, */*'
            },
            params: $scope.query
        };
        $http(req).then(function(response){
            console.log(response)
            $scope.data = response.data.collection;
        }, function(){

        });

    };

    $scope.massCheckboxClick = function(el){
        console.log($scope.massCheckbox)
    };

    $scope.show = function(){
        sharedMessageService.emitDataUpdate('onShow', $scope.data);
    };

    $scope.navigation = {
        prev : function(){
            $scope.query.page--;
            $scope.getItems();
        },
        next : function(){
            $scope.query.page++;
            $scope.getItems();
        },
        page: function(id){
            $scope.query.page = id;
            $scope.getItems();
        }
    };

    $scope.getNumber = function(num) {
        return new Array(num);
    }

}]).controller('GridPopCtrl', ['$scope', '$http', 'sharedMessageService','$sce', function($scope, $http, sharedMessageService, $sce){
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

    sharedMessageService.onDataUpdate('onShow', $scope, function(message, data){
        $scope.isVisible = true;
        $scope.htmlContent =  $sce.trustAsHtml(data);
        setTimeout(componentHandler.upgradeDom, 400);
    });
}]);