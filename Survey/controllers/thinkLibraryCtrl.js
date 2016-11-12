angular.module("thinkLibrary",['googlechart','ui.bootstrap', 'ngDropdowns','chart.js','ngSocial','dndLists','ngDialog','ngRoute','angularFileUpload','ngAnimate','angularjs-dropdown-multiselect','angular.vertilize','tree'])


//다이알로그 = 미리보기기능 , dndlist 드래그앤드랍,
    .directive('dropdownMultiselect', function(){
        return {
            restrict: 'E',
            scope:{
                model: '=model',
                options: '=',
                pre_selected: '=preSelected',
                subject: '=subject'
            },

            controller: function($scope){

                $scope.openDropdown = function(){
                    $scope.selected_items = [];
                    for(var i=0; i<$scope.pre_selected.length; i++){
                        $scope.selected_items.push($scope.pre_selected[i].id);
                    }
                };

                $scope.selectAll = function () {
                    $scope.model = _.pluck($scope.options, 'id');

                    console.log($scope.model);
                };

                $scope.deselectAll = function() {
                    $scope.model=[];
                    console.log($scope.model);
                };

                $scope.setSelectedItem = function(){
                    var id = this.option.id;
                    if (_.contains($scope.model, id)) {
                        $scope.model = _.without($scope.model, id);
                    } else {
                        $scope.model.push(id);
                    }
                    console.log($scope.model);
                    return false;
                };

                $scope.isChecked = function (id) {
                    if (_.contains($scope.model, id)) {
                        return 'glyphicon glyphicon-ok';
                    }
                    return false;
                };
            }
        }
    })



    .controller("thinkLibraryCtrl", function ($rootScope,$scope,sessionService) {
        // 메뉴바 쇼
        $rootScope.menubarShow = true;
        $scope.user = {};

        // 메뉴바 쇼
        $rootScope.menubarShow = true;
        // 실행될때마다 아이디 로그인 체크


        $scope.$on('$routeChangeStart', function () {
            
            $scope.user = '1';//유저넘버
            $scope.board = '1';//보드넘버

            console.log("user");
            console.log($scope.user);
            console.log("board");
            console.log($scope.board);

//유저부분 삭제 or 수정하셈
            $scope.survey = {};
            $scope.survey.m_num=$scope.user;
            $scope.survey.b_num=$scope.board;
            sessionService.set('user', $scope.survey);

            

            if ($scope.user) {
                $scope.current_questionnaire = $scope.user.current_questionnaire;


                console.log("성공");
                console.log("유저 넘버");
                console.log($scope.user);

            }
            else {
                console.log("실패");
            }

        })
    })

    .controller("makeHomeCtrl", function($scope) {
        $scope.questionnaire_modify = function(questionnaire){
            $location.path("/makingSpace");
        }
    })

