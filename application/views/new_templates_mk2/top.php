<!DOCTYPE html>
<html lang="kr">
<head>
  <meta charset="UTF-8">
  <title>IBOU</title>
  
  <!-- base call -->
  <script src="/js/warehouse/scroll.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://project-board-css-karchev.c9users.io/css/template.css"></script>
  
  <!-- @@@dndTree javascript -->
  
  <script src="/js/jquery.contextmenu.r2.packed.js"></script>
  <script src="/js/dndTree.js"></script>
  <script src="/js/d3.min.js"></script>
  
  <!-- @@@textChat Client javascript  -->
  <script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
  <script src="https://project-board-css-karchev.c9users.io/js/textChatClient.js"></script>

  <!-- @@@chatmenu view 관련 javascript start  -->
  <script src="https://project-board-css-karchev.c9users.io/js/BootSideMenu.js"></script>
  <link rel="stylesheet" href="https://project-board-css-karchev.c9users.io/css/BootSideMenu.css">
  <?php if(isset($_SESSION['loginInfo'])){ ?>
    <script>
      var myId = "<?php echo $_SESSION['loginInfo']->m_id; ?>";
      textChatInit();
    </script>
  <?php }; ?>
  
  <script>
  $(document).ready(function() {
    // sidemenu 상에서 표시되는 자신의 id
    if(typeof myId == "undefined" || myId == null){
      
    }else{
      $('.sideMenuMyId').append(
        myId
      )
    }

    // #sidemenu에 sidemenu element를 추가
    $('#sideMenu').BootSideMenu({
      side: "right", // 사이드바가 어느 방향에 붙어서 어느 방향으로 slide 되는지. 이 경우 오른쪽에서 왼쪽으로.
      autoClose: true // 처음 화면이 켜졌을 떄, 사이드바가 닫혀 있는지 열려 있는지.
    });
    $('#ToLoginpage').click(function(evt){
        
        evt.preventDefault(); 
        $('#loginpage').modal();
    });
  })
  </script>
  <!-- @@@chatmenu view 관련 javascript end  -->

</head>
<body>
  <div class="modal animated fadeIn" id="loginpage">
    <div class="modal-dialog">
    <div class="modal-content">
        
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">
                  <span aria-hidden="true"></span>
              </button>
              <h4 class="modal-title"> ログイン  LogIn</h4>
            </div>
            <div class="modal-body">
              <div id="logpage" class="panel-body col-sm-4 clearfix">
                    <?php 
                    
                        include 'application/views/member/home.php';
                    
                    ?>
              </div>
              <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal" >cancel</button>
              
            </div>
        
    </div>
    </div>
</div>
  <!-- navbar  -->
  <nav class="navbar navbar-default nav-beforeLogin">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="https://project-board-css-karchev.c9users.io">IBOU</a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-right">
          
            <?php 
                    if(isset($_SESSION['loginInfo'])) {
                        include 'application/views/member/loginedpage.php';}
                    else{
            ?>
            <li><a href="#">About us</a></li>
            <li><a href="#">About IBOU</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="/workbench/index" id="ToLoginpage"  ><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            <?php
                    }
            ?>
        </ul>
      </div>
    </div>
  </nav>
  
    <nav class="navbar navbar-default nav-afterLogin">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="https://project-board-css-karchev.c9users.io">IBOU</a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="../../workbench">Workbench</a></li>
          <li><a href="https://project-board-css-karchev.c9users.io/warehouse">Warehouse</a></li>
          <li><a href="../../Survey/#/makeHome">Survey</a></li>
          <li><a href="/home"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>
  

  <div id="sideMenu">
    <div class="user sideMenuMyId">
      <img src="http://image.priceprice.k-img.com/ph/images/common/face_japan_01.gif" alt="Esempio" class="img-thumbnail">
    </div>
    <div class="list-group friend-list"></div>
    <div class="video-list text-center" id="videoArea" style="display:none;">
    </div>
    <div class="log-list" id="logArea" style="display:none;">
      <div id="logTextArea">
      </div>
      <div class="form-group roomChatText">
        <label for="inputdefault">input text-chat :</label>
        <input class="form-control" id="roomChatInput" type="text">
      </div>
			<!--<input type="text" id="roomChatText"><input type="submit" value="기록" id="roomChatInput"><br/>-->
			<!--<button id="start_button">STT START</button>-->
    </div>
  </div>