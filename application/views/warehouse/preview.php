
<style type="text/css">
    span{
        color:blue;
    }
    span:hover{
        color:red;
    }
    
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script type="text/javascript">
    $(function(){
    var f_save = "<?php echo $f_save; ?>";
    
    var file = "https://project-board-css-karchev.c9users.io/download/"+f_save;
    var ext = file.substring(file.lastIndexOf('.') + 1);
    console.log(file);
    console.log(ext);
    if (/^(tiff|pdf|pptx|pps|doc|docx)$/.test(ext)) {

        $("#preview-content").attr("src","https://docs.google.com/viewer?embedded=true&url=" + encodeURIComponent(file));
    }
    else if(/(txt)|(jpg)/.test(ext)){
        $("#preview-content").attr("src",file);
    }else if(/(unsupported)/.test(ext)){
        $("#preview-content").remove();
    }
    
    })
</script>
<div>
    <div>
        <iframe id='preview-content' width='600' height='400' ></iframe>
    </div>
    <div class="keywords_list">
        <table  class="table table-files" id="view_table">
                
                <tbody class="file-item">
                  <thead>
                    <tr>
                      <th> Workbench 名前</th>
                      <th> Workbench 内容</th>
                      <th> 該当キーワード </th>
                      <th> 添付日 </th>
                        
                    </tr>
                  <tbody>
                    
                  <?php if(count($keywords_list)!=0){
                  foreach($keywords_list as $th) {   ?>
                    <tr class="columns">
                      <td>
                        <span onclick=" window.open('../../../workbench/connect/'+'<?php echo $th->w_num; ?>','abc','width=900 height=700 location=yes '); "><?= $th->w_name ?></a>
                                
                      </td>
                      <td>
                        <?= $th->w_contents ?>
                      </td>
                      <td>
                        <?= $th->k_word ?>
                      </td>
                      <td>
                        <?= $th->k_created_date ?>
                      </td>
                    </tr>
                  <?php }
                  }
                  else { ?>
                    <tr>
                      
                      <td colspan='4' style="text-align:center;">参照されたキーワードがありません</td>
                    </tr>
                  <?php }?>
                  </tbody>
</table>
    </div>
</div>