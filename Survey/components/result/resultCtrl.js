angular.module("thinkLibrary")
    .value('googleChartApiConfig', {
        version: '1',
        optionalSettings: {
            packages: ['corechart', 'gauge'],
            language: 'fr'
        }
    })
    .controller("resultCtrl", function($scope, loginService,sessionService, $http, $filter, $rootScope, $timeout, $location, $routeParams) {
        $rootScope.menubarShow = true;

        // 현재 설문정보를 가지고
        // php 쿼리해오기 응답자수/ 응답 날짜 / 설문정보
        // 남녀비율 / 지역 / 나이대 / 응답률/ 날짜 진행도
        // 문제별 분석
        var data = {};
        console.log($rootScope.current_questionnaire);
        data.s_num = $rootScope.current_questionnaire.s_num;

        // 막대 그래프
        $scope.date_labels=[];
        $scope.date_series=['日付別回答率'];
        $scope.date_data  =[];

        $scope.gender_data =[];
        $scope.gender_labels=[];

        $scope.area_data =[];
        $scope.area_labels=[];

        $scope.age_data =[];
        $scope.age_labels=[];

        $scope.preview = [];
        $scope.current_question = 0;

        $scope.graphdata = {};

        $scope.q_selected = {};

        console.log(data);
        $http.post("components/result_analysis/php/getData.php", data)
            .success(function (dataa, status, headers, config) {
                $scope.reportdata = dataa;
                console.log(dataa);

                $http.post("components/result/php/selectResult.php", data)
                    .success(function (datab, status, headers, config) {
                        $scope.surveyreport = datab.submit_data;
                        $scope.counting();
                        $scope.q_selected = $scope.surveyreport[0];
                        $scope.setQuestion($scope.q_selected);
                        console.log($scope.q_selected);
                    });
            });
        console.log(data);
        
        //  곡선그래프그리기
        $http.post("components/result/php/selectResult.php", data)
            .success(function (data, status, headers, config) {

                $scope.resultData   = data;
                $scope.survey       = [];
                $scope.survey.push(data.surveyInfo);
                console.log(data);

                for(var i = 0 ; i < data.submit_data.length ; i++){
                    $scope.preview.push(data.submit_data[i]);
                }

                // 그래프 시간
                for(var i = 0; i < data.platformLineArray.length ; i++){
                    $scope.date_labels.push(data.platformLineArray[i].date); // 응답일
                    // 응답자 수
                }
                var temp=[];
                for(var j = 0; j < data.platformLineArray.length; j++){

                    temp.push(data.platformLineArray[j].panelNum); // 응답자 수

                }
                $scope.date_data.push(temp);

                // gender
                var gender_temp = [];
                for(var i = 0; i < data.genderArray.length ; i++){
                    $scope.gender_labels.push(data.genderArray[i].title); // 응답일
                    gender_temp.push(data.genderArray[i].value); // 응답자 수
                }

                $timeout(function () {
                    $scope.gender_data = gender_temp;
                }, 500);

                // area
                var area_temp = [];
                for(var i = 0; i < data.areaArray.length ; i++){

                    if(data.areaArray[i].title =="null"){
                        data.areaArray[i].title = "기타";
                    }

                    $scope.area_labels.push(data.areaArray[i].title); // 응답일
                    area_temp.push(data.areaArray[i].value); // 응답자 수
                }
                $timeout(function () {
                    $scope.area_data = area_temp;
                }, 500);

                // age
                var age_temp = [];
                for(var i = 0; i < data.ageGroupArray.length ; i++){
                    $scope.age_labels.push(data.ageGroupArray[i].title); // 응답일
                    age_temp.push(data.ageGroupArray[i].value); // 응답자 수
                }
                $timeout(function () {
                    $scope.age_data = age_temp;
                }, 500);
            });



        // 통계값 반환
        console.log($scope.surveyreport);
        $scope.counting = function(){
            for(var i = 0; i < $scope.surveyreport.length; i++) {
                for(var j = 0; j < $scope.surveyreport[i].example.length; j++) {
                    var exam_format = {qid: $scope.surveyreport[i].qid, chk_ob: $scope.surveyreport[i].example[j].exam_index};
                    var data        = $filter('filter')($scope.reportdata, exam_format);
                    $scope.surveyreport[i].example[j].checked = data.length;
                }
            }
        };

        /* 문제 선택하면 값 넘어오는 ^^ */
        $scope.setQuestion = function(question) {
            for(var s = 0; s < chart1.data.rows.length; s++) {
                chart1.data.rows.splice(0,1);
            }

            var row = [];
            for(var i = 0; i < question.example.length; i++) {
                row.push({
                    c: [{v: question.example[i].content}, {v: question.example[i].checked}]
                });
            }

            chart1.data.rows = row;
            $scope.chart = chart1;
        };

        var chart1 = {};
        chart1.type = "BarChart";
        chart1.displayed = false;
        chart1.data = {
            "cols": [{
                id: "checked-id",
                label: "checkedNum",
                type: "string"
            },{
                id: "checkedNum",
                label: "回答数",
                type: "number"
            }],
            "rows": []
        };

        chart1.options = {
            "title": "問題内容",
            "isStacked": "true",
            "fill": 20,
            "displayExactValues": true,
            "vAxis": {
                "title": "回答",
                "gridlines": {
                    "count": 10
                }
            },
            "hAxis": {
                "title": "回答数"
            }
        };

        var formatCollection = [{
            name: "color",
            format: [{
                columnNum: 4,
                formats: [{
                    from: 0,
                    to: 3,
                    color: "white",
                    bgcolor: "red"
                }, {
                    from: 3,
                    to: 5,
                    color: "white",
                    fromBgColor: "red",
                    toBgColor: "blue"
                }, {
                    from: 6,
                    to: null,
                    color: "black",
                    bgcolor: "#33ff33"
                }]
            }]
        }, {
            name: "arrow",
            checked: false,
            format: [{
                columnNum: 1,
                base: 19
            }]
        }, {
            name: "date",
            format: [{
                columnNum: 5,
                formatType: 'long'
            }]
        }, {
            name: "number",
            format: [{
                columnNum: 4,
                prefix: '$'
            }]
        }, {
            name: "bar",
            format: [{
                columnNum: 1,
                width: 100
            }]
        }];

        chart1.formatters = {};

        $scope.chart = chart1;
        $scope.cssStyle = "height:600px; width:100%;";

        /*$scope.chartSelectionChange = function() {
         if (($scope.chart.type === 'Table' && $scope.chart.data.cols.length === 6 && $scope.chart.options.tooltip.isHtml === true) ||
         ($scope.chart.type !== 'Table' && $scope.chart.data.cols.length === 6 && $scope.chart.options.tooltip.isHtml === false)) {
         $scope.chart.data.cols.pop();
         delete $scope.chart.data.rows[0].c[5];
         delete $scope.chart.data.rows[1].c[5];
         delete $scope.chart.data.rows[2].c[5];
         }


         if ($scope.chart.type === 'Table') {

         $scope.chart.options.tooltip.isHtml = false;

         $scope.chart.data.cols.push({
         id: "data-id",
         label: "Date",
         type: "date"
         });
         $scope.chart.data.rows[0].c[5] = {
         v: "Date(2013,01,05)"
         };
         $scope.chart.data.rows[1].c[5] = {
         v: "Date(2013,02,05)"
         };
         $scope.chart.data.rows[2].c[5] = {
         v: "Date(2013,03,05)"
         };
         }
         };*/

        /*$scope.htmlTooltip = function() {

         if ($scope.chart.options.tooltip.isHtml) {
         $scope.chart.data.cols.push({
         id: "",
         "role": "tooltip",
         "type": "string",
         "p": {
         "role": "tooltip",
         'html': true
         }
         });
         $scope.chart.data.rows[0].c[5] = {
         v: " <b>Shipping " + $scope.chart.data.rows[0].c[4].v + "</b><br /><img src=\"http://icons.iconarchive.com/icons/antrepo/container-4-cargo-vans/512/Google-Shipping-Box-icon.png\" style=\"height:85px\" />"
         };
         $scope.chart.data.rows[1].c[5] = {
         v: " <b>Shipping " + $scope.chart.data.rows[1].c[4].v + "</b><br /><img src=\"http://icons.iconarchive.com/icons/antrepo/container-4-cargo-vans/512/Google-Shipping-Box-icon.png\" style=\"height:85px\" />"
         };
         $scope.chart.data.rows[2].c[5] = {
         v: " <b>Shipping " + $scope.chart.data.rows[2].c[4].v + "</b><br /><img src=\"http://icons.iconarchive.com/icons/antrepo/container-4-cargo-vans/512/Google-Shipping-Box-icon.png\" style=\"height:85px\" />"
         };
         }
         else {
         $scope.chart.data.cols.pop();
         delete $scope.chart.data.rows[0].c[5];
         delete $scope.chart.data.rows[1].c[5];
         delete $scope.chart.data.rows[2].c[5];
         }
         };*/
        /*$scope.hideServer = false;
         $scope.selectionChange = function() {
         if ($scope.hideServer) {
         $scope.chart.view = {
         columns: [0, 1, 2, 4]
         };
         }
         else {
         $scope.chart.view = {};
         }
         };*//*$scope.formatCollection = formatCollection;
         $scope.toggleFormat = function(format) {
         $scope.chart.formatters[format.name] = format.format;
         };*/

        /*$scope.chartReady = function() {
            fixGoogleChartsBarsBootstrap();
        };
        function fixGoogleChartsBarsBootstrap() {
            $(".google-visualization-table-table img[width]").each(function(index, img) {
                $(img).css("width", $(img).attr("width")).css("height", $(img).attr("height"));
            });
        }*/
    })
