<script src='/js/warehouse/ContextMenu.js'></script>
<script src='/js/warehouse/menu.js'></script>
<script type="text/javascript">
    click_menu('main-body','image','input:hidden');

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
    $('a.embed').bind('click',function(e){
            e.preventDefault();
            if($("#preview-content").length){
                $("#preview-content").remove();
            }
            $('#preview').find('.modal-body').html("<iframe id='preview-content' width='600' height='600' ></iframe>")
            
            var file = "https://project-board-css-karchev.c9users.io/download/"+$(this).attr('href');
            var ext = file.substring(file.lastIndexOf('.') + 1);

            if (/^(tiff|pdf|pptx|pps|doc|docx)$/.test(ext)) {
                $("#preview-content").attr("src","https://docs.google.com/viewer?embedded=true&url=" + encodeURIComponent(file));
            
                $('#preview').modal();
            }else{
                $("#preview-content").attr("src",file);
            
                $('#preview').modal();
            }
            
        });


</script>
<?php
foreach($files as $th) {
    if ($th->f_ext == ".jpg" || $th->f_ext == ".png" || $th->f_ext == ".gif") {
        echo "<div class='image'><img src='../download/".$th->f_saved_name."'>";
        echo "<input type='hidden' value=".$th->f_num.">";
        echo "<span>".$th->f_origin_name."</span>";
        echo "</div>";
    }else  if ($th->f_ext==".ppt"|$th->f_ext==".pptx"|$th->f_ext==".tiff"|$th->f_ext==".pdf"|$th->f_ext==".pptx"|$th->f_ext==".pps"|$th->f_ext==".doc"|$th->f_ext==".docx"){
        switch ($th->f_ext) {
            case '.pdf':
            case '.pptx':
            case '.docx':
                echo "<div class='image'><img src='../img/warehouse/".$th->f_ext.$th->f_ext.".png'>";
                break;
            
            default:
                echo "<div class='image'><img src='../img/warehouse/empty.png'>";
                break;
        }
        
        echo "<input type='hidden' value=".$th->f_num.">";
        
        echo "<a href='".$th->f_saved_name."' class='embed' >";
        echo $th->f_origin_name;
        echo "</a>";
        
        echo "</div>";
    }
    else if($th->f_ext == ".txt" ){
        echo "<div class='image'><img src='../img/warehouse/empty.png'>";
        echo "<a href='".$th->f_saved_name."' class='embed' >";
        echo $th->f_origin_name;
        echo "</a>";
        echo "</div>";
    }
    else if($th->f_ext == ".zip" ){
        echo "<div class='image'><img src='../img/warehouse/archive.jpg'>";
        echo "<span>".$th->f_origin_name."</span>";
        echo "</div>";
    }
}
?>