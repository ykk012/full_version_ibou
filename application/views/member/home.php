<script type="text/javascript">
        $(document).ready(function(){
            

            $('#login').bind('click',function() {         //로그인
                var data = {
                    m_id : $('#login_id').val(),
                    m_pwd : $('#login_pwd').val()
                };
                json = JSON.stringify(data);
                var req = createRequestObject();
                //console.log(json);
                
                req.open("POST",  "https://project-board-css-karchev.c9users.io/member/login", true);
                req.setRequestHeader("Content-Type", "application/json");//URL : 경로

                req.onreadystatechange = function() {
                    if (req.readyState == 4) {
                        var response ="";
                        try {
                            response = JSON.parse(req.responseText);
                        } 
                        catch (error) {
                            
                        }
                        console.log(req.responseText);
                        if(typeof response =='boolean') {
                        
                            if(response === false){
                                
                            }
                            
                        }else{
                        //console.log(JSON.parse(localStorage.getItem('loginInfo')));
                            console.log(req.responseText);
                            
                            document.location.href='https://project-board-css-karchev.c9users.io/';
                            
                        }
                    }
                    console.log(req.readyState);
                }
                req.send(json);
            });
              $('#loginToJoin').bind('click',function(){
                var req = createRequestObject();
               

                req.open("POST",  "https://project-board-css-karchev.c9users.io/member/joinpage", true);
                //req.setRequestHeader("Content-Type", "application/json");//URL : 경로

                req.onreadystatechange = function () {
                    if (req.readyState == 4) {
                        
                        $('#login_modal').html(req.responseText);
                    }
                }
                req.send();
                
            });
        })
</script>
<!-- 로그인 wrapper -->
<div id="#login_modal">
    
        <div class="form-group">
            <input type="text" class="form-control" id='login_id' name="memId" placeholder="UserID" value="mgshin">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" id='login_pwd' name="memPwd" placeholder="Password" value="1234">
        </div>
       
       <span style="float:right">
       <button id="login" class="btn btn-primary">Sign In</button>
    
        <button id="loginToJoin"  class="btn btn-default">会員加入</button></br>
        </span>
  
</div>


