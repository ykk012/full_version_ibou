{"filter":false,"title":"filter.php","tooltip":"/application/views/warehouse-workbench/filter.php","ace":{"folds":[],"scrolltop":240,"scrollleft":0,"selection":{"start":{"row":24,"column":8},"end":{"row":24,"column":8},"isBackwards":false},"options":{"guessTabSize":true,"useWrapMode":false,"wrapToView":true},"firstLineState":{"row":11,"state":"js-start","mode":"ace/mode/php"}},"hash":"b0cdd2fda2e8547b0d02b698beb6779cba30b17b","undoManager":{"mark":35,"position":35,"stack":[[{"start":{"row":0,"column":0},"end":{"row":197,"column":0},"action":"insert","lines":["","<script type=\"text/javascript\">","","    function tree_html(type,name,value){","        var html=\"<input style='position: absolute; left: 180px; width:100px; height: 20px;' type='\"+type+\"' name='\"+name+\"' value=\";","        html += value;","        html += \">\";","        return html;","","","    }","    $(function() {","","        window.obj={","            sort : {},","            share : \"\",","            fnums : new Array(),","            search_mod: \"before\",","            view_mode : \"table\"","        };","","","        $(\"<span>오름차 순</span>\").appendTo(\"#tab1\").after(tree_html('radio','order','ASC')+\"</br>\");","        $(\"<span>내림차 순</span>\").appendTo(\"#tab1\").after(tree_html('radio','order','DESC')+\"</br>\");","        ","        ","        $(\"<span>이미지 파일</span>\").appendTo(\"#tab2\").after(tree_html(\"checkbox\",\"ext\",\"image\")+\"</br>\");","        $(\"<span>압축 파일</span>\").appendTo(\"#tab2\").after(tree_html(\"checkbox\",\"ext\",\"archive\")+\"</br>\");","        $(\"<span>쉐어 파일(본인파일포함)</span>\").appendTo(\"#tab2\").after(tree_html(\"checkbox\",\"share\",\"share\"));","        ","        $(\"input:text[name=date1]\").datetimepicker({","            showSecond: true,","            dateFormat: 'yy-mm-dd',","            timeFormat: 'hh:mm:ss'","        });","        $(\"input:text[name=date2]\").datetimepicker({","            showSecond: true,","            dateFormat: 'yy-mm-dd',","            timeFormat: 'hh:mm:ss'","        });","        ","        $(\"input:radio[name=order]\").bind('click',function() {","            window.obj.order = \"\";","            $(\"input:radio[name=order]:checked\").each(function (index) {","","                obj.order = this.value;","                /*$(\".main-body\").unbind('contextmenu');","                $('#jqContextMenu').unbind();","                $('#context_shadow').unbind();","                $('#context_shadow').remove();","                $('#jqContextMenu').remove();","*/","            });","            if(!$(\"input:radio[name=order]\").is(\":checked\")){","                delete obj.order;","            }","            ","            console.log(obj);","            custom_Post('warehouse','sorted_files','main-body',JSON.stringify(obj));","","        });","         ","        $(\"input:checkbox[name=share]\").bind('click',function() {","            window.obj.share = \"\";","            $(\"input:checkbox[name=share]:checked\").each(function (index) {","","                window.obj.share= this.value;","","                /*$(\".main-body\").unbind('contextmenu');","                $('#jqContextMenu').unbind();","                $('#context_shadow').unbind();","                $('#context_shadow').remove();","                $('#jqContextMenu').remove();*/","            });","            ","            console.log(obj);","            custom_Post('warehouse','sorted_files','main-body',JSON.stringify(obj));","        });","         ","        $(\"input:checkbox[name=ext]\").bind('click',function() {","            window.obj.sort.ext = new Array();","            $(\"input:checkbox[name=ext]:checked\").each(function (index) {","","                obj.sort.ext[index] = this.value;","","                /*$(\".main-body\").unbind('contextmenu');","                $('#jqContextMenu').unbind();","                $('#context_shadow').unbind();","                $('#context_shadow').remove();","                $('#jqContextMenu').remove();*/","            });","            if(!$(\"input:checkbox[name=ext]\").is(\":checked\")){","                delete obj.sort.ext","            }","            console.log(obj);","            custom_Post('warehouse','sorted_files','main-body',JSON.stringify(obj));","        });","        $(\"input:radio[name=search_mod]\").bind('click',function() {","            ","            $(\"input:radio[name=search_mod]:checked\").each(function () {","                 obj.search_mod = this.value;","","            });","","            if(!$(\"input:radio[name=search_mod]\").is(\":checked\")){","                delete obj.search_mod","            }","            console.log(obj);","            custom_Post('warehouse','sorted_files','main-body',JSON.stringify(obj));","        });","        $('#search_query').keyup(function(event) {","                var query = \"\";","                query = $('#search_query').val();","                console.log(query);","                if(query !== \"\") {","                    obj.sort.search = query;","                }else {","                    delete obj.sort.search;","                }","                custom_Post('warehouse','sorted_files','main-body',JSON.stringify(obj));","","        });","        $(\"input:text[name=date1]\").bind('change',function(event) {","                var query = \"\";","                query = $(this).val();","                console.log(query);","                if(query !== \"\") {","                    obj.sort.date1 = query;","                }else {","                    delete obj.sort.date1;","                }","                custom_Post('warehouse','sorted_files','main-body',JSON.stringify(obj));","","        });","        $(\"input:text[name=date2]\").bind('change',function(event) {","                var query = \"\";","                query = $(this).val();","                console.log(query);","                if(query !== \"\") {","                    obj.sort.date2 = query;","                }else {","                    delete obj.sort.date2;","                }","                custom_Post('warehouse','sorted_files','main-body',JSON.stringify(obj));","","        });","","","    });","","","</script>","<form class=\"navbar-form\" role=\"search\">","    <div class=\"form-group\">","        <input type=\"text\" id=\"search_query\" class=\"form-control\" placeholder=\"Search\">","","    <br/>","    <label>첫글자</label><input type=\"radio\" name=\"search_mod\" value=\"before\" class=\"btn btn-default\">","    <label>가운데</label><input type=\"radio\" name=\"search_mod\" value=\"mid\" class=\"btn btn-default\">","    <label>마지막</label><input type=\"radio\" name=\"search_mod\" value=\"after\" class=\"btn btn-default\">","    </div>","</form>","<div class=\"bs-component\">","    <ul class=\"nav nav-tabs\">","        <li class=\"active\"><a href=\"#tab1\" data-toggle=\"tab\" aria-expanded=\"true\">정렬</a></li>","        <li class=\"\"><a href=\"#tab2\" data-toggle=\"tab\" aria-expanded=\"false\">필터</a></li>","    </ul>","    <div id=\"myTabContent\" class=\"tab-content\">","        <div class=\"tab-pane fade active in\" id=\"tab1\">","            ","            <div class=\"bs-component\">","              <table class=\"table table-striped table-hover \">","                <thead>","                  <tr>","                    <th>기간</th>","                    ","                  </tr>","                </thead>","                ","                  <tr class=\"info\">","                    <td><input type='text' name='date1'>에서</td>  ","                  </tr>","                  <tr class=\"info\">","                    <td><input type='text' name='date2'>까지</td>","                  </tr>","                  ","                </tbody>","              </table> ","            ","          </div>","        </div>","        <div class=\"tab-pane fade\" id=\"tab2\">","","        </div>","    </div>","</div>","",""],"id":1}],[{"start":{"row":191,"column":39},"end":{"row":191,"column":43},"action":"remove","lines":["tab2"],"id":2},{"start":{"row":191,"column":39},"end":{"row":191,"column":40},"action":"insert","lines":["f"]}],[{"start":{"row":191,"column":40},"end":{"row":191,"column":41},"action":"insert","lines":["i"],"id":3}],[{"start":{"row":191,"column":40},"end":{"row":191,"column":41},"action":"remove","lines":["i"],"id":4}],[{"start":{"row":191,"column":39},"end":{"row":191,"column":40},"action":"remove","lines":["f"],"id":5}],[{"start":{"row":191,"column":39},"end":{"row":191,"column":40},"action":"insert","lines":["t"],"id":6}],[{"start":{"row":191,"column":40},"end":{"row":191,"column":41},"action":"insert","lines":["a"],"id":7}],[{"start":{"row":191,"column":41},"end":{"row":191,"column":42},"action":"insert","lines":["b"],"id":8}],[{"start":{"row":191,"column":41},"end":{"row":191,"column":42},"action":"remove","lines":["b"],"id":9}],[{"start":{"row":191,"column":40},"end":{"row":191,"column":41},"action":"remove","lines":["a"],"id":10}],[{"start":{"row":191,"column":39},"end":{"row":191,"column":40},"action":"remove","lines":["t"],"id":11}],[{"start":{"row":191,"column":39},"end":{"row":191,"column":40},"action":"insert","lines":["m"],"id":12}],[{"start":{"row":191,"column":40},"end":{"row":191,"column":41},"action":"insert","lines":["o"],"id":13}],[{"start":{"row":191,"column":41},"end":{"row":191,"column":42},"action":"insert","lines":["d"],"id":14}],[{"start":{"row":191,"column":42},"end":{"row":191,"column":43},"action":"insert","lines":["a"],"id":15}],[{"start":{"row":191,"column":43},"end":{"row":191,"column":44},"action":"insert","lines":["t"],"id":16}],[{"start":{"row":191,"column":43},"end":{"row":191,"column":44},"action":"remove","lines":["t"],"id":17}],[{"start":{"row":191,"column":43},"end":{"row":191,"column":44},"action":"insert","lines":["l"],"id":18}],[{"start":{"row":191,"column":44},"end":{"row":191,"column":45},"action":"insert","lines":["t"],"id":19}],[{"start":{"row":191,"column":45},"end":{"row":191,"column":46},"action":"insert","lines":["a"],"id":20}],[{"start":{"row":191,"column":46},"end":{"row":191,"column":47},"action":"insert","lines":["p"],"id":21}],[{"start":{"row":191,"column":47},"end":{"row":191,"column":48},"action":"insert","lines":["2"],"id":22}],[{"start":{"row":168,"column":49},"end":{"row":168,"column":53},"action":"remove","lines":["tab1"],"id":23},{"start":{"row":168,"column":49},"end":{"row":168,"column":58},"action":"insert","lines":["modaltap2"]}],[{"start":{"row":22,"column":43},"end":{"row":22,"column":47},"action":"remove","lines":["tab1"],"id":27},{"start":{"row":22,"column":43},"end":{"row":22,"column":52},"action":"insert","lines":["modaltap2"]}],[{"start":{"row":22,"column":51},"end":{"row":22,"column":52},"action":"remove","lines":["2"],"id":28}],[{"start":{"row":22,"column":51},"end":{"row":22,"column":52},"action":"insert","lines":["1"],"id":29}],[{"start":{"row":23,"column":43},"end":{"row":23,"column":47},"action":"remove","lines":["tab1"],"id":30},{"start":{"row":23,"column":43},"end":{"row":23,"column":52},"action":"insert","lines":["modaltap2"]}],[{"start":{"row":23,"column":51},"end":{"row":23,"column":52},"action":"remove","lines":["2"],"id":31}],[{"start":{"row":23,"column":51},"end":{"row":23,"column":52},"action":"insert","lines":["1"],"id":32}],[{"start":{"row":26,"column":44},"end":{"row":26,"column":48},"action":"remove","lines":["tab2"],"id":33},{"start":{"row":26,"column":44},"end":{"row":26,"column":53},"action":"insert","lines":["modaltap2"]}],[{"start":{"row":27,"column":43},"end":{"row":27,"column":47},"action":"remove","lines":["tab2"],"id":34},{"start":{"row":27,"column":43},"end":{"row":27,"column":52},"action":"insert","lines":["modaltap2"]}],[{"start":{"row":28,"column":51},"end":{"row":28,"column":55},"action":"remove","lines":["tab2"],"id":35},{"start":{"row":28,"column":51},"end":{"row":28,"column":60},"action":"insert","lines":["modaltap2"]}],[{"start":{"row":165,"column":31},"end":{"row":165,"column":35},"action":"remove","lines":["tab2"],"id":36},{"start":{"row":165,"column":31},"end":{"row":165,"column":40},"action":"insert","lines":["modaltap2"]}],[{"start":{"row":164,"column":37},"end":{"row":164,"column":41},"action":"remove","lines":["tab1"],"id":37},{"start":{"row":164,"column":37},"end":{"row":164,"column":46},"action":"insert","lines":["modaltap2"]}],[{"start":{"row":164,"column":45},"end":{"row":164,"column":46},"action":"remove","lines":["2"],"id":38}],[{"start":{"row":164,"column":45},"end":{"row":164,"column":46},"action":"insert","lines":["1"],"id":39}]]},"timestamp":1468725459617}