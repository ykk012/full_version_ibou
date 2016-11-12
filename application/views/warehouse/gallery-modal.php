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
</style>
<script src='../../js/warehouse/menu.js'></script>
<script type="text/javascript">
   

    $(function(){
      click_menu_keyword('image','input:hidden');
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
            window.open("https://project-board-css-karchev.c9users.io/warehouse/preview/"+f_num+"/"+f_save, "_blank","width=800 height=600 menubar=no status=no location=no menubar=no toolbar=no"); 
        });
    });
    


</script>
<?php
foreach($files as $th) {
    if ($th->f_ext == ".jpg" || $th->f_ext == ".png" || $th->f_ext == ".gif") {
        echo "<div class='image'><img src='../../img/warehouse/thumbnail/".$th->f_num.".jpg'>";
        echo "<input type='hidden' value=".$th->f_num.">";
        echo "<p>".$th->f_origin_name."</p>";
        echo "<p>生成日: ".$th->f_upload_date."</p>";
        echo "</div>";
    }else  if ($th->f_ext==".ppt"|$th->f_ext==".pptx"|$th->f_ext==".tiff"|$th->f_ext==".pdf"|$th->f_ext==".pptx"|$th->f_ext==".pps"|$th->f_ext==".doc"|$th->f_ext==".docx"){
        switch ($th->f_ext) {
            case '.pdf':
            case '.pptx':
            case '.docx':
                echo "<div class='image'><img src='../../img/warehouse/".$th->f_ext.$th->f_ext.".png'>";
                break;
            
            default:
                echo "<div class='image'><img src='../../img/warehouse/empty.png'>";
                break;
        }
        
        echo "<input type='hidden' value=".$th->f_num.">";
        
        echo "<p>".$th->f_origin_name."</p>";
        echo "<p>生成日: ".$th->f_upload_date."</p>";
        
        echo "</div>";
    }
    else if($th->f_ext == ".txt" ){
        echo "<div class='image'><img src='../../img/warehouse/.txt.txt.png'>";
        echo "<p>".$th->f_origin_name."</p>";
        echo "<p>生成日: ".$th->f_upload_date."</p>";
        echo "</div>";
    }
    else if($th->f_ext == ".zip" ){
        echo "<div class='image'><img src='../../img/warehouse/.zip.zip.png'>";
        echo "<p>".$th->f_origin_name."</p>";
        echo "<p>生成日: ".$th->f_upload_date."</p>";
        echo "</div>";
    }
}
?>