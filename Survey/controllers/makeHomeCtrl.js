angular.module("thinkLibrary")
    .controller("makeHomeCtrl", function($scope, sessionService, $http, $rootScope, $timeout, $location, $route) {
        $rootScope.menubarShow = true;
        // 페이지 로드 시 정보 가져오기
        $scope.survey = {};
        var user = $scope.user;
        console.log("유저 num");
        console.log(user);

        // DB에 전송
        $scope.survey.m_num=$scope.user;
        
        console.log($scope.survey);

        $http.post("php/selectSurvey.php", $scope.survey)
            .success(function (data, status, headers, config) {
                console.log("설문지 정보");
                console.log(data);

                user.questionnaires = data;
                $timeout(function () {

                    $rootScope.questionnaires = data;
                })
                
                sessionService.set('user', $scope.survey);

            });

        // 현재 설문지 수정
        $scope.goShare = function(questionnaire){

            var user = JSON.parse(sessionService.get('user'));
            // 현재 설정내용을 세션에 추가하고
            // user.current_questionnaire.preview = $scope.models.questionnarie.preview;
            $rootScope.current_questionnaire = questionnaire;


                // surveyid로 삭제

                // share하면 에러메세지 띄우고 불가능하게 만드리기기
                console.log(user);

            console.log($rootScope.current_questionnaire);
                questionnaire.state = "share";
            console.log(questionnaire);

            $http.post("components/makeQuestionnaire/php/UpdateSurvey.php", questionnaire)
                .success(function (data, status, headers, config) {
                    // 삭제 완료 후
                    console.log("공유완료");
                    console.log(data);
                    $route.reload();
                });

                $location.path('/share');

                console.log(user);

        }

        $scope.questionnaire_modify = function(questionnaire){
            
            
            console.log(questionnaire);

            var user = JSON.parse(sessionService.get('user'));
            
            console.log(user);

            if(questionnaire.state == "share"){
                window.alert("SNS共有状態なので修正できません。");
                return;
            }



            $scope.questionnaire=questionnaire;

            var current_questionnaire = {};

            current_questionnaire.s_subject                  = questionnaire.s_subject;
            current_questionnaire.s_date            = questionnaire.s_date;
            current_questionnaire.s_num                = questionnaire.s_num;
            current_questionnaire.s_explain                = questionnaire.s_explain;
            current_questionnaire.state                 = "making";

            user.current_questionnaire                = current_questionnaire;
            $rootScope.current_questionnaire          = current_questionnaire;


            console.log("makingSpaceCtl");
            console.log(user);
            sessionService.set('data', user);


            $location.path("/makingSpace",user);

        }

        $scope.questionnaire_result = function(questionnaire) {
            console.log(questionnaire);
            var user = JSON.parse(sessionService.get('user'));

            var current_questionnaire = {};
            

            user.current_questionnaire                = questionnaire;
            $rootScope.current_questionnaire          = questionnaire;

            console.log(user);
            sessionService.set('user', user);

            $location.path("/result");
        }

        $scope.questionnaire_delete = function(questionnaire){
            // 설문지의 아이디를 가져오기
            var user = JSON.parse(sessionService.get('user'));
            user        = questionnaire.s_num;
            console.log("설문지 삭제");
            console.log(user);

            $http.post("components/makeQuestionnaire/php/deleteSurvey.php", user)
                .success(function (data, status, headers, config) {
                    // 삭제 완료 후
                    console.log("삭제완료");
                    console.log(data);
                    $route.reload();
                });
        }

       

      


    })
