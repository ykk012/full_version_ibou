'use strict';
angular.module("thinkLibrary")
.controller('NodeMenuCtrl', function($scope,$http,sessionService,$rootScope) {
   $scope.data = {};
$scope.data.m_num = 3;

var list={};
 var data={};
 data.m_num=$scope.data.m_num;

// 쿼리추가 제일마지막 노드값 + 노드밑에 뭐있는지. 

data.w_num=19;
console.log(data);


// $scope.serch = function(item){
//   console.log(item);
//   var data = {};
//   data.w_name=item;
//   console.log(data);
//     $http.post("php/selectWorkbenchName.php",data)
//             .success(function (data, status, headers, config) {
//                 console.log("workbench name serch");
//                 console.log(data);
//               $scope.workbenchname =data; // 데이터 저장해서 뿌려줌 
//                 console.log($scope.workbenchname);
              
//             });
//             }
            
         
$http.post("php/selectWorkbenchMnum.php",data)
            .success(function (data, status, headers, config) {
                console.log("test name");
                console.log(data);
              $scope.workbench =data; // 데이터 저장해서 뿌려줌 
                console.log($scope.workbench);
              
            });


$http.post("php/selectWorkbench.php",data)
            .success(function (data, status, headers, config) {
                console.log("workbench name");
                console.log(data);
              $scope.list =data; // 데이터 저장해서 뿌려줌 
                console.log($scope.list);
            });
            
            

            
            
          

            

$scope.button = function (item) {
    
    var className = '';
    if (item.k_depth === '0') {
      className = 'btn ';
    } else if (item.k_depth === '1') {
      className = 'btn btn-depth1';
    } else if (item.k_depth === '2') {
      className = 'btn btn-depth2';
    } else if (item.k_depth === '3') {
      className = 'btn btn-depth3';
    } else if (item.k_depth === '4') {
      className = 'btn btn-depth4';
    }else if (item.k_depth === '5') {
      className = 'btn btn-depth5';
    }
    else if (item.k_depth === '6') {
      className = 'btn btn-depth6';
    }
    else if (item.k_depth === '7') {
      className = 'btn btn-depth7';
    }
    
    return className;
  };
 
  
  $scope.Mbutton = function (item) {
    
    var className = '';
    if (item.k_depth === '0') {
      className = 'btn ';
    } else if (item.k_depth === '1') {
      className = 'btn btn-Mdepth1';
    } else if (item.k_depth === '2') {
      className = 'btn btn-Mdepth2';
    } else if (item.k_depth === '3') {
      className = 'btn btn-Mdepth3';
    } else if (item.k_depth === '4') {
      className = 'btn btn-Mdepth4';
    }else if (item.k_depth === '5') {
      className = 'btn btn-Mdepth5';
    }
    else if (item.k_depth === '6') {
      className = 'btn btn-Mdepth6';
    }
    else if (item.k_depth === '7') {
      className = 'btn btn-Mdepth7';
    }
    
    return className;
  };
  


            
            
            

 
});
