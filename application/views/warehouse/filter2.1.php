<style type="text/css">
    .image{
    display : inline-block;
    position:relative;
    float: left;
    height: 300px;
    width:250px;
    margin-bottom : 0px;
    margin-right : 0px;
    border: 1px solid white;
    z-index:0;
}
.image-selected{
    border: 1px solid black;
    background-color:white;
}
.image-selected > img{
    opacity: 0.5;
}
.image > img{
    height:70%;
    width :100%;
    
}
.image > a{
    display :inherit;
}
.image-magnified{
    z-index:100;
}
.image-magnified > img{
    height:400px;
    width:500px;
    /*margin-left:-150px;
    margin-top:-100px;*/
    opacity:0.95;
}
.ui-icon-circle-triangle-w{
       width:0; height:0; border-style:solid; border-width:10px;
      border-color:transparent grey transparent transparent;
      
}
.ui-icon-circle-triangle-e{
    width:0; height:0; border-style:solid; border-width:10px;
    border-color:transparent transparent transparent grey;  
}

</style>
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
            search_mod: "mid",
            view_mode : "table"
        };


        $('<table></table>').appendTo("#tab1");
        $("<tr><td>"+tree_html('radio','order','DESC')+"</td><td>"+"<label >최신 순</label>"+"</td></tr>").appendTo("#tab1 table");
        $("<tr><td>"+tree_html('radio','order','ASC')+"</td><td>"+"<label>후 순</label>"+"</td></tr>").appendTo("#tab1 table");
        
        $("<table id='t1'></table>").appendTo("#tab2");
        $("<tr><td>"+tree_html("checkbox","ext","image")+"</td><td>"+"<span>이미지 파일</span>"+"</td></tr>").appendTo("#tab2 #t1");
        $("<tr><td>"+tree_html("checkbox","ext","archive")+"</td><td>"+"<span>압축 파일</span>"+"</td></tr>").appendTo("#tab2 #t1");
        $("<tr><td>"+tree_html("checkbox","ext","document")+"</td><td>"+"<span>문서 파일</span>"+"</td></tr>").appendTo("#tab2 #t1");
        $("<tr><td>"+tree_html("checkbox","share","share")+"</td><td>"+"<span>쉐어 파일</span>"+"</td></tr>").appendTo("#tab2 #t1");

        
        $("input:text[name=date1]").datepicker({ dateFormat: 'yy-mm-dd'});
        $("input:text[name=date2]").datepicker({ dateFormat: 'yy-mm-dd'});
        
        $("input:radio[name=order]").bind('click',function() {
            window.obj.order = "";
            $("input:radio[name=order]:checked").each(function (index) {

                obj.order = this.value;
                
            });
            if(!$("input:radio[name=order]").is(":checked")){
                delete obj.order;
            }

            console.log(obj);
            v_custom_Post('warehouse','sorted_files_workbech','warehouses',JSON.stringify(obj));

        });

        $("input:checkbox[name=share]").bind('click',function() {
            window.obj.share = "";
            $("input:checkbox[name=share]:checked").each(function (index) {

                window.obj.share= this.value;

               
            });

            console.log(obj);
            v_custom_Post('warehouse','sorted_files_workbech','warehouses',JSON.stringify(obj));
        });

        $("input:checkbox[name=ext]").bind('click',function() {
            window.obj.sort.ext = new Array();
            $("input:checkbox[name=ext]:checked").each(function (index) {

                obj.sort.ext[index] = this.value;

                
            });
            if(!$("input:checkbox[name=ext]").is(":checked")){
                delete obj.sort.ext
            }
            console.log(obj);
            v_custom_Post('warehouse','sorted_files_workbech','warehouses',JSON.stringify(obj));
        });
        $("input:radio[name=search_mod]").bind('click',function() {

            $("input:radio[name=search_mod]:checked").each(function () {
                obj.search_mod = this.value;

            });

            if(!$("input:radio[name=search_mod]").is(":checked")){
                delete obj.search_mod
            }
            console.log(obj);
            v_custom_Post('warehouse','sorted_files_workbech','warehouses',JSON.stringify(obj));
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
            v_custom_Post('warehouse','sorted_files_workbech','warehouses',JSON.stringify(obj));

        });

        var query1 = "";
        $("input:text[name=date1]").bind('change',function(event) {


            if(query1==""){
                query1 = $(this).val();
                console.log(query1);
                obj.sort.date1 = query1;
                query1="";
                v_custom_Post('warehouse','sorted_files_workbech','warehouses',JSON.stringify(obj));
            }
            if(typeof obj.sort.date1 != "undefined"){
                delete obj.sort.date1;
            }
        });
        var query2 = "";
        $("input:text[name=date2]").bind('change',function(event) {
            
            if(query2==""){
                query2 = $(this).val();
                console.log(query2);
                obj.sort.date2 = query2;
                query2="";
                v_custom_Post('warehouse','sorted_files_workbech','warehouses',JSON.stringify(obj));
            }
            if(typeof obj.sort.date2 != "undefined"){
                delete obj.sort.date2;
            }
            
        });
         for(var i = 0; i < document.getElementsByClassName('columns').length ; i++){
            document.getElementsByClassName('columns')[i].onclick = function() {

                if (this.getAttribute("class").indexOf("columns-selected") != -1) {
                    this.classList.remove("columns-selected");
                }else{
                    this.classList.toggle("columns-selected");
                }
            }
            document.getElementsByClassName('columns')[i].ondblclick = function(){

            }
        }
        var motherWindow=window;
        $('a.embed').bind('click',function(e){
            e.preventDefault();
            /*if($("#preview-content").length){
                $("#preview-content").remove();
            }*/
            
            var f_num = $(this).prop('id');
            
            if (this.getAttribute('href')!="") {
                var f_save = $(this).attr('href');
            }else{
                var f_save="unsupported";
                alert("미리보기를 지원하지않는 형식의 파일입니다");
            }
            motherWindow.open("https://project-board-css-karchev.c9users.io/warehouse/preview/"+f_num+"/"+f_save, "_blank","width=800 height=600 menubar=no status=no location=no menubar=no toolbar=no"); 
        });


    });


</script>
<div style="display:inline-block; position:relative; width:30%;">
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

                
            </div>
            <div class="tab-pane fade" id="tab2">
                <div class="bs-component">
                    <table class="table table-striped table-hover ">
                        <thead>
                        <tr>
                            <th>기간</th>

                        </tr>
                        </thead>

                        <tr class="info">
                            <td><input type='text' name='date1' style="width:100px;"></td>
                            <td>~</td>
                            <td><input type='text' name='date2' style="width:100px;"></td>
                        </tr>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

</div>

<div class="warehouses" style="display: inline-block; position:relative; width:70%; float:right;">

   <script type="text/javascript">
   

    $(function(){
        for(var i = 0; i < document.getElementsByClassName('image').length ; i++){
            document.getElementsByClassName('image')[i].onclick = function() {
                this.classList.toggle("image-selected");
                if (this.getAttribute("class").indexOf("image-magnified") != -1) {
                    this.classList.remove("image-magnified");
                }
            }
            document.getElementsByClassName('image')[i].ondblclick = function(){
                this.classList.add("image-magnified");
            }
        }
    });
    


</script>

<table class="table mb0 table-files" id="view_table">
    <thead>
    <tr>

        <th>
            <a href="">
                <span class="sortorder" >이름</span>
            </a>
        </th>
        <th class="hidden-sm hidden-xs">
            <a href="">

                <span class="sortorder">작성자</span>
            </a>
        </th>
        <th class="hidden-sm hidden-xs">
            <a href="">

                <span class="sortorder" >작성 날짜</span>
            </a>
        </th>
        <th class="hidden-sm hidden-xs">
            <a href="">

                <span class="sortorder">공유 수</span>
            </a>
        </th>

    </tr>
    </thead>
    <tbody class="file-item">
    <?php
    foreach($files as $th) {
        ?>
        <tr class="columns">

            <td  class="hidden-xs">
                <input type="hidden" value=<?= $th->f_num; ?> >
                <?php 
                    switch ($th->f_ext) {
                        case '.tiff':
                        case '.pdf':
                        case '.pptx':
                        case '.pps':
                        case '.doc':
                        case '.docx':
                            echo "<img src='../../img/warehouse/".$th->f_ext.".png' >";
                            echo "<a href='".$th->f_saved_name."' class='embed' id='".$th->f_num."'>";
                            echo $th->f_origin_name;
                            echo "</a>";
                            break;
                        case '.jpg':
                        case '.png':
                        case '.gif':
                            echo "<img src='../../img/warehouse/image-icon.png'>";
                            echo "<a href='".$th->f_saved_name."' class='embed' id='".$th->f_num."'>";
                            echo $th->f_origin_name;
                            echo "</a>";
                            break;
                        case '.txt':
                            echo "<img src='../../img/warehouse/empty-icon.png'>";
                            echo "<a href='".$th->f_saved_name."' class='embed' id='".$th->f_num."'>";
                            echo $th->f_origin_name;
                            echo "</a>";
                            break;
                        case '.mp3':
                            echo "<img src='../../img/warehouse/music-icon.png'>";
                            echo "<a href='' class='embed'  id='".$th->f_num."'>".$th->f_origin_name."</a>";
                            break;
                        case '.zip':
                        case '.rar':
                            echo "<img src='../../img/warehouse/zip-icon.png'>";
                            echo "<a href='' class='embed'  id='".$th->f_num."'>".$th->f_origin_name."</a>";
                            break;
                        
                        default:
                            echo "<img src='../../img/warehouse/empty-icon.png'>";
                            echo "<a href='' class='embed' id='".$th->f_num."'>".$th->f_origin_name."</a>";
                            break;
                    }
                    
                
                
                ?>
            </td>
            <td class="hidden-sm hidden-xs">
                <?= $th->m_id ?>
            </td>
            <td class="hidden-sm hidden-xs">
                <?= $th->f_upload_date; ?>
            </td>
            <td class="hidden-sm hidden-xs">
                <?= $th->f_share_nums; ?>
            </td>

        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
    


</div>