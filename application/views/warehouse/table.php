
<script src='/js/warehouse/ContextMenu.js'></script>
<script src='/js/warehouse/menu.js'></script>

<script type="text/javascript">
    click_menu('main-body','columns','td:first input:hidden');
    $(function(){
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
            
            var f_save =$(this).attr('href');
            
            obj.f_num = $(this).prop('id');
            
            var json = JSON.stringify(obj);
            var req = createRequestObject();
   
            console.log(json);
            req.open("POST",  "../warehouse/keywordsInFile", true);
            req.setRequestHeader("Content-Type", "application/json");//URL : 경로
    
            req.onreadystatechange = function () {
                if (req.readyState == 4) {
                    $(".keywords_list").html(req.responseText);
                    if(f_save != ""){
                        
                        $('#preview').find('.modal-body').html("<iframe id='preview-content' width='600' height='400' ></iframe>");
                        var file = "https://project-board-css-karchev.c9users.io/download/"+f_save;
                        var ext = file.substring(file.lastIndexOf('.') + 1);
                        console.log(encodeURIComponent(file));
                        if (/^(tiff|pdf|pptx|pps|doc|docx)$/.test(ext)) {
                       
                            $("#preview-content").attr("src","https://docs.google.com/viewer?embedded=true&url=" + encodeURIComponent(file));
                        }
                        else{
                            $("#preview-content").attr("src",file);
                        }
                    }
                    
                    $('#preview').modal();
                    
                }
            }
            req.send(json);
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
                            echo "<img src='../img/warehouse/".$th->f_ext.".png' >";
                            echo "<a href='".$th->f_saved_name."' class='embed' id='".$th->f_num."'>";
                            echo $th->f_origin_name;
                            echo "</a>";
                            break;
                        case '.jpg':
                        case '.png':
                        case '.gif':
                            echo "<img src='../img/warehouse/image-icon.png'>";
                            echo "<a href='".$th->f_saved_name."' class='embed' id='".$th->f_num."'>";
                            echo $th->f_origin_name;
                            echo "</a>";
                            break;
                        case '.txt':
                            echo "<img src='../img/warehouse/txt-icon.png'>";
                            echo "<a href='".$th->f_saved_name."' class='embed' id='".$th->f_num."'>";
                            echo $th->f_origin_name;
                            echo "</a>";
                            break;
                        case '.mp3':
                            echo "<img src='../img/warehouse/music-icon.png'>";
                            echo "<a href='' class='embed'  id='".$th->f_num."'>".$th->f_origin_name."</a>";
                            break;
                        case '.zip':
                        case '.rar':
                            echo "<img src='../img/warehouse/zip-icon.png'>";
                            echo "<a href='' class='embed'  id='".$th->f_num."'>".$th->f_origin_name."</a>";
                            break;
                        
                        default:
                            echo "<img src='../img/warehouse/empty-icon.png'>";
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

