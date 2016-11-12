<script>
        $(document).ready(function(){
           $('#loginedToInfo').bind('click',function(){
                alert("cl");

                var req = createRequestObject();
               

                req.open("POST",  "https://project-board-css-karchev.c9users.io/member/infopage", true);
                //req.setRequestHeader("Content-Type", "application/json");//URL : 경로

                req.onreadystatechange = function () {
                    if (req.readyState == 4) {
                        console.log(req.responseText);
                        $('#myCarousel').hide();
                        $('#bodypage').html(req.responseText);
                    }
                }
                req.send();
                
            });
            $('#logout').bind('click',function(e) {        //로그아웃
                e.preventDefault();
                var req = createRequestObject();
                req.open("POST",  "https://project-board-css-karchev.c9users.io/member/logout", true);
               

                req.onreadystatechange = function () {
                    if (req.readyState == 4) {
                       
                        document.location.href="https://project-board-css-karchev.c9users.io/";
                    }
                    console.log(req.readyState);
                }
                req.send();
                
            });
            
            
          
        })
        
</script>
<div class="page" id="loginedpage" style="display:inline-block;">
    
    <ul class="nav navbar-nav">
        <li><a href="https://project-board-css-karchev.c9users.io/warehouse">Warehouse</a></li>
        <li><a href="../../workbench">Workbench</a></li>
        <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">登録情報<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="#" id="loginedToInfo">会員情報</a></li>
                    <li><a href="/Friend">友たち探索</a></li>
                    <li><a href="/Team">チームページ</a></li>
                  
                </ul>
        </li>
        <li><a href="/home" id="logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>
    
    
   
</div>
