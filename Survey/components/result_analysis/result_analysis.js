angular.module("thinkLibrary")
    .controller("result_analysisCtrl", function($scope, loginService, sessionService, $http, $rootScope, $sce, $filter) {

        $scope.member = {roles: []};
        $scope.selected_items =  [];

        // 아이템 셋팅
        for( var i = 1; i <= 34 ; i++){
            $scope.selected_items.push({id: i});
        }

        $scope.selected_question = [];
        $rootScope.menubarShow = true;
        $scope.table_width = 2000;
        // 메뉴 기본


        $scope.selectedBtn = 'QList';

        // 설문지번호 -> 문제 쿼리 , 리스트 출력

        var user = JSON.parse(sessionService.get('user'));

        var data_sid = user.current_questionnaire;

        console.log(data_sid);
        $http.post("components/result/php/selectResult.php", data_sid)
            .success(function (data, status, headers, config) {
                console.log(data);
                $scope.surveyinfo    = data;
                $scope.question_data = data.submit_data;

                // label 추가
                for(var i = 0 ; i < $scope.question_data.length ; i++){
                    // example이 셋팅 되어있는 경우만
                    if($scope.question_data[i].type == 'multiple' || $scope.question_data[i].type == 'dropdown'){
                        for(var j = 0 ; j < $scope.question_data[i].example.length ; j++){
                            var temp = $scope.question_data[i].example[j].content;
                            $scope.question_data[i].example[j].label = temp;

                            temp = $scope.question_data[i].example[j].exam_index + $scope.question_data[i].index;
                            $scope.question_data[i].example[j].id = temp;
                        }
                    }
                }

            });

        // 설문지의 결과 값을 가져오기
        console.log(data_sid);
        $http.post("components/result_analysis/php/getData.php", data_sid)
            .success(function (data, status, headers, config) {
                console.log(data);
                $scope.result_data = data;
            });

        // default view : 설문지 기본 정보 (이름, 설문지 번호, 몇문제) &
        // clicked btn : 프로필 btn 클릭시 리스트 출력 (직업, 나이, 성별, 지역, 소득 ... default setting)

        $scope.profile_data = [
            {
                con  : "性別",
                name : "gender",
                info : [
                    {"id": 1, label:'男', name : '男', code : 'm', "assignable": true},
                    {"id": 2, label:'女', name : '女', code: 'w', "assignable": true}
                ]
            },
            {
                con  : "地域",
                name : "area",
                info : [
                    {"id": 3, name:"東京", label:"東京", code:20} ,{"id": 4, name:"札幌", label:"札幌", code:51},{"id": 5, label:"奈良", name:"奈良", code:53},{"id": 3, label:"島根", name:"島根", code:32},
                    {"id": 6, name:"大阪", label:"大阪", code:62},{"id": 7, name:"横浜", label:"横浜", code:42},{"id": 8, label:"広島", name:"広島", code:52},{"id": 3, label:"岩手", name:"岩手", code:44},
                    {"id": 9, name:"福岡", label:"福岡", code:31},{"id": 10, name:"京都", label:"京都", code:33},{"id": 11, label:"鳥取", name:"鳥取", code:43},{"id": 3, label:"静岡", name:"静岡", code:41},
                    {"id": 12, name:"熊本", label:"熊本", code:63},{"id": 13, name:"長崎", label:"長崎", code:61},{"id": 14, label:"千葉", name:"千葉", code:54},{"id": 3, label:"兵庫", name:"兵庫", code:65},
                    {"id": 15, name:"沖縄", label:"沖縄", code:64}
                ]
            },
            {
                con  : "年代",
                name : "age",
                info : [
                    {"id": 17, label:'10代', name : '10代', code:10},
                    {"id": 18, label:'20代', name : '20代', code:20},
                    {"id": 19, label:'30代', name : '30代', code:30},
                    {"id": 20, label:'40代', name : '40代', code:40},
                    {"id": 21, label:'50代', name : '50代', code:50},
                    {"id": 22, label:'60代', name : '60代', code:60},
                    {"id": 23, label:'70代', name : '70代', code:70},
                    {"id": 34, label:'80代', name : '80代', code:80},
                ]
            }
        ];

        //
        $scope.question_box = [];
        $scope.profile_box = [
            {
                "profiles":[]
            }
        ];

        //profile box 한칸에 두개 들어가게함
        $scope.$watch('profile_box', function(profile_box) {

            // question_box를 순회해서 일반 문제가 있을 경우
            // 배열로 감싸기.
            for(var i = 0 ; i < profile_box.length ; i++){

                var item = profile_box[i];


                if(item.hasOwnProperty('name')){
                    // 원래 배열 지우기

                    profile_box.splice(i,1);
                    // 감싸기
                    profile_box.push(
                        {
                            "profiles":[angular.copy(item)]
                        }
                    )

                    break;
                }

            }

            // 배열에 필요 없는 빈 공백 지우기
            for(var i = 0 ; i < profile_box.length ; i++){

                var item = profile_box[i];

                // 아무것도 셋팅 되어 있지 않는 배열을 지움
                // question_box의 lwmf147
                // ength가 1 이하일때는 변경
                if(profile_box.length > 1){
                    if(item.hasOwnProperty('profiles')) {
                        if(item.profiles.length == 0)
                            profile_box.splice(i,1);
                    }
                }
            }

            // 색깔 설정
            // info를 모두 열어보고 순서대로 데이터의 순위가 높은 것 부터 색을 정함
            for(var i = 0 ; i < profile_box ; i++)

            $scope.modelAsJson = angular.toJson(profile_box, true);

        }, true);


        $scope.multiple_all_count = function(item, profile_first, profile_second, info_first, info_second){
            var question_formet = {};
            var all_formet = {};

            // 성별일 경우
            if(profile_first.name == "gender"){
                if(profile_second.name == "area"){
                    question_formet = {gender : info_first.code, area : info_second.code};
                }
                else if(profile_second.name == "age"){
                    question_formet = {gender : info_first.code, agegroup : info_second.code};
                }
            }

            else if(profile_first.name == "area"){
                if(profile_second.name == "gender") {
                    question_formet = {  area : info_first.code , gender : info_second.code};
                }
                else if(profile_second.name == "age"){
                    question_formet = {area : info_first.code, agegroup : info_second.code};
                }
            }

            else if(profile_first.name == "age"){
                if(profile_second.name == "gender"){
                    question_formet = {   agegroup : info_first.code, gender : info_second.code};
                }
                else if(profile_second.name == "area"){
                    question_formet = {   agegroup : info_first.code, area : info_second.code};
                }

            }



            var data        = $filter('filter')($scope.result_data, question_formet);

            //console.log(data);

            // 데이터의 크기 반환
            var count = 0;
            var current_panel = "";

            // 응답자 세기
            for(var i = 0 ; i < data.length ; i ++){
                // 응답자 id가 다를 경우
                if(current_panel != data[i].panelid ){
                    count++;
                    //console.log(current_panel);
                    current_panel = data[i].panelid;
                }
            }


            //console.log(count);

            // 데이터의 크기 반환
            return  count;

        }

        $scope.all_response = function(){

            var count = 0;
            var current_panel = "";

            // 응답자 세기
            for(var i = 0 ; i < $scope.result_data.length ; i ++){
                // 응답자 id가 다를 경우
                if(current_panel != $scope.result_data[i].panelid ){
                    count++;
                   // console.log(current_panel);
                    current_panel = $scope.result_data[i].panelid;
                }
            }


            //console.log(count);

            // 데이터의 크기 반환
            return  count;
        }

        // 전체 응답자 수
        $scope.all_count = function(item, profile, info){

            var question_formet = {};
            var all_formet = {};

            // 성별일 경우
            if(profile.name == "gender"){
                question_formet = {gender : info.code};
            }

            if(profile.name == "area"){
                question_formet = {area : info.code};
            }
            if(profile.name == "age"){
                question_formet = {agegroup : info.code};
            }

            // 걸러진 데이터
            var data        = $filter('filter')($scope.result_data, question_formet);


            var count = 0;
            var current_panel = "";

            // 응답자 세기
            for(var i = 0 ; i < data.length ; i ++){
                // 응답자 id가 다를 경우
                if(current_panel != data[i].panelid ){
                    count++;
                    //console.log(current_panel);
                    current_panel = data[i].panelid;
                }
            }


            //console.log(count);

            // 데이터의 크기 반환
            return  count;

        }

        $scope.multiple_calc = function(question, exam, profile_first, profile_second, info_first, info_second){
            //console.log(question, exam, profile_first, profile_second, info_first, info_second);
            var question_formet = {};
            var all_formet = {};

            // 성별일 경우
            if(profile_first.name == "gender"){
                if(profile_second.name == "area"){
                    question_formet = {qid : question.qid , gender : info_first.code, area : info_second.code , chk_ob : exam.exam_index};
                    all_formet      = {qid : question.qid};
                }
                else if(profile_second.name == "age"){
                    question_formet = {qid : question.qid ,  gender : info_first.code, agegroup : info_second.code, chk_ob : exam.exam_index};
                    all_formet      = {qid : question.qid};
                }
            }

            else if(profile_first.name == "area"){
                if(profile_second.name == "gender") {
                    question_formet = {qid : question.qid ,  area : info_first.code , gender : info_second.code, chk_ob : exam.exam_index};
                    all_formet = {qid: question.qid};
                }
                else if(profile_second.name == "age"){
                    question_formet = {qid : question.qid ,  area : info_first.code, agegroup : info_second.code, chk_ob : exam.exam_index};
                    all_formet      = {qid : question.qid};
                }
            }
            else if(profile_first.name == "age"){

                if(profile_second.name == "gender"){
                    question_formet = {qid : question.qid ,   agegroup : info_first.code, gender : info_second.code, chk_ob : exam.exam_index};
                    all_formet      = {qid : question.qid};
                }
                else if(profile_second.name == "area"){
                    question_formet = {qid : question.qid ,   agegroup : info_first.code, area : info_second.code,  chk_ob : exam.exam_index};
                    all_formet      = {qid : question.qid};
                }

            }

            //console.log(question_formet);

            // 걸러진 데이터
            var data        = $filter('filter')($scope.result_data, question_formet);
            var all_data    = $filter('filter')($scope.result_data, all_formet);

            //console.log(data);

            // 데이터의 크기 반환
            //return window.Math.round (100 * data.length / all_data.length);
            return data.length;
        }

        // 통계값 반환
        $scope.calc = function(question, exam , profiles, info){

            // 두개 의 값
            //console.log(exam.content);
            //console.log(info.label);

            var question_formet = {};
            var all_formet = {};

            // 성별일 경우
            if(profiles.name == "gender"){
                question_formet = {qid : question.qid , gender : info.code, chk_ob : exam.exam_index};
                all_formet      = {qid : question.qid};
            }

            if(profiles.name == "area"){
                question_formet = {qid : question.qid , area : info.code, chk_ob : exam.exam_index};
                all_formet      = {qid : question.qid};
            }
            if(profiles.name == "age"){
                question_formet = {qid : question.qid , agegroup : info.code, chk_ob : exam.exam_index};
                all_formet      = {qid : question.qid};
            }

            //console.log(question_formet);
            // 걸러진 데이터
            var data        = $filter('filter')($scope.result_data, question_formet);

            if(profiles.name == "area") {
                console.log(data);
            }

            //console.log(data);

            // 데이터의 크기 반환
            return data.length;
        };

        // 문제 필터
        $scope.questionFilter = function(item){
            if ($scope.selected_question.length > 0) {

                // selected_items에 선택된 객체가 있는가 확인하고
                // 없을 경우 아무것도 리턴하지 않음.

                var plag = false;

                for(var i = 0 ; i < $scope.selected_question.length ; i++){
                    if($scope.selected_question[i].id == item.id){
                        var plag = true;
                    }
                }
                if(!plag){
                    return;
                }
            }
            return item;
        }

        // 옵션설정에 따른 필터 구현.
        $scope.optionFilter = function(item) {

            if ($scope.selected_items.length > 0) {

                // selected_items에 선택된 객체가 있는가 확인하고
                // 없을 경우 아무것도 리턴하지 않음.

                var plag = false;

                for(var i = 0 ; i < $scope.selected_items.length ; i++){
                    if($scope.selected_items[i].id == item.id){
                        var plag = true;
                    }
                }

                if(!plag){
                    return;
                }
            }

            return item;
        }

        //
        $scope.$watch('question_box', function(question_box) {
            // 기준 필터가 될곳

            // 퀘스천 박스에 있는 내용을 기준으로 푸쉬
            for(var i = 0 ; i < $scope.question_box.length ; i++){
                var question_formet = { qid : question_box[i].qid + "" }

                for(var j = 0 ; j < $scope.question_box[i].example.length ; j++){

                    // 전체 응답수 푸쉬
                    // filter 내용 chkob, qid
                    var question_formet = { qid : question_box[i].qid, chk_ob : question_box[i].example[j].exam_index };


                    // 배열로 만들고 내용을 보고 돌리기
                    $scope.question_box[i].example[j].result = $filter('filter')($scope.result_data, question_formet);


                }
                console.log(question_box);

            };



            $scope.chartdata = [
                {
                    name:"all",
                    data:[

                    ]
                }
            ]

        }, true);


    })