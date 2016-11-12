
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
        
       
    });

</script>

<table  class="table table-files" id="view_table">
    
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
                            echo "<span >";
                            echo $th->f_origin_name;
                            echo "</span>";
                            break;
                        case '.jpg':
                        case '.png':
                        case '.gif':
                            echo "<img src='../img/warehouse/image-icon.png'>";
                            echo "<span>";
                            echo $th->f_origin_name;
                            echo "</span>";
                            break;
                        case '.txt':
                            echo "<img src='../img/warehouse/empty-icon.png'>";
                            echo "<span>";
                            echo $th->f_origin_name;
                            echo "</span>";
                            break;
                        case '.mp3':
                            echo "<img src='../img/warehouse/music-icon.png'>";
                            echo "<span>".$th->f_origin_name."</span>";
                            break;
                        case '.zip':
                        case '.rar':
                            echo "<img src='../img/warehouse/zip-icon.png'>";
                            echo "<span>".$th->f_origin_name."</span>";
                            break;
                        
                        default:
                            echo "<img src='../img/warehouse/empty-icon.png'>";
                            echo "<span>".$th->f_origin_name."</span>";
                            break;
                    }
                    
                
                
                ?>
            </td>
            

        </tr>
        <?php
    }
    ?>
    </tbody>
</table>

