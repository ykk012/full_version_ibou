angular.module('thinkLibrary')

  .controller('AbnTestController', function($scope, $timeout,$rootScope,$http) {
    var tree, treedata_avm;
    $scope.my_tree_handler = function(branch) {
      var _ref;

    };
            
$scope.node_click = function(item){ //워크벤치명 클릭시
            console.log(item);
            $http.post("php/selectKeywordAll.php",item)
            .success(function (data, status, headers, config) {
                console.log("depth");
                console.log(data);
                $rootScope.keyword =data; // 데이터 저장해서 뿌려줌 
                console.log($rootScope.keyword);
                 treedata_avm=$rootScope.keyword;
                 
            });
          };
          
          
    treedata_avm = [
      {

        label: 'ベビーウェアラブル機器',
        children: [
         {
            label: '重さ',
            children: ['100g', '150g', '200g']
          }, {
            label: '部位',
            children: ['手首', '足首', '首']
          }
             ,
             
        {
        label: '機能',
        children: [
        
              {
                label: '体温チェック機能',


              }, {
                label: '排便アラーム機能',

              }, {
                label: '睡眠状態のお知らせ機能',

              }
          
        ]
      }
      ,
       {
            label: '価格',
            children: 
            [
                  {
                    label: '5000円',

                  }, {
                    label: '10000円',

                  }, {
                    label: '15000円',

                  }
            ]
          }
        ]
      }
      
      
   
    ];

    $scope.my_data = treedata_avm;
    $scope.try_changing_the_tree_data = function() {

        return $scope.my_data = treedata_avm;

    };
    $scope.my_tree = tree = {};
    $scope.try_async_load = function() {
      $scope.my_data = [];
      $scope.doing_async = true;
      return $timeout(function() {

          $scope.my_data = treedata_avm;

        $scope.doing_async = false;
        return tree.expand_all();
      }, 1000);
    };
    return $scope.try_adding_a_branch = function() {
      var b;
      b = tree.get_selected_branch();
      return tree.add_branch(b, {
        label: 'New Branch',
        data: {
          something: 42,
          "else": 43
        }
      });
    };
  });


