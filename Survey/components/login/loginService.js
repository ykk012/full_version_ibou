'use strict';
angular.module("thinkLibrary")
    .factory('loginService',function($window, $rootScope, $http, $location, sessionService, $route, alertService){
        return{
            login:function(data){

                // 로그인 검사
                $http.post('components/login/user.php',data)
                .success(function (data, status, headers, config) {
                    // 삭제 완료 후

                    var session = data.user;

                    console.log(session);

                    if(session.logined == false){
                        sessionService.set('user',session);
                        $rootScope.user = session;
                        console.log($rootScope.user);
                        alertService.add("success", "Success", 3000);

                        // $route.reload(); 와 기능이 다름.
                        $window.location.reload();
                    }
                    else  {

                        alertService.add("danger", "Error" , 3000);

                    }
                });
            },

            logout:function(){
                sessionService.destroy('user');
                $window.location.reload();
            },

            isloggined:function(){
                var temp = sessionService.get('user');

                // null일 경우 로그인 전
                // null이 아닐경우 로그인 중

                if (temp){
                    return JSON.parse(temp);
                }
                else {
                    return false;
                }
            }
        }

    });