/**
 * Created by Leemw on 2015-05-18.
 */
angular.module("thinkLibrary")
    .controller("createQuestionnaireCtrl", function($scope,sessionService, $http, $location, $rootScope) {
        $rootScope.menubarShow = true;
        // 유저아이디로 된 설문지들을 불러오기

        $scope.questionnaire = {};
        $scope.questionnaire.s_subject = "タイトル";
        $scope.questionnaire.s_date = "2016-09-29";
        $scope.questionnaire.s_explain = "説明入力";



        $scope.positions = [];

        $scope.addMarker = function(event) {
            var ll = event.latLng;
            $scope.positions = [];

            $scope.openLocationA  = ll.lat();
            $scope.openLocationF  = ll.lng();

            console.log(ll.lat());
            console.log(ll.lng());

            $scope.positions.push({lat:ll.lat(), lng: ll.lng()});

        }
        $scope.deleteMarkers = function() {
            $scope.positions = [];
        };

        console.log("servey만드는거");
        console.log("유저넘버");
        console.log($scope.user);
        console.log("보드넘버");
        console.log($scope.board);
        
        $scope.createNewQuestionnaire = function(questionnaire){


            //JSON.parse 문자열을 객체로 변환시킴.

            console.log("설문지 설정완료__");

            var user = JSON.parse(sessionService.get('user'));

            console.log(questionnaire);
            // 세션에 추가
             user.current_questionnaire                = questionnaire;
             $rootScope.current_questionnaire          = questionnaire;

            console.log(user);

            user.current_questionnaire                = questionnaire;
            $rootScope.current_questionnaire          = questionnaire;
            console.log("create question");
            console.log(user);
            // DB에 전송
            $http.post("components/makeQuestionnaire/php/insertSurvey.php",user)


                .success(function(data, status, headers, config){
                    console.log("DB전송결과__");
                    console.log("오토인크리먼트값");
                    console.log(data);
                    $scope.data=data;
                    console.log($scope.data);

                    user.current_questionnaire.s_num= $scope.data;
                    console.log(user.current_questionnaire.s_num);
                    user.current_questionnaire.state = "new";
                    sessionService.set('data', user);


                    

                    $location.path("/makingSpace");
                });
        }

        // console.log(questionnaire);
        //
        // var user = JSON.parse(sessionService.get('user'));
        // console.log(user);
        //
        // // 상태가 share일 경우
        // if(questionnaire.state == "share"){
        //
        //     $scope.error("シェアーしているアンケートです。");
        //     return;
        // }
        //
        // $scope.questionnaire=questionnaire;
        //
        // var current_questionnaire = {};
        //
        // current_questionnaire.name                  = questionnaire.s_subject;
        // current_questionnaire.start_date            = questionnaire.s_date;
        // current_questionnaire.sid                   = questionnaire.s_num;
        // current_questionnaire.state                 = "making";
        //
        // user.current_questionnaire                = current_questionnaire;
        // $rootScope.current_questionnaire          = current_questionnaire;
        //
        //
        // console.log("makingSpaceCtl");
        // console.log(user);
        // sessionService.set('user', user);
        /* 설문지 설정 내용
         진행상태
         공개여부
         설문제목
         테마
         시작일
         종료일
         쿠폰
         목표 응답자수
         썸네일 이미지
         */

    });
