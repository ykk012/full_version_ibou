/**
 * Created by Leemw on 2015-06-09.
 */


angular.module("thinkLibrary")
    .controller("shareCtrl", function($scope, sessionService, $http, $rootScope) {
        $rootScope.menubarShow = true;

        $scope.selected = "";

        $scope.select   = function(selected){
            console.log(selected);
            $scope.selected = selected;
        }

        $scope.current_title        = 'Test';
        $scope.current_description  = 'Test description';

        console.log($rootScope.current_questionnaire);


        $scope.qrcodeString     = 'https://project-board-css-karchev.c9users.io/Survey/index.html#/panelInfo/' + $rootScope.current_questionnaire.s_num;
        // $scope.qrcodeString     = 'http://tlibrary.net/Think_Library/index.html#/responseHome/22'
        $scope.size             = 250;
        $scope.correctionLevel  = '';
        $scope.typeNumber       = 0;
        $scope.inputMode        = '';
        $scope.image            = true;

        // 보여주기 창
        $scope.textShow         = true;
        $scope.textFirst        = true;

        // 보여지는 창변경
        $scope.textShowClick = function(){
            $scope.textFirst    = false;
            $scope.textShow     = !$scope.textShow;
        }



        // 이메일 보내기
  

        // upload
        


    })
