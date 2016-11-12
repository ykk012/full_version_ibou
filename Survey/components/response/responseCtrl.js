
angular.module("thinkLibrary")
    .controller("responseCtrl", function($scope, loginService,sessionService, $http, $rootScope, $timeout, $location, $routeParams) {
        $rootScope.menubarShow = false;
        // get방식

        // get으로 넘어온 결과과
        var sdata                       = {};
        sdata.sid                       = $routeParams.param;
        sdata.s_num                     =sdata.sid;
        $scope.questionnaire            = {};
        console.log("설문번호");
        console.log(sdata);

        $scope.area = [
            {name:"管理", code:20},{name:"経営", code:51},{name:"金融", code:53},{name:"教育", code:32},
            {name:"研究", code:62},{name:"法律", code:42},{name:"医療", code:52},{name:"福祉", code:44},
            {name:"芸術", code:31},{name:"運転", code:33},{name:"営業", code:43},{name:"警備", code:41},
            {name:"美容", code:63},{name:"スポーツ", code:61},{name:"サービス", code:54},{name:"機械・建設", code:65},
            {name:"農業・漁業", code:64},{name:"電子・電気", code:65},{name:"情報通信", code:66},{name:"その他", code:67}

        ];

        $http.post("php/getQuestionnaire.php", sdata)
            .success(function (data, status, headers, config) {

                console.log(data);

                $scope.questionnaire            = data;
                $scope.questionnaire.preview    = [];
                $http.post("components/makeQuestionnaire/php/selectQuestionnaire.php", sdata)
                    .success(function (data, status, headers, config) {
                        console.log("안에들어옴");
                        for(var i = 0 ; i < data.length ; i++){
                            $scope.questionnaire.preview.push(data[i]);
                        }
                        console.log($scope.questionnaire.preview);
                    });
            });

        // $scope.select   = function(selected){
        //     // 로그인을 선택 했을 경우
        //     if(selected == "joined"){
        //
        //         var user = loginService.isloggined();
        //         // 로그인 여부 확인
        //         if(user) {
        //             user.surveyid = $routeParams.param;
        //             // user정보로 panel 등록
        //             $http.post("php/insertUserPanel.php", user)
        //                 .success(function (data, status, headers, config) {
        //                     $rootScope.panel = data;
        //                     $location.path("response/" + $routeParams.param);
        //                 });
        //         }else{
        //            $location.path("responseLogin/" + $routeParams.param);
        //         }
        //     }
        //     // 비회원 을 선택했을 경우
        //     else if(selected == "notJoined"){
        //         $location.path("panelInfo/" + $routeParams.param);
        //     }
        // }

        $scope.sendData = function(){

            // 데이터 담을 공간
            var temp_data           = {
                result : []
            };

            for(var i = 0 ; i < $scope.questionnaire.preview.length ; i++){
                // 모든 문제의 답을 가져옴
                // 메트릭스는 따로 가져옴
                if($scope.questionnaire.preview[i].type != "matrix"){
                    var temp        = {};
                    temp.num        = angular.copy($scope.questionnaire.preview[i].num);
                    temp.answer     = angular.copy($scope.questionnaire.preview[i].answer);
                    temp.type       = angular.copy($scope.questionnaire.preview[i].type);
                    temp.qid       = angular.copy($scope.questionnaire.preview[i].qid);
                    temp_data.result.push(temp);
                }
                else if($scope.questionnaire.preview[i].type == "matrix"){
                    var temp        = {};
                    temp.num        = angular.copy($scope.questionnaire.preview[i].num);
                    temp.type       = angular.copy($scope.questionnaire.preview[i].type);
                    temp.qid        = angular.copy($scope.questionnaire.preview[i].qid);
                    temp.row        = [];

                    for(var j= 0 ; j < $scope.questionnaire.preview[i].row.length ; j++){

                        var temp_sub     = {};
                        temp_sub.num     = angular.copy($scope.questionnaire.preview[i].row[j].exam_index);
                        temp_sub.answer  = angular.copy($scope.questionnaire.preview[i].row[j].answer);

                        temp.row.push(temp_sub);
                    }
                    temp_data.result.push(temp);
                }
            }

            // temp_data 설문 문학 제목에 맞게 설정
            temp_data.panelid   = $rootScope.panel.panelid;
            console.log($rootScope.panel);
            temp_data.s_num  = $routeParams.param;
            console.log("temp_data : ");
            console.log(temp_data);


            // data 입력
            $http.post("php/insertResult.php", temp_data)
                .success(function (data, status, headers, config) {
                    console.log(data);
                    $location.path('/Thank');
                });
        }

        // 설문지 번호와 login의 경우
        $scope.panelJoin = function(panel){
            panel.s_num = $routeParams.param;
            console.log(panel);
            // 연령대
            panel.agegroup = parseInt(panel.age / 10) * 10;
            if(panel.agegroup == 0){
                panel.agegroup = 10;
            }
            if(panel.agegroup > 80){
                panel.agegroup = 80;
            }

            console.log(panel);

            $http.post("php/insertPanel.php", panel)
                .success(function (data, status, headers, config) {
                    $rootScope.panel = data;

                    $location.path("response/" + $routeParams.param);
                });
        }

    })
