
<style type="text/css">
.columns-selected{
    border: 1px solid gray;
    background-color:gray;
    margin : 2px;
    z-index:0;
}
</style>
<script src='../../js/warehouse/menu.js'></script>
<script type="text/javascript">
    
    $(function(){
        
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
                            echo "<img src='/img/warehouse/".$th->f_ext.".png' >";
                            echo "<a href='".$th->f_saved_name."' class='embed' id='".$th->f_num."'>";
                            echo $th->f_origin_name;
                            echo "</a>";
                            break;
                        case '.jpg':
                        case '.png':
                        case '.gif':
                            echo "<img src='/img/warehouse/image-icon.png'>";
                            echo "<a href='".$th->f_saved_name."' class='embed' id='".$th->f_num."'>";
                            echo $th->f_origin_name;
                            echo "</a>";
                            break;
                        case '.txt':
                            echo "<img src='/img/warehouse/txt-icon.png'>";
                            echo "<a href='".$th->f_saved_name."' class='embed' id='".$th->f_num."'>";
                            echo $th->f_origin_name;
                            echo "</a>";
                            break;
                        case '.mp3':
                            echo "<img src='/img/warehouse/music-icon.png'>";
                            echo "<a href='' class='embed'  id='".$th->f_num."'>".$th->f_origin_name."</a>";
                            break;
                        case '.zip':
                        case '.rar':
                            echo "<img src='/img/warehouse/.zip.png'>";
                            echo "<a href='' class='embed'  id='".$th->f_num."'>".$th->f_origin_name."</a>";
                            break;
                        
                        default:
                            echo "<img src='/img/warehouse/empty-icon.png'>";
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
