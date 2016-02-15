atypicalApp.controller('OverlayController', ['$scope', '$http', 'sharedMessageService',
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

    }]).controller('NotificationController', ['$scope', '$http', '$interval', 'sharedMessageService',
    function ($scope, $http, $interval, sharedMessageService) {

        var stop;
        $scope.messages = [];

        $scope.removeMessage = function(hash){
            console.log(hash)
            for(var m in $scope.messages){
                if($scope.messages.hasOwnProperty(m) && $scope.messages[m].hash == hash){
                    $scope.messages.splice (m, 1);
                }
            }
        };

        $scope.addMessages = function(data){
            var date=new Date();

            for(var i=0; i<data.length; i++){
                $scope.messages.push({
                    type:data[i].type,
                    text:data[i].text,
                    hash:date.getTime()+Math.random()
                })
            }
        };

        sharedMessageService.onDataUpdate('onNotification', $scope, function (message, data) {

            $scope.stopInterval();

            $scope.addMessages(data);

            stop = $interval(function(){
                if($scope.messages.length){
                    $scope.messages.splice (0, 1);
                }else{
                    $scope.stopInterval();
                }
            },2000);
        });

        $scope.stopInterval = function() {
            if (angular.isDefined(stop)) {
                $interval.cancel(stop);
                stop = undefined;
            }
        };

        $scope.$on('$destroy', function() {
           $scope.stopInterval();
        });

    }]);