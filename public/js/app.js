var app = angular.module("acrxp",[]);

app.controller("appController", function($scope, appService) {

  $scope.status = 1;

  $scope.response = {};

  $scope.upload = function(file){
    $scope.file = file;
    $scope.$apply();
  }
  $scope.send = function(){
    var fd = new FormData();
    fd.append('file',$scope.file[0]);
    $scope.status = 2;
    appService.sendFile(fd).then(function(res){
      $scope.response = res.data;
      $scope.status = 3;
      $scope.file = null;
    }).catch(function(res){
      $scope.status = 3;
      $scope.response.status.code = res.status;
      $scope.response.status.msg =  res.statusText;
    });
  }
  $scope.msToTime = function(s) {

    function addZ(n) {
      return (n<10? '0':'') + n;
    }

    var ms = s % 1000;
    s = (s - ms) / 1000;
    var secs = s % 60;
    s = (s - secs) / 60;
    var mins = s % 60;
    var hrs = (s - mins) / 60;

    return addZ(hrs) + ':' + addZ(mins) + ':' + addZ(secs);
  }
});

app.factory("appService", function($http){
  return {
    sendFile: function(file){
      return $http.post("api/v1/send-file", file,{
        withCredentials: true,
        headers: {"Content-type":undefined},
        transformRequest: angular.identity
      });
    }
  }
});
