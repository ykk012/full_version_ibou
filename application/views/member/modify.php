<script type="text/javascript">
        $(document).ready(function(){
           $('#modify').bind('click',function() {
                var modData={};
                var isError=false;
                
                var blank_pattern = /[\s]/g;
                
                
                if($("input:password[name=memPwd]").parent().find('span').length != 0){
                    $("input:password[name=memPwd]").parent().find('span').remove();
                }
                if($("input:password[name=confirm]").parent().find('span').length != 0){
                    $("input:password[name=confirm]").parent().find('span').remove();
                }
                if($("input:text[name=memName]").parent().find('span').length != 0){
                    $("input:text[name=memName]").parent().find('span').remove();
                }
                
                
                if($('#modPassword').prop('value').search(blank_pattern)> -1){
                    $("input:password[name=memPwd]").after("<span style=' font-size:15px; color:red;'>공백이 입력됬습니다.</span>");
                    isError=true;
                }else{
                    if( $('#modPassword').prop('value')!= ''||$('#modPassword').prop('value')!= null){
                        modData.m_pwd=$('#modPassword').prop('value');
                    }
                }
                
                
                
                if($('#modConfirm').prop('value').search(blank_pattern)> -1){
                    $("input:password[name=confirm]").after("<span style=' font-size:15px; color:red;'>공백이 입력됬습니다.</span>");
                    isError=true;
                }
                
                
                
                if($('#modName').prop('value').search(blank_pattern)> -1){
                    $("input:password[name=memName]").after("<span style=' font-size:15px; color:red;'>공백이 입력됬습니다.</span>");
                    isError=true;
                }else{
                    if(  $('#modName').prop('value')!= ''||$('#modName').prop('value')!= null ){
                        modData.m_name=$('#modName').prop('value');
                    }
                }
                
                
                
                if($('#modPassword').prop('value')!=$('#modConfirm').prop('value')){
                    $("input:password[name=confirm]").after("<span style=' font-size:15px; color:red;'>비밀번호가 일치 하지 않습니다.</span>");
                    isError=true;
                }
                
                if(isError){
                    return;
                }
                
                
                json = JSON.stringify(modData);
                var req = createRequestObject();
                console.log(modData);

                req.open("POST",  "https://project-board-css-karchev.c9users.io/member/modifyMember", true);
                req.setRequestHeader("Content-Type", "application/json");//URL : 경로

                req.onreadystatechange = function () {
                    if (req.readyState == 4) {
                       
                        $('#bodypage').html(req.responseText);
                    }
                    console.log(req.readyState);
                }
                req.send(json);
            });
            
            $('#modifyToInfo').bind('click',function(){
                var req = createRequestObject();
               

                req.open("POST",  "https://project-board-css-karchev.c9users.io/member/infopage", true);
                //req.setRequestHeader("Content-Type", "application/json");//URL : 경로

                req.onreadystatechange = function () {
                    if (req.readyState == 4) {
                
                        $('#bodypage').html(req.responseText);
                    }
                }
                req.send();
            });
        })
</script>
<div class="page" id="modifypage">
    <div class="page-header">
        <h1>회원수정 <small>basic form</small></h1>
    </div>

    <div class="col-md-10 col-md-offset-3">
        <fieldset>
            <div class="form-group">
                <label for="InputEmail">아이디</label>
                <input type="text" class="form-control" id="modID" name="memId" value="<?php echo $memberInfo->m_id; ?>" readonly >
            </div>
            <div class="form-group">
                <label for="InputPassword1">비밀번호</label>
                <input type="password" class="form-control" id="modPassword" name="memPwd" placeholder="비밀번호">
                <?php if(isset($existed_pwd)) {echo "<span style=' font-size:15px; color:blue;'>".$existed_pwd."<span>"; }?>
            </div>
            <div class="form-group">
                <label for="InputPassword2">비밀번호 확인</label>
                <input type="password" class="form-control" id="modConfirm" name="confirm" placeholder="비밀번호 확인">
                <p class="help-block">비밀번호 확인을 위해 다시한번 입력 해 주세요</p>

            </div>
            <div class="form-group">
                <label for="username">이름</label>
                <input type="text" class="form-control" id="modName" name="memName"  value="<?php echo $memberInfo->m_pwd; ?>">
                <button id="modify" class="btn btn-info">수정</button>
                <button id="modifyToInfo" class="btn btn-warning">취소</button>
            </div>
        </fieldset>



        
    </div>
</div>