<script type="text/javascript">
    function ajax_view(mode){
        obj.view_mode = mode;
        console.log(obj);
        $('.main-body').unbind('contextmenu'); $('#jqContextMenu').unbind(); $('#context_shadow').unbind();
        $('#context_shadow').remove(); $('#jqContextMenu').remove();
        custom_Post('warehouse','sorted_files','main-body',JSON.stringify(obj));
    }

</script>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        
        <div id="navbar" class="navbar-collapse collapse">
            <div class="navbar-form">
                
                <div class="navbar-right">
                    <button class="btn btn-default btn-sm" data-toggle="modal" data-target="#newfolder" >
                        <i class="glyphicon glyphicon-plus"></i> 프로젝트 생성 NEW PROJECT
                    </button>
                    <button class="btn btn-default btn-sm" data-toggle="modal" data-target="#uploadfile" >
                        <i class="glyphicon glyphicon-upload"></i> 업로드 UPLOAD
                    </button>
                    

                    <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropDownMenuLang" data-toggle="dropdown" aria-expanded="true">
                        <i class="glyphicon glyphicon-globe"></i>보기 형태 screen type<span class="caret"></span>
                    </button>
                    
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropDownMenuLang">
                        <li role="presentation"><a  role="menuitem" tabindex="-1" onclick="ajax_view('gallery');" >이미지로보기</a></li>
                       
                        <li role="presentation"><a role="menuitem" tabindex="-1"  onclick="ajax_view('table');" >게시판보기</a></li>

                    </ul>

                    
                    <a href="https://project-board-css-karchev.c9users.io"><button class="btn btn-default btn-sm" >home</button></a></i>
                    
            </div>
        </div>
    </div>
</nav>