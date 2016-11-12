

angular.module("thinkLibrary")


    .directive("responseTemplate", function () {
        return {
            link: function(scope, element, attrs){
                console.log(scope);
                //플렛폼 주소
                scope.getTemplateUrl = function (){

                    return 'components/response/components/'+ scope[attrs["responseTemplate"]].template;
                }
            },
            template: '<div ng-include="getTemplateUrl()"></div>'
        }
    })
   
    .directive("componentTemplate", function (FileUploader) {
        return {
            //data 가져오기
            // 지정된 template에 따라
            link: function(scope, element, attrs){
                console.log(scope);
                scope.copyQuestion      = scope[attrs["copyFn"]];
                scope.setQuestionIndex  = scope[attrs["setIndex"]];
                scope.removeQuestion    = scope[attrs["rmFn"]];
                /*
                 * drop 된 컴포넌트에 해당하는 템플릿 적용
                 */
                scope.getContentUrl = function (){
                    scope.setQuestionIndex();
                    return 'components/makeQuestionnaire/components/'+ scope[attrs["componentTemplate"]].template;
                }

                scope.setExamIndex = function(){
                    for(var i = 0 ; i < scope[attrs["componentTemplate"]].example ; i++){
                        scope[attrs["componentTemplate"]].example[i].index = i;
                    }
                }
                /*
                 * setting이 끝났을 경우
                 */
                scope.endSetting    = function (current_question) {
                    scope.setExamIndex();
                    // 확인 버튼을 눌렀을 경우
                    scope[attrs["componentTemplate"]].makeShow = !scope[attrs["componentTemplate"]].makeShow;
                    scope[attrs["componentTemplate"]].viewShow = !scope[attrs["componentTemplate"]].viewShow;
                }

                /*
                 * 메뉴 수정 tool mouseover시 출력
                 */
                scope.menuShow = false;
                scope.eventHandler = function(e){
                    console.log(e);
                    scope.menuShow = (e.type == "mouseenter") ? true : false;

                    console.log(scope.menuShow);
                }

                /*
                 * 보기 추가
                 */
                scope.addExample = function(example){
                    var lastIndex = example.length - 1;
                    scope.errorChk();
                    example.push(
                        {'content': example.length + 1, 'exam_index': example.length}
                    );
                }
                /*
                 * 보기 삭제
                 */
                scope.removeExample = function(example){
                    var lastIndex = example.length - 1;
                    if(scope.errorChk(lastIndex))
                        return;
                    example.splice(lastIndex ,1);
                }

                scope.errorMsgShow = false;
                scope.errorChk      = function(lastIndex){
                    var plag = true;
                    // 보기 수가 2이하일 경우 삭제하지 못하도록함
                    if(lastIndex < 2){
                        scope.errorMsgShow = true;
                        plag = true;
                    }else{
                        scope.errorMsgShow = false;
                        plag = false;
                    }
                    return plag;
                }

                /*scope.$watch('files', function () {
                 scope.upload(scope.files);
                 });
                 */







                

                scope.endImgSetting = function(){

                    /*if(scope[attrs["componentTemplate"]].example[1].image != ""){
                     scope.endSetting();
                     return;
                     }*/

                    console.log("called");
                    uploaderA.uploadAll();
                    uploader.uploadAll();
                }

            },
            template: '<div ng-include="getContentUrl()"></div>'
        }
    })
    
  
    
    .controller("makingSpaceCtrl", function($scope, $timeout, $http, $location,  sessionService, $rootScope, ngDialog, $compile) {
  

        $rootScope.menubarShow = false;
        
        // 설문지 설정
        $scope.models = {
            dragging: false,
            selected        : null,
            templates       : [
                {
                    'index': "",
                    'num':"",
                    'title': 'multiple',
                    'drag': true,
                    'type': 'multiple',
                    'makeShow':true,
                    'viewShow':false,
                    'template':'multiple.html',
                    'important': false, 
                    'question_content': "",
                    'logic':false,
                    'logicX':200,
                    'logicY':0,
                    'example': [
                        {'content': "", 'exam_index' : "0" , 'nextQNum' : ""},
                        {'content': "", 'exam_index' : "1" , 'nextQNum' : ""},
                        {'content': "", 'exam_index' : "2", 'nextQNum': ""}
                    ]
                },
                {
                    'index': "",
                    'num':"",
                    'title': 'DropDown',
                    'drag': true,
                    'type': 'dropdown',
                    'makeShow':true,
                    'viewShow':false,
                    'template':'dropdown.html',
                    'important': false,
                    'question_content': "",
                    'logicX':200,
                    'logicY':0,
                    'example': [
                        {'content': "", 'exam_index' : "0"},
                        {'content': "", 'exam_index' : "1"},
                        {'content': "", 'exam_index' : "2"}
                    ]
                },
                {
                    'index': "",
                    'num':"",
                    'title': 'Matrix',
                    'drag': true,
                    'type': 'matrix',
                    'makeShow':true,
                    'viewShow':false,
                    'template':'matrix.html',
                    'important': false,
                    'logicX':200,
                    'logicY':0,
                    'question_content': " ",
                    'row': [
                        {'content': "", 'exam_index' : 0},
                        {'content': "", 'exam_index' : 1},
                        {'content': "", 'exam_index' : 2}
                    ],
                    'colum':[
                        {'content': "", 'exam_index' : 0},
                        {'content': "", 'exam_index' : 1},
                        {'content': "", 'exam_index' : 2}
                    ]

                },
              
                {
                    'index': "",
                    'num':"",
                    'title': 'singleTextbox',
                    'drag': true,
                    'type': 'singleTextbox',
                    'makeShow':true,
                    'viewShow':false,
                    'template':'singleTextbox.html',
                    'important': false,
                    'logicX':200,
                    'logicY':0,
                    'question_content': ""
                },
                {
                    'index': "",
                    'num':"",
                    'title': 'date',
                    'drag': true,
                    'type': 'date',
                    'makeShow':true,
                    'viewShow':false,
                    'template':'date.html',
                    'important': false,
                    'logicX':200,
                    'logicY':0,
                    'question_content': "",
                    'date': true,
                    'time': false
                },
                {
                    'index': "",
                    'num':"none",
                    'title': 'text',
                    'drag': true,
                    'type': 'text',
                    'makeShow':true,
                    'viewShow':false,
                    'template':'text.html',
                    'question_content': ""
                },
             


            ],
            questionnarie   : {
                "preview":[]
            }

        };




        $scope.autoMake = function(auto){
            console.log(auto);
            var current;
            for(var i = 0 ; i < $scope.models.templates.length ; i++){
                if($scope.models.templates[i].type == auto.type){
                    current = angular.copy($scope.models.templates[i]);
                    break;
                }
            }
            console.log(current);
            for(var i = 0 ; i < auto.num ; i++){
                $scope.models.questionnarie.preview.push(angular.copy(current));
                $scope.setQuestionIndex();
            }

        }

        $scope.copyQuestion = function(argIndex){
            console.log(argIndex);
            var copyed;
            for (var i = 0 ; i < $scope.models.questionnarie.preview.length ; i++ ){
                if ($scope.models.questionnarie.preview[i].index == argIndex){
                    copyed = angular.copy($scope.models.questionnarie.preview[i]);
                    break;
                }
            }
            $scope.models.questionnarie.preview.push(copyed);
            $scope.setQuestionIndex();
        };

        // 미리보기 클릭
        $scope.openPreview = function () {
            var new_dialog = ngDialog.open(
                {
                    template: 'components/makeQuestionnaire/preview.html',
                    data: {'questionnaire':  $scope.models.questionnarie.preview}
                });

            var elem = angular.element(document.querySelector('#previewDialog'));
            $compile(elem.contents())($scope);

            // example on checking whether created `new_dialog` is open
            $timeout(function() {
                console.log(ngDialog.isOpen(new_dialog.id));
            }, 2000)
        };

        $scope.removeQuestion = function(argIndex){

            for (var i = 0 ; i < $scope.models.questionnarie.preview.length ; i++ ){
                if ($scope.models.questionnarie.preview[i].index == argIndex){
                    $scope.models.questionnarie.preview.splice(i,1);
                    break;
                }
            }
        }

        // 문제 마다 설정
        $scope.setQuestionIndex = function(){

            var num = 0;

            for(var i = 0 ; i < $scope.models.questionnarie.preview.length ; i++){
                // index 셋팅
                $scope.models.questionnarie.preview[i].index = i;
                // 문제 넘버링
                if($scope.models.questionnarie.preview[i].num == "none"){
                    continue;
                }
                $scope.models.questionnarie.preview[i].num = num;
                num++;

            }
        }


        // 배포시작
 

        // 작성완료 클릭
        $scope.addNewQuestionnaire = function(){

            var user = JSON.parse(sessionService.get('data'));

            if(user.current_questionnaire.state == "new") {

                console.log("addNewQuestion(NEW)");
                console.log(user);
                user.current_questionnaire.preview = $scope.models.questionnarie.preview;
                $rootScope.current_questionnaire   = user.current_questionnaire;

                // 현재 설정내용을 세션에 추가하고


                // 새로 만들고 있을 경우

                console.log("test1");
                console.log(user);


                $http.post("components/makeQuestionnaire/php/insertQuestion.php", user)
                    .success(function (data, status, headers, config) {
                        console.log(data);
                        console.log("new");
                        sessionService.set('user', user);

                        $location.path('/makeHome');
                    });
            }

            // 수정상태일 경우
            else if(user.current_questionnaire.state == "making") {

                console.log("addNewQuestion(modify)");
                console.log(user);
                user.current_questionnaire.preview = $scope.models.questionnarie.preview;
                $rootScope.current_questionnaire   = user.current_questionnaire;

                // 현재 설정내용을 세션에 추가하고

                // 새로 만들고 있을 경우

                console.log("test1");
                console.log(user);

               
                user.current_questionnaire.delete = true;
             
                
                
                $http.post("components/makeQuestionnaire/php/deleteQuestionnaire.php", user.current_questionnaire)
                    .success(function (data, status, headers, config) {
                        console.log(data);
                        // 삭제 완료후 수정내용 입력
                        $http.post("components/makeQuestionnaire/php/insertQuestion.php", user)
                            .success(function (data, status, headers, config) {
                                console.log(data);
                                sessionService.set('user', user);
                                $location.path('/makeHome');
                            });
                    });
            }

        }
        
        var user = JSON.parse(sessionService.get('data'));
        console.log(user);
        if(user.current_questionnaire.state == "making"){
            // 설문지 내용 불러오기
            // 페이지 로드 시 정보 가져오기
            // DB에 전송
            $http.post("components/makeQuestionnaire/php/selectQuestionnaire.php", user.current_questionnaire)
                .success(function (data, status, headers, config) {
                    console.log(data);

                    for(var i = 0 ; i < data.length ; i++){
                        $scope.models.questionnarie.preview.push(data[i]);
                    }
                    console.log($scope.models.questionnarie.preview);
                    // draw($scope.models.questionnarie.preview);
                });
        }






    });

