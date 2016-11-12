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
.columns-selected{
    border: 1px solid gray;
    background-color:gray;
    margin : 2px;
    z-index:0;
}
.ui-icon-circle-triangle-w{
       width:0; height:0; border-style:solid; border-width:10px;
      border-color:transparent grey transparent transparent;
      
}
.ui-icon-circle-triangle-e{
    width:0; height:0; border-style:solid; border-width:10px;
    border-color:transparent transparent transparent grey;  
}

.sorted,
.ordered,
.viewed {
    border: 0px !important;
    
        background-color: #899198 !important;
    margin : 2px;
    color:black;
    
 
}
.sorting, .ordering, .viewing{
 text-align:center;

    background: #cdcdcd;
    border-radius: 2px;
    color: black;
    font-size: 20px;
    font-family:"Sandoll Objet 01 Regular", serif;
    height: 45px;
    letter-spacing: 1px;
    border: 2px solid rgba(255, 255, 255, 0.41);
    padding: 10px;
    text-align: center;
    
    /*text-shadow: 0 0 15px #ffdd65, 0 0 8px #ffdd65,0 0 3px #fff;*/
   
}


.nav-tabs>li>a{
  margin: 0 0 !important;
  background-color: #cdcdcd !important;
  color:black !important;
}
.nav-tabs>li>a:focus, .nav-tabs>li>a:hover{
  text-decoration :none;
  background-color: #899198;
  color:black !important;  
}
.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover{
  text-decoration :none;
  background-color: #899198 !important;
  color:black !important;  
}

.tabs{
  background: white !important;
    border-radius: 2px;
    color: black;
     
    font-family:"Sandoll Objet 01 Regular", serif;
    
    letter-spacing: 1px;
   

    text-align: center;
    color:white;
    /*text-shadow: 0 0 15px #ffdd65, 0 0 8px #ffdd65,0 0 3px #fff;*/
}

</style>

<link href="../../css/warehouse/jquery-ui.css" rel="stylesheet">
<script src='../../js/warehouse/menu.js'></script>
<script src="../../js/warehouse/scroll.js"></script>
<script src="../../js/warehouse/jquery-ui.js"></script>
<script src="../../js/warehouse/jquery-ui-timepicker-addon.js"></script>    
<script type="text/javascript">
    function ajax_view(mode){
        obj.view_mode = mode;
        console.log(obj);
        
        v_custom_Post('warehouse','sorted_files_workbech','warehouses',JSON.stringify(obj));
    }

    $(function() {

        window.obj={
            sort : {},
            share : "",
            fnums : new Array(),
            search_mod: "mid",
            view_mode : "table"
        };

        
        $("<div id='DESC' class='ordering'>"+"<span >日付順</span>"+"</div>").appendTo("#tab1");
        $("<div id='ASC' class='ordering'>"+"<span>後の順</span>"+"</div>").appendTo("#tab1");

        
        $("<div id='image' class='sorting'>"+"<span>イメージファイル</span>"+"</div>").appendTo("#tab2");
        $("<div id='archive' class='sorting'>"+"<span>圧縮ファイル</span>"+"</div>").appendTo("#tab2");
        $("<div id='document' class='sorting'>"+"<span>文書ファイル</span>"+"</div>").appendTo("#tab2");
        $("<div id='share' class='sorting'>"+"<span>共有ファイル</span>"+"</div>").appendTo("#tab2");
        
        $("<div id='gallery' class='viewing'>"+"<span >ギャラリー</span>"+"</div>").appendTo("#tab3");
        $("<div id='table' class='viewing'>"+"<span>掲示板</span>"+"</div>").appendTo("#tab3");



        $("input:text[name=date1]").datepicker({ dateFormat: 'yy-mm-dd'});
        $("input:text[name=date2]").datepicker({ dateFormat: 'yy-mm-dd'});
        for(var i = 0; i < document.getElementsByClassName('sorting').length ; i++){
            document.getElementsByClassName('sorting')[i].onclick = function() {

                if (this.getAttribute("class").indexOf("sorted") != -1) {
                    this.classList.remove("sorted");
                }else{
                    this.classList.toggle("sorted");
                }
            }
            
        }
        for(var i = 0; i < document.getElementsByClassName('ordering').length ; i++){
            document.getElementsByClassName('ordering')[i].onclick = function() {

                if (this.getAttribute("class").indexOf("ordered") != -1) {
                    this.classList.remove("ordered");
                    
                }else{
                    for(var i = 0; i < document.getElementsByClassName('ordering').length ; i++){
                        if(document.getElementsByClassName('ordering')[i].classList.contains('ordered')){
                            document.getElementsByClassName('ordering')[i].classList.remove('ordered');
                            
                        }    
                    }
                    this.classList.add("ordered");
                }
                
            }
            
        }
        for(var i = 0; i < document.getElementsByClassName('viewing').length ; i++){
            document.getElementsByClassName('viewing')[i].onclick = function() {

                if (this.getAttribute("class").indexOf("viewed") != -1) {
                    this.classList.remove("viewed");
                    
                }else{
                    for(var i = 0; i < document.getElementsByClassName('viewing').length ; i++){
                        if(document.getElementsByClassName('viewing')[i].classList.contains('viewed')){
                            document.getElementsByClassName('viewing')[i].classList.remove('viewed');
                            
                        }    
                    }
                    this.classList.add("viewed");
                }
                
            }
            
        }
        $("#DESC").bind('click',function() {
            window.obj.order = "";
            

                obj.order = this.id;

            

            console.log(obj);
            v_custom_Post('warehouse','sorted_files_workbech','warehouses',JSON.stringify(obj));

        });
        $("#ASC").bind('click',function() {
            window.obj.order = "";
            

                obj.order = this.id;


            console.log(obj);
            v_custom_Post('warehouse','sorted_files_workbech','warehouses',JSON.stringify(obj));

        });

        $("#share").bind('click',function() {
        
            
            window.obj.share= this.id;
            if($("#share").hasClass("sorted")){
                window.obj.share= this.id;
                
            }else{
                obj.share="";
            }

            console.log(obj);
            v_custom_Post('warehouse','sorted_files_workbech','warehouses',JSON.stringify(obj));
        });

        $("#image").bind('click',function() {
            window.obj.sort.ext = new Array();
            $(".sorted").each(function (index) {

                if(this.id!="share"){
                    obj.sort.ext[index] = this.id;
                }

            });
            
            console.log(obj);
            v_custom_Post('warehouse','sorted_files_workbech','warehouses',JSON.stringify(obj));
        });
        $("#archive").bind('click',function() {
            window.obj.sort.ext = new Array();
            $(".sorted").each(function (index) {

                if(this.id!="share"){
                    obj.sort.ext[index] = this.id;
                }
            });
            
            console.log(obj);
            v_custom_Post('warehouse','sorted_files_workbech','warehouses',JSON.stringify(obj));
        });
        
        $("#document").bind('click',function() {
            window.obj.sort.ext = new Array();
            
            $(".sorted").each(function (index) {
                if(this.id!="share"){
                    obj.sort.ext[index] = this.id;
                }
            });
            
            console.log(obj);
           v_custom_Post('warehouse','sorted_files_workbech','warehouses',JSON.stringify(obj));
        });
        
        if(!$(".sorting").hasClass("sorted")){
                delete obj.sort.ext;
        }
        
        
        $("input:radio[name=search_mod]").bind('click',function() {

            $("input:radio[name=search_mod]:checked").each(function () {
                obj.search_mod = this.value;

            });

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



            query1 = $(this).val();
            console.log(query1);
            obj.sort.date1 = query1;
            query1="";
            v_custom_Post('warehouse','sorted_files_workbech','warehouses',JSON.stringify(obj));

            if(obj.sort.date2 == ""){
                delete obj.sort.date2;
            }
        });
        var query2 = "";
        $("input:text[name=date2]").bind('change',function(event) {


            query2 = $(this).val();
            console.log(query2);
            obj.sort.date2 = query2;
            query2="";


            v_custom_Post('warehouse','sorted_files_workbech','warehouses',JSON.stringify(obj));

            if(obj.sort.date1 == ""){
                delete obj.sort.date1;
            }

        });
        
        
        $("#gallery").bind('click',function() {
            
            

                obj.view_mode = this.id;

            

            console.log(obj);
            v_custom_Post('warehouse','sorted_files_workbech','warehouses',JSON.stringify(obj));

        });
        $("#table").bind('click',function() {
            
            

                obj.view_mode = this.id;


            console.log(obj);
            v_custom_Post('warehouse','sorted_files_workbech','warehouses',JSON.stringify(obj));

        });
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
                alert("プレビューをサポートしていない形式のファイルです");
            }
            window.open("https://project-board-css-karchev.c9users.io/warehouse/preview/"+f_num+"/"+f_save, "_blank","width=800 height=600 menubar=no status=no location=no menubar=no toolbar=no"); 
           
            
        });
        
    })


</script>
<div style="display:inline-block; position:relative; width:30%;">
    <form class="navbar-form" role="search">
        <div class="form-group">
            <input type="text" id="search_query" class="form-control" placeholder="Search">

            <br/>
            <input type="radio" name="search_mod" value="before" class="btn btn-default"><label>前から</label>
            <input type="radio" name="search_mod" value="mid" class="btn btn-default"><label>間</label>
            <input type="radio" name="search_mod" value="after" class="btn btn-default"><label>後ろから</label>
        </div>
    </form>
    <div>
        <ul class="nav nav-tabs">
            <li class="active tabs"><a href="#tab1" data-toggle="tab" aria-expanded="true">整列</a></li>
            <li class="tabs"><a href="#tab2" data-toggle="tab" aria-expanded="false">Filter</a></li>
            <li class="tabs"><a href="#tab3" data-toggle="tab" aria-expanded="false">形態</a></li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="tab1">


            </div>
            <div class="tab-pane fade" id="tab2">

                <!-- <table class="table-striped table-hover "> -->
                <table class='mytable'>
                    <thead>
                    <tr>
                        <th>期間</th>

                    </tr>
                    </thead>

                    <tr>
                        <td class='td1'><input type='text' name='date1' style="width:100px;"></td>
                        <td class='td2'> ~ </td>
                        <td class='td3'><input type='text' name='date2' style="width:100px;"></td>
                    </tr>


                    </tbody>
                </table>


            </div>
            <div class="tab-pane fade" id="tab3">
                
    


            </div>
        </div>
    </div>
</div>

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
        obj.k_num = <?php echo $k_num; ?>
    
        
        click_menu_keyword('columns','td:first input:hidden');
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
    });
</script>
<div class="warehouses" style="display: inline-block; position:relative; width:70%; float:right;">


<table class="table mb0 table-files" id="view_table">
    <thead>
    <tr>

        <th>
            <a href="">
                <span class="sortorder" >名前</span>
            </a>
        </th>
        <th class="hidden-sm hidden-xs">
            <a href="">

                <span class="sortorder">作成者</span>
            </a>
        </th>
        <th class="hidden-sm hidden-xs">
            <a href="">

                <span class="sortorder" >作成日</span>
            </a>
        </th>
        <th class="hidden-sm hidden-xs">
            <a href="">

                <span class="sortorder">共有の数</span>
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
                            echo "<img src='../../img/warehouse/txt-icon.png'>";
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
                            echo "<img src='../../img/warehouse/.zip.png'>";
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