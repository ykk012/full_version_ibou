
<script type="text/javascript">

    function tree_html(type,name,value){
        var html="<input style='vertial-align:-2px; width:20px; height: 20px;' type='"+type+"' name='"+name+"' value=";
        html += value;
        html += ">";
        return html;


    }
    $(function() {

        window.obj={
            sort : {},
            share : "",
            fnums : new Array(),
            search_mod: "before",
            view_mode : "table"
        };


        $("<div>"+tree_html('radio','order','ASC')+"<label >오름차 순</label>"+"</div>").appendTo("#tab1");
        $("<div>"+tree_html('radio','order','DESC')+"<label>내림차 순</label>"+"</div>").appendTo("#tab1");
        
        
        $("<div>"+tree_html("checkbox","ext","image")+"<span>이미지 파일</span>"+"</div>").appendTo("#tab2");
        $("<div>"+tree_html("checkbox","ext","archive")+"<span>압축 파일</span>"+"</div>").appendTo("#tab2");
        
        $("<div>"+tree_html("checkbox","share","share")+"<span>쉐어 파일(본인파일포함)</span>"+"</div>").appendTo("#tab2");
        
        $("input:text[name=date1]").datetimepicker({
            showSecond: true,
            dateFormat: 'yy-mm-dd',
            timeFormat: 'hh:mm:ss'
        });
        $("input:text[name=date2]").datetimepicker({
            showSecond: true,
            dateFormat: 'yy-mm-dd',
            timeFormat: 'hh:mm:ss'
        });
        
        $("input:radio[name=order]").bind('click',function() {
            window.obj.order = "";
            $("input:radio[name=order]:checked").each(function (index) {

                obj.order = this.value;
                /*$(".main-body").unbind('contextmenu');
                $('#jqContextMenu').unbind();
                $('#context_shadow').unbind();
                $('#context_shadow').remove();
                $('#jqContextMenu').remove();
                */
            });
            if(!$("input:radio[name=order]").is(":checked")){
                delete obj.order;
            }
            
            console.log(obj);
            custom_Post('warehouse','sorted_files','warehouses',JSON.stringify(obj));

        });
         
        $("input:checkbox[name=share]").bind('click',function() {
            window.obj.share = "";
            $("input:checkbox[name=share]:checked").each(function (index) {

                window.obj.share= this.value;

                /*$(".main-body").unbind('contextmenu');
                $('#jqContextMenu').unbind();
                $('#context_shadow').unbind();
                $('#context_shadow').remove();
                $('#jqContextMenu').remove();*/
            });
            
            console.log(obj);
            custom_Post('warehouse','sorted_files','warehouses',JSON.stringify(obj));
        });
         
        $("input:checkbox[name=ext]").bind('click',function() {
            window.obj.sort.ext = new Array();
            $("input:checkbox[name=ext]:checked").each(function (index) {

                obj.sort.ext[index] = this.value;

                /*$(".main-body").unbind('contextmenu');
                $('#jqContextMenu').unbind();
                $('#context_shadow').unbind();
                $('#context_shadow').remove();
                $('#jqContextMenu').remove();*/
            });
            if(!$("input:checkbox[name=ext]").is(":checked")){
                delete obj.sort.ext
            }
            console.log(obj);
            custom_Post('warehouse','sorted_files','warehouses',JSON.stringify(obj));
        });
        $("input:radio[name=search_mod]").bind('click',function() {
            
            $("input:radio[name=search_mod]:checked").each(function () {
                 obj.search_mod = this.value;

            });

            if(!$("input:radio[name=search_mod]").is(":checked")){
                delete obj.search_mod
            }
            console.log(obj);
            custom_Post('warehouse','sorted_files','warehouses',JSON.stringify(obj));
        });
        $('#search_query').keyup(function(event) {
                var query = "";
                query = $('#search_query').val();
                console.log(query);
                if(query !== "") {
                    obj.sort.search = query;
                }else {
                    delete obj.sort.search;
                }
                custom_Post('warehouse','sorted_files','warehouses',JSON.stringify(obj));

        });
        
        var query1 = "";
        $("input:text[name=date1]").bind('change',function(event) {
               
                
            if(query1==""){
                query1 = $(this).val();
                console.log(query1);
                if(query !== "") {
                    obj.sort.date1 = query;
                }else {
                    delete obj.sort.date1;
                }
                custom_Post('warehouse','sorted_files','warehouses',JSON.stringify(obj));
            }
        });
        var query2 = "";
        $("input:text[name=date2]").bind('change',function(event) {
                
            if(query2==""){    
                query2 = $(this).val();
                console.log(query2);
                if(query !== "") {
                    obj.sort.date2 = query;
                }else {
                    delete obj.sort.date2;
                }
                custom_Post('warehouse','sorted_files','warehouses',JSON.stringify(obj));
            }
        });


    });


</script>
<div style="display:inline-block; position:relative; width:300px;">
<form class="navbar-form" role="search">
    <div class="form-group">
        <input type="text" id="search_query" class="form-control" placeholder="Search">

    <br/>
    <input type="radio" name="search_mod" value="before" class="btn btn-default"><label>첫글자</label>
    <input type="radio" name="search_mod" value="mid" class="btn btn-default"><label>가운데</label>
    <input type="radio" name="search_mod" value="after" class="btn btn-default"><label>마지막</label>
    </div>
</form>
<div class="bs-component">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab" aria-expanded="true">정렬</a></li>
        <li class=""><a href="#tab2" data-toggle="tab" aria-expanded="false">필터</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active in" id="tab1">
            
            <div class="bs-component">
              <table class="table table-striped table-hover ">
                <thead>
                  <tr>
                    <th>기간</th>
                    
                  </tr>
                </thead>
                
                  <tr class="info">
                    <td><input type='text' name='date1'>에서</td>  
                  </tr>
                  <tr class="info">
                    <td><input type='text' name='date2'>까지</td>
                  </tr>
                  
                </tbody>
              </table> 
            
          </div>
        </div>
        <div class="tab-pane fade" id="tab2">

        </div>
    </div>
</div>

</div>