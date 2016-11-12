<script type="text/javascript">
        $(document).ready(function(){
          $('#joinToLogin').bind('click',function(){
                var req = createRequestObject();
               

                req.open("POST",  "https://project-board-css-karchev.c9users.io/member/index", true);
                //req.setRequestHeader("Content-Type", "application/json");//URL : 경로

                req.onreadystatechange = function () {
                    if (req.readyState == 4) {
                        $('#myCarousel').show();
                        $('#bodypage').html('');
                        $('#logpage').html(req.responseText);
                    }
                }
                req.send();
            });
          $('#join').bind('click',function() {
            modData={};
            
            var isError=false;
                
            var blank_pattern = /[\s]/g;
            if($("input:text[name=memId]").parent().find('span').length != 0){
                $("input:text[name=memId]").parent().find('span').remove();
            }
            if($("input:password[name=memPwd]").parent().find('span').length != 0){
                $("input:password[name=memPwd]").parent().find('span').remove();
            }
            if($("input:password[name=confirm]").parent().find('span').length != 0){
                $("input:password[name=confirm]").parent().find('span').remove();
            }
            if($("input:text[name=memName]").parent().find('span').length != 0){
                $("input:text[name=memName]").parent().find('span').remove();
            }
            
            if($('#InputId').prop('value')== ''||$('#InputId').prop('value')== null ){
                $("input:text[name=memId]").after("<span style=' font-size:16px; color:red;'>꼭 입력해야합니다.</span>");
                isError=true;
            }
            else if( $('#InputId').prop('value').search(blank_pattern)> -1 ){
                $("input:text[name=memId]").after("<span style=' font-size:15px; color:red;'>공백이 입력됬습니다.</span>");
                isError=true;
            }
            else{
                modData.m_id=$('#InputId').prop('value');    
            }
            
            
            
            
            if( $('#InputPassword').prop('value') == '' || $('#InputPassword').prop('value') == null ){
                $("input:password[name=memPwd]").after("<span style=' font-size:15px; color:red;'>꼭 입력해야합니다.</span>");
                isError=true;
            }
            else if( $('#InputPassword').prop('value').search(blank_pattern)> -1){
                $("input:password[name=memPwd]").after("<span style=' font-size:15px; color:red;'>공백이 입력됬습니다.</span>");
                isError=true;
            }
            else{
                modData.m_pwd=$('#InputPassword').prop('value');
            }
            
            
            
            
            if($('#InputConfirm').prop('value')== ''||$('#InputConfirm').prop('value')== null ){
                $("input:password[name=confirm]").after("<span style=' font-size:15px; color:red;'>꼭 입력해야합니다.</span>");
                isError=true;
            }
            else if(  $('#InputConfirm').prop('value').search(blank_pattern)> -1){
                $("input:password[name=confirm]").after("<span style=' font-size:15px; color:red;'>공백이 입력됬습니다.</span>");
                isError=true;
            }
            
            
            
            
            
            if($('#InputName').prop('value')== ''||$('#InputName').prop('value')== null ){
                $("input:text[name=memName]").after("<span style=' font-size:15px; color:red;'>꼭 입력해야합니다.</span>");
                isError=true;
            }
            else if(  $('#InputName').prop('value').search(blank_pattern)> -1){
               $("input:text[name=memName]").after("<span style=' font-size:15px; color:red;'>공백이 입력됬습니다.</span>");
                isError=true;
            }
            else{
                modData.m_name=$('#InputName').prop('value');
            }
            
            
            
            
            if($('#InputPassword').prop('value')!=$('#InputConfirm').prop('value')){
                $("input:password[name=confirm]").after("<span style=' font-size:15px; color:red;'>비밀번호가 일치 하지 않습니다.</span>");
                isError=true;
            }
            
            
                
            if(isError){
                return;
            }
            
            data = modData;
            json = JSON.stringify(data);
            var req = createRequestObject();
            console.log(data);

            req.open("POST",  "https://project-board-css-karchev.c9users.io/member/joinus", true);
            req.setRequestHeader("Content-Type", "application/json");//URL : 경로

            req.onreadystatechange = function () {
                if (req.readyState == 4) {
                    
                    $('#myCarousel').show();
                    $('#logpage').html(req.responseText);
                }
                console.log(req.readyState);
            }
            req.send(json);
        });
        })
</script>
<div class="page" id="joinpage">
    <div class="page-header">
        <h1>회원가입 <small>basic form</small></h1>
    </div>
    <div class="col-md-10 col-md-offset-3">
        <fieldset>
            <div class="form-group">
                <!--<label for="InputID">아이디</label>-->
                <input type="text" class="form-control" id="InputId" name="memId" placeholder="아이디" >
                <?php if(isset($existed_id))echo "<span style=' font-size:15px; color:blue;>".$existed_id."</span>"; ?>
            </div>
            <div class="form-group">
                <!--<label for="InputPassword">비밀번호</label>-->
                <input type="password" class="form-control" id="InputPassword" name="memPwd" placeholder="비밀번호">
                <?php if(isset($existed_pwd)){ echo "<span style=' font-size:15px; color:blue;>".$existed_pwd."</span>";}?>
            </div>
            <div class="form-group">
                <!--<label for="InputConfirm">비밀번호 확인</label>-->
                <input type="password" class="form-control" id="InputConfirm" name="confirm" placeholder="비밀번호 확인">
                <p class="help-block">비밀번호 확인을 위해 다시한번 입력 해 주세요</p>

            </div>
            <div class="form-group">
                <!--<label for="username">이름</label>-->
                <input type="text" class="form-control" id="InputName" name="memName"  placeholder="이름을 입력해 주세요">

            </div>

        </fieldset>
        <div class="form-group text-center">
            <button id="join" class="btn btn-info">회원가입</button>
            <button id="joinToLogin" class="btn btn-warning">가입취소</button>
        </div>
    </div>
</div>