{"filter":false,"title":"test.js","tooltip":"/Survey/components/makeQuestionnaire/test.js","undoManager":{"mark":10,"position":10,"stack":[[{"start":{"row":0,"column":0},"end":{"row":111,"column":0},"action":"insert","lines":[""," $(function () {","    $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');","    $('.tree li.parent_li > span').on('click', function (e) {","        var children = $(this).parent('li.parent_li').find(' > ul > li');","        if (children.is(\":visible\")) {","            children.hide('fast');","            $(this).attr('title', 'Expand this branch').find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');","        } else {","            children.show('fast');","            $(this).attr('title', 'Collapse this branch').find(' > i').addClass('icon-minus-sign').removeClass('icon-plus-sign');","        }","        e.stopPropagation();","    });","});","","","angular.module('plunker', ['ui.bootstrap']);","function DialogDemoCtrl($scope, $dialog, $http){","","","","    buildEmptyTree();","","","    $scope.selectedNode = \"\";","   ",""," $scope.showNode = function(data) {","   ","   console.log(data);","","      ","        ","         return data.name;","","    };",""," $scope.isClient = function(selectedNode) {","","        if (selectedNode == undefined) {","            return false;","        }","","        if (selectedNode.device_name != undefined) {","            return true;","        }","","        return false;","    };",""," function buildEmptyTree() {","","        $scope.displayTree =","            [{","            \"name\": \"Root\",","            \"type_name\": \"Node\",","            \"show\": true,","            \"nodes\": [{","                \"name\": \"Loose\",","                \"group_name\": \"Node-1\",","                \"show\": true,","                \"nodes\": [{","                    \"name\": \"Node-1-1\",","                    \"device_name\": \"Node-1-1\",","                    \"show\": true,","                    \"nodes\": []","                }, {","                    \"name\": \"Node-1-2\",","                    \"device_name\": \"Node-1-2\",","                    \"show\": true,","                    \"nodes\": []","                }, {","                    \"name\": \"Node-1-3\",","                    \"device_name\": \"Node-1-3\",","                    \"show\": true,","                    \"nodes\": []","                }]","            }, {","                \"name\": \"God\",","                \"group_name\": \"Node-2\",","                \"show\": true,","                \"nodes\": [{","                    \"name\": \"Vadar\",","                    \"device_name\": \"Node-2-1\",","                    \"show\": true,","                    \"nodes\": []","                }]","            }, {","                \"name\": \"Borg\",","                \"group_name\": \"Node-3\",","                \"show\": true,","                \"nodes\": []","            }, {","                \"name\": \"Fess\",","                \"group_name\": \"Node-4\",","                \"show\": true,","                \"nodes\": []","            }]","        }];","        [{","            \"name\": \"Android\",","            \"type_name\": \"Android\",","            \"icon\": \"icon-android icon-3\",","            \"show\": true,","            \"nodes\": []","        }];","    }","","}","",""],"id":1}],[{"start":{"row":16,"column":0},"end":{"row":17,"column":78},"action":"insert","lines":["angular.module(\"thinkLibrary\")",".controller('NodeMenuCtrl', function($scope,$http,sessionService,$rootScope) {"],"id":2}],[{"start":{"row":17,"column":13},"end":{"row":17,"column":25},"action":"remove","lines":["NodeMenuCtrl"],"id":3},{"start":{"row":17,"column":13},"end":{"row":17,"column":20},"action":"insert","lines":["plunker"]}],[{"start":{"row":18,"column":0},"end":{"row":18,"column":44},"action":"remove","lines":["angular.module('plunker', ['ui.bootstrap']);"],"id":4}],[{"start":{"row":19,"column":0},"end":{"row":19,"column":48},"action":"remove","lines":["function DialogDemoCtrl($scope, $dialog, $http){"],"id":5}],[{"start":{"row":17,"column":23},"end":{"row":17,"column":73},"action":"remove","lines":["function($scope,$http,sessionService,$rootScope) {"],"id":6},{"start":{"row":17,"column":23},"end":{"row":17,"column":71},"action":"insert","lines":["function DialogDemoCtrl($scope, $dialog, $http){"]}],[{"start":{"row":0,"column":0},"end":{"row":14,"column":3},"action":"remove","lines":[""," $(function () {","    $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');","    $('.tree li.parent_li > span').on('click', function (e) {","        var children = $(this).parent('li.parent_li').find(' > ul > li');","        if (children.is(\":visible\")) {","            children.hide('fast');","            $(this).attr('title', 'Expand this branch').find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');","        } else {","            children.show('fast');","            $(this).attr('title', 'Collapse this branch').find(' > i').addClass('icon-minus-sign').removeClass('icon-plus-sign');","        }","        e.stopPropagation();","    });","});"],"id":7},{"start":{"row":0,"column":0},"end":{"row":15,"column":0},"action":"insert","lines":[""," $(function () {","    $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');","    $('.tree li.parent_li > span').on('click', function (e) {","        var children = $(this).parent('li.parent_li').find(' > ul > li');","        if (children.is(\":visible\")) {","            children.hide('fast');","            $(this).attr('title', 'Expand this branch').find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');","        } else {","            children.show('fast');","            $(this).attr('title', 'Collapse this branch').find(' > i').addClass('icon-minus-sign').removeClass('icon-plus-sign');","        }","        e.stopPropagation();","    });","});",""]}],[{"start":{"row":113,"column":0},"end":{"row":113,"column":1},"action":"insert","lines":[")"],"id":8}],[{"start":{"row":113,"column":1},"end":{"row":113,"column":2},"action":"insert","lines":[";"],"id":9}],[{"start":{"row":18,"column":32},"end":{"row":18,"column":46},"action":"remove","lines":["DialogDemoCtrl"],"id":10}],[{"start":{"row":18,"column":31},"end":{"row":18,"column":32},"action":"remove","lines":[" "],"id":11}]]},"ace":{"folds":[],"scrolltop":0,"scrollleft":0,"selection":{"start":{"row":13,"column":7},"end":{"row":13,"column":7},"isBackwards":false},"options":{"guessTabSize":true,"useWrapMode":false,"wrapToView":true},"firstLineState":0},"timestamp":1469059200874,"hash":"6cdf873c6b3e9a8eda9b31a7f131a1b1728de34e"}