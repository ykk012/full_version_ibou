<style type="text/css">
    
    .sorted,
    .ordered,
    .viewed{
    border: 0px !important;
    
        background-color: #899198 !important;
    margin : 2px;
    color:black;
    
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
    function ajax_view(mode){
        obj.view_mode = mode;
        console.log(obj);
        
        custom_Post('warehouse','sorted_files','main-body',JSON.stringify(obj));
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
            custom_Post('warehouse','sorted_files','main-body',JSON.stringify(obj));

        });
        $("#ASC").bind('click',function() {
            window.obj.order = "";
            

                obj.order = this.id;


            console.log(obj);
            custom_Post('warehouse','sorted_files','main-body',JSON.stringify(obj));

        });

        $("#share").bind('click',function() {
        
            
            window.obj.share= this.id;
            if($("#share").hasClass("sorted")){
                window.obj.share= this.id;
                
            }else{
                obj.share="";
            }

            console.log(obj);
            custom_Post('warehouse','sorted_files','main-body',JSON.stringify(obj));
        });

        $("#image").bind('click',function() {
            window.obj.sort.ext = new Array();
            $(".sorted").each(function (index) {

                if(this.id!="share"){
                    obj.sort.ext[index] = this.id;
                }

            });
            
            console.log(obj);
            custom_Post('warehouse','sorted_files','main-body',JSON.stringify(obj));
        });
        $("#archive").bind('click',function() {
            window.obj.sort.ext = new Array();
            $(".sorted").each(function (index) {

                if(this.id!="share"){
                    obj.sort.ext[index] = this.id;
                }
            });
            
            console.log(obj);
            custom_Post('warehouse','sorted_files','main-body',JSON.stringify(obj));
        });
        
        $("#document").bind('click',function() {
            window.obj.sort.ext = new Array();
            
            $(".sorted").each(function (index) {
                if(this.id!="share"){
                    obj.sort.ext[index] = this.id;
                }
            });
            
            console.log(obj);
            custom_Post('warehouse','sorted_files','main-body',JSON.stringify(obj));
        });
        
        if(!$(".sorting").hasClass("sorted")){
                delete obj.sort.ext;
        }
        
        
        $("input:radio[name=search_mod]").bind('click',function() {

            $("input:radio[name=search_mod]:checked").each(function () {
                obj.search_mod = this.value;

            });

            console.log(obj);
            custom_Post('warehouse','sorted_files','main-body',JSON.stringify(obj));
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
            custom_Post('warehouse','sorted_files','main-body',JSON.stringify(obj));

        });

        var query1 = "";
        $("input:text[name=date1]").bind('change',function(event) {



            query1 = $(this).val();
            console.log(query1);
            obj.sort.date1 = query1;
            query1="";
            custom_Post('warehouse','sorted_files','main-body',JSON.stringify(obj));

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


            custom_Post('warehouse','sorted_files','main-body',JSON.stringify(obj));

            if(obj.sort.date1 == ""){
                delete obj.sort.date1;
            }

        });
        
        
        $("#gallery").bind('click',function() {
            
            

                obj.view_mode = this.id;

            

            console.log(obj);
            custom_Post('warehouse','sorted_files','main-body',JSON.stringify(obj));

        });
        $("#table").bind('click',function() {
            
            

                obj.view_mode = this.id;


            console.log(obj);
            custom_Post('warehouse','sorted_files','main-body',JSON.stringify(obj));

        });
    })


</script>
<div class="sidebar-content">
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
                        <td class='td1'><input type='text' name='date1' style="width:120px;"></td>
                        <td class='td2'> ~ </td>
                        <td class='td3'><input type='text' name='date2' style="width:120px;"></td>
                    </tr>


                    </tbody>
                </table>


            </div>
            <div class="tab-pane fade" id="tab3">
                
    


            </div>
        </div>
    </div>
</div>
