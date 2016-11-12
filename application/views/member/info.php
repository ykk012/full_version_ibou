<script type="text/javascript">
        $(document).ready(function(){
          $('#infoToModify').bind('click',function(){
                

                var req = createRequestObject();
               

                req.open("POST",  "https://project-board-css-karchev.c9users.io/member/modifypage", true);
                //req.setRequestHeader("Content-Type", "application/json");//URL : 경로

                req.onreadystatechange = function () {
                    if (req.readyState == 4) {
                        
                        $('#bodypage').html(req.responseText);
                    }
                }
                req.send();
            });
            
            $('#infoToLogined').bind('click',function(){
                var req = createRequestObject();
               

                req.open("POST",  "https://project-board-css-karchev.c9users.io/member/loginedpage", true);
                //req.setRequestHeader("Content-Type", "application/json");//URL : 경로

                req.onreadystatechange = function () {
                    if (req.readyState == 4) {
                        $('#infopage').hide();
                        $('#myCarousel').show();
                        $('#logpage').html(req.responseText);
                    }
                }
                req.send();
            });
            
            $('#withdraw').bind('click', function() { //회원탈퇴
                
                var req = createRequestObject();
                

                req.open("POST", "https://project-board-css-karchev.c9users.io/member/withdrawMember", true);
                

                req.onreadystatechange = function() {
                    if (req.readyState == 4) {
                        
                        alert("탈퇴성공");
                    }
                }
                req.send();
            });
        })
</script>
<div class="page" id="infopage">
    <div class="page-header">
        <h1>회원 정보<small>basic form</small></h1>
    </div>

            <div class="form-group">
                <label for="InputEmail">아이디</label>
                <input type="text" class="form-control" id="infoID" name="memId" value="<?php echo $memberInfo->m_id; ?>" readonly >
            </div>
            <div class="form-group">
                <label for="username">이름</label>
                <input type="text" class="form-control" id="infoName" name="memName" value="<?php echo $memberInfo->m_name; ?>" readonly>

                <button  id="infoToModify" class="btn btn-info">회원수정</button>
                <button  id="withdraw" class="btn btn-warning">탈퇴하기</button>
                <button  id="infoToLogined" class="btn btn-warning">뒤로가기</button>
            </div>
    
</div>