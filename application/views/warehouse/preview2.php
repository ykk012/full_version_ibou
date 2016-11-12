<div class="modal animated fadeIn" id="preview">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
       
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">
                  <span aria-hidden="true"></span>
              </button>
              <h4 class="modal-title">파일 프리뷰 sharing with friends</h4>
            </div>
            <div class="modal-body" >
              <iframe id="preview-content" width="600" height="600" src="https://docs.google.com/viewer?embedded=true&url=<?=rawurlencode ?>"></iframe>
              <table  class="table table-files" id="view_table">
                
                <tbody class="file-item">
                  <thead>
                    <tr>
                      <th> 워크벤치 이름</th>
                      <th> 워크벤치 내용</th>
                      <th> 해당 키워드</th>
                      <th> 첨부날짜 </th>
                        
                    </tr>
                  <tbody>
                    
                  <?php foreach($keywords_list as $th) {   ?>
                    <tr class="columns">
                      <td>
                        <?= $th->w_name ?>
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
                  <?php } ?>
                  </tbody>
                </table>
            </div>
            <div class="modal-footer">
              <button  class="btn btn-default" data-dismiss="modal" >취소 cancel</button>
            </div>
     
    </div>
  </div>
</div>
$('#preview').find('.modal-body').html("<iframe id='preview-content' width='600' height='600' ></iframe>");
            
            var file = "https://project-board-css-karchev.c9users.io/download/"+$(this).attr('href');
            var ext = file.substring(file.lastIndexOf('.') + 1);

            if (/^(tiff|pdf|pptx|pps|doc|docx)$/.test(ext)) {
                $("#preview-content").attr("src","https://docs.google.com/viewer?embedded=true&url=" + encodeURIComponent(file));
            
                $('#preview').modal();
            }else{
                $("#preview-content").attr("src",file);
            
                $('#preview').modal();
            }