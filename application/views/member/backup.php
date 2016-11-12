
    <link href="/css/warehouse/bootstrap.min.css" rel="stylesheet" />
    <script src="/js/jquery-2.2.3.min.js"></script>
    <script src="/js/warehouse/scroll.js"></script>
    <script src="/js/warehouse/bootstrap.js"></script>

    <script>
        
        $(document).ready(function(){
            $('.page').each(function(){
                $(this).css('display','inline-block');
                $(this).hide();
            });
        
            $('#login').bind('click',function() {         //로그인
                var data = {
                    m_id : $('#login_id').val(),
                    m_pwd : $('#login_pwd').val()
                };
                json = JSON.stringify(data);
                var req = createRequestObject();
                console.log(json);

                req.open("POST",  "https://project-board-css-karchev.c9users.io/member/login", true);
                req.setRequestHeader("Content-Type", "application/json");//URL : 경로

                req.onreadystatechange = function () {
                    if (req.readyState == 4) {
                        var get_data = JSON.parse(req.responseText);
                        console.log(get_data);
                        localStorage.setItem('loginInfo',JSON.stringify(get_data));
                        console.log(JSON.parse(localStorage.getItem('loginInfo')));
                        $('#loginpage').hide();
                        $('#loginedpage').show();
                        if(document.getElementById('loginuser')){$('#loginuser').remove();}
                        $('#loginedpage').append("<p id='loginuser'>"+get_data.m_name+'가 로그인하셨습니다</p>');
                        
                    }
                    console.log(req.readyState);
                }
                req.send(json);
            })

            $('#logout').bind('click',function() {        //로그아웃
                localStorage.removeItem('loginInfo');
                var req = createRequestObject();
                req.open("POST",  "https://project-board-css-karchev.c9users.io/member/logout", true);
               

                req.onreadystatechange = function () {
                    if (req.readyState == 4) {
                        $('#loginedpage').hide();
                $('#loginpage').show();
                    }
                    console.log(req.readyState);
                }
                req.send();
                
            });
            
            $('#join').bind('click',function() {
                if($('#InputPassword').val() != $('#InputConfirm').val() ){
                    return;
                }
                data = {
                    m_id : $('#InputId').val(),
                    m_pwd : $('#InputPassword').val(),
                    m_name : $('#InputName').val()
                };
                json = JSON.stringify(data);
                var req = createRequestObject();
                console.log(json);

                req.open("POST",  "https://project-board-css-karchev.c9users.io/member/joinus", true);
                req.setRequestHeader("Content-Type", "application/json");//URL : 경로

                req.onreadystatechange = function () {
                    if (req.readyState == 4) {
                        $('#joinpage').hide();
                        $('#loginpage').show();
                    }
                }
                req.send(json);

            });
            
            $('#withdraw').bind('click',function() {        //회원탈퇴
                var loginInfo = JSON.parse(localStorage['loginInfo']);
                data = {
                    m_num : loginInfo.m_num
                };
                json = JSON.stringify(data);
                var req = createRequestObject();
                console.log(json);

                req.open("POST",  "https://project-board-css-karchev.c9users.io/member/withdrawMember", true);
                req.setRequestHeader("Content-Type", "application/json");//URL : 경로

                req.onreadystatechange = function () {
                    if (req.readyState == 4) {
                        $('#infopage').hide();
                        $('#loginpage').show();
                        alert("탈퇴성공");
                    }
                }
                req.send(json);
            })

            $('#loginedToInfo').bind('click',function(){
                $('#loginedpage').hide();
                $('#infopage').show();
                var loginInfo = JSON.parse(localStorage['loginInfo']);
                console.log(loginInfo);
                $('#infoID').attr('value',loginInfo.m_id);
                $('#infoName').attr('value',loginInfo.m_name);
            });
            
            $('#infoToModify').bind('click',function(){
                $('#infopage').hide();
                $('#modifypage').show();
                var loginInfo = JSON.parse(localStorage['loginInfo']);
                $('#modID').attr('value',loginInfo.m_id);
                $('#modName').attr('value',loginInfo.m_name);
            });

            $('#modify').bind('click',function() {
                modData={};
                if($('#modPassword').val()!=$('#modConfirm').val()){
                    return;
                }
                if($('#modPassword').val().indexOf("")!= -1){
                    modData.m_pwd=$('#modPassword').val();
                }
                if($('#modName').val().indexOf("")!= -1){
                    modData.m_name=$('#modName').val();
                }
                modData.m_num=JSON.parse(localStorage.getItem('loginInfo')).m_num;
                data = modData;
                json = JSON.stringify(data);
                var req = createRequestObject();
                console.log(data);

                req.open("POST",  "https://project-board-css-karchev.c9users.io/member/modifyMember", true);
                req.setRequestHeader("Content-Type", "application/json");//URL : 경로

                req.onreadystatechange = function () {
                    if (req.readyState == 4) {
                        var loginInfo=JSON.parse(req.responseText);
                        localStorage.setItem('loginInfo',JSON.stringify(loginInfo));
                        $('#modifypage').hide();
                        $('#infopage').show();
                        alert("수정 완료");
                    }
                    console.log(req.readyState);
                }
                req.send(json);
            });
            
            $('#loginToJoin').bind('click',function(){
                $('#loginpage').hide();
                $('#joinpage').show();
                
            });
            
            $('#loginedToInfo').bind('click',function(){
                $('#loginedpage').hide();
                $('#infopage').show();
            });

            $('#modifyToInfo').bind('click',function(){
                $('#modifypage').hide();
                $('#infopage').show();
            });

            $('#joinToLogin').bind('click',function(){
                $('#joinpage').hide();
                $('#loginpage').show();
            });

            $('#infoToLogined').bind('click',function(){
                $('#infopage').hide();
                $('#loginedpage').show();
            });
            
            if (localStorage.getItem('loginInfo') === undefined || localStorage.getItem('loginInfo') === null || localStorage.getItem('loginInfo').length === 0){
                $('#loginpage').show();
            }else{
                $('#loginedpage').show();
                $('#loginedpage').append("<h3 id='loginuser'>"+JSON.parse(localStorage.getItem('loginInfo')).m_name+' 로그인하셨습니다</h3>');
            }
        });

</script>
    
<!-- 로그인 wrapper -->
<div class="page" id="loginpage">
    <fieldset>
        <div class="form-group">
            <input type="text" class="form-control" id='login_id' name="memId" placeholder="UserID">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" id='login_pwd' name="memPwd" placeholder="Password">
        </div>
        <button id="login" class="btn btn-default">Sign In</button>
    </fieldset>
    <button id="loginToJoin"  class="btn btn-default">회원가입</button></br>
</div>
<div class="page" id="loginedpage">
    
    <a href="/Friend"><button class="btn btn-default">친구찾기</button></a>
    <a href="/Team"><button class="btn btn-default">팀페이지</button></a>
    <button id="loginedToInfo" class="btn btn-default">회원정보</button>
    <button id="logout" class="btn btn-warning">로그아웃</button>
</div>

<!-- 회원정보 view wrapper -->
<div class="page" id="infopage">
    <div class="page-header">
        <h1>회원 정보<small>basic form</small></h1>
    </div>

    <div class="col-md-10 col-md-offset-3">
        <fieldset>
            <div class="form-group">
                <label for="InputEmail">아이디</label>
                <input type="text" class="form-control" id="infoID" name="memId"  readonly >
            </div>
            <div class="form-group">
                <label for="username">이름</label>
                <input type="text" class="form-control" id="infoName" name="memName" readonly>

                <button  id="infoToModify" class="btn btn-info">회원수정</button>
                <button  id="withdraw" class="btn btn-warning">탈퇴하기</button>
                <button  id="infoToLogined" class="btn btn-warning">뒤로가기</button>
            </div>
        </fieldset>
    </div>
</div>


<!-- 회원가입 wrapper -->
<div class="page" id="joinpage">
    <div class="page-header">
        <h1>회원가입 <small>basic form</small></h1>
    </div>
    <div class="col-md-10 col-md-offset-3">
        <fieldset>
            <div class="form-group">
                <!--<label for="InputID">아이디</label>-->
                <input type="text" class="form-control" id="InputId" name="memId" placeholder="아이디" >
            </div>
            <div class="form-group">
                <!--<label for="InputPassword">비밀번호</label>-->
                <input type="password" class="form-control" id="InputPassword" name="memPwd" placeholder="비밀번호">

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
<!-- 회원가입 wrapper -->


<!-- 회원정보수정 wrapper -->
<div class="page" id="modifypage">
    <div class="page-header">
        <h1>회원수정 <small>basic form</small></h1>
    </div>

    <div class="col-md-10 col-md-offset-3">
        <fieldset>
            <div class="form-group">
                <label for="InputEmail">아이디</label>
                <input type="text" class="form-control" id="modID" name="memId" value="" readonly >
            </div>
            <div class="form-group">
                <label for="InputPassword1">비밀번호</label>
                <input type="password" class="form-control" id="modPassword" name="memPwd" placeholder="비밀번호">

            </div>
            <div class="form-group">
                <label for="InputPassword2">비밀번호 확인</label>
                <input type="password" class="form-control" id="modConfirm" name="confirm" placeholder="비밀번호 확인">
                <p class="help-block">비밀번호 확인을 위해 다시한번 입력 해 주세요</p>

            </div>
            <div class="form-group">
                <label for="username">이름</label>
                <input type="text" class="form-control" id="modName" name="memName"  value="">
                <button id="modify" class="btn btn-info">수정</button>
                <button id="modifyToInfo" class="btn btn-warning">취소</button>
            </div>
        </fieldset>



        
    </div>
</div>
<!-- 회원정보수정 wrapper -->

