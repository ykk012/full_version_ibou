
<div class="modal animated fadeIn" id="newfolder">
  <div class="modal-dialog">
    <div class="modal-content">
        <form ng-submit="createFolder(temp)">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">
                  <span aria-hidden="true"></span>
              </button>
              <h4 class="modal-title">프로젝트 생성 create project</h4>
            </div>
            <div class="modal-body">
              <label class="radio">프로젝트 이름 project name</label>
              <input class="form-control" autofocus="autofocus">
              <div ng-include data-src="'error-bar'" class="clearfix"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal" >취소 cancel</button>
              <button type="submit" class="btn btn-primary" >생성 create</button>
            </div>
        </form>
    </div>
  </div>
</div>

<div class="modal animated fadeIn" id="friendList_sharing">
  <div class="modal-dialog">
    <div class="modal-content">
       
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">
                  <span aria-hidden="true"></span>
              </button>
              <h4 class="modal-title">파일 공유 sharing with friends</h4>
            </div>
            <div class="sharing-content modal-body" >
              <?php
              foreach($friendlist as $fname){
                 $inputs = "";
                 $inputs .= "<span>".$fname->m_id."</span>";
                 $inputs .= "<input style='position: absolute; left: 180px; width:100px; height: 20px;' type='checkbox' name='friendnames' value='";
                 $inputs .= $fname->m_id;
                 $inputs .= "'>";
                 echo $inputs."<br>";
              }
              ?>
            </div>
            <div class="modal-footer">
              <button  class="btn btn-default" data-dismiss="modal" >취소 cancel</button>
              <button  id="sharing_btn" class="btn btn-primary" data-dismiss="modal" >공유 sharing</button>
            </div>
     
    </div>
  </div>
</div>


<div class="modal animated fadeIn" id="uploadfile">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" >
        
           
           <div style="float:left; width:700px; background-color: #ffffff;">
              
              <?php include $filter; ?>
              
              <div class="warehouses" style="display:inline-block; position:relative; width:300px; float:right;">
              <?php include $table; ?> 
              </div>
           </div>
        

    </div>
  </div>
</div>
<div class="modal animated fadeIn" id="preview">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
       
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">
                  <span aria-hidden="true"></span>
              </button>
              <h4 class="modal-title">파일 프리뷰 preview</h4>
            </div>
            <div class="modal-body" >
              
            </div>
            <div class="modal-footer">
              <button  class="btn btn-default" data-dismiss="modal" >취소 cancel</button>
            </div>
     
    </div>
  </div>
</div>
<script>
$(function(){
        

        document.getElementById('upload_modal_btn').onclick = function(event){
            alert("xxxx");
            custom_Form('warehouse','uploadFile','main-body','upload_modal');
            
        };
       
        
        
        $("input:checkbox[name=friendnames]").bind('click',function(){
          window.obj.friend = new Array();
          $("input:checkbox[name=friendnames]:checked").each(function(index) {
            window.obj.friend[index]=this.value;
            console.log(obj);
            
          });
          
        });
        
        if(!$("input:checkbox[name=ext]").is(":checked")){
                delete obj.friend
        }
        document.getElementById('sharing_btn').onclick = function(event){
            alert("sharing");
            obj.filenames = window.colum_name;
            console.log(obj);
            
            custom_Post_unview('warehouse','shareFile',JSON.stringify(obj));
            
        };
       

});
</script>