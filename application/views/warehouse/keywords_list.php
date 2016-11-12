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
                        <a href="../workbench/connect/<?=$th->w_num; ?>" ><?= $th->w_name ?></a>
                        
                        
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
                      
                      <td colspan='4' style="text-align:center;">参照されたキーワードがありません음</td>
                    </tr>
                  <?php }?>
                  </tbody>
</table>