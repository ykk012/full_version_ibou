
<?php 
  error_reporting(0);
  // php's session data set to javascript
  if($_SESSION){
    $data=$_SESSION['loginInfo'];
    $m_name=$data->m_name;
  }
?>

<html ng-app="thinkLibrary">
<head>
  <meta charset="utf8">
  <!--<script src="components/login/loginService.js"></script>-->
  <!--  <script src="components/login/sessionService.js"></script>-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
  <script src="/js/video-chat.js"></script> 
  <script src="/js/stt-client.js"></script>
  <script src="/js/jquery.contextmenu.r2.packed.js"></script>
  <script src="//cdn.temasys.com.sg/adapterjs/0.13.x/adapter.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="/css/project_temp.css">
  <!-- text-chat css (슬라이드 메뉴 등) -->
  <link rel="stylesheet" href="/css/text-chat.css">
  <link rel="stylesheet" type="text/css" href="/css/workbench.css">
  <link href="/css/warehouse/jquery-ui.css" rel="stylesheet">
  
  <script>
  // textchat을 위한 구간
  // 자신의 아이디
  var myId;
  // $m_name은 자신의 아이디(세션 데이터로부터 추출)
  <?php if($m_name){ ?>
    myId = '<?php echo $m_name ;?>';
  <?php } ?>  
    $(document).ready(function() {
      if(myId){
        $('.myId').append(myId)
      }
      $('#test').BootSideMenu({
        side: "right", // left or right
        autoClose: true // auto close when page loads
      });
    })
  </script>
  <!-- sidemenu 컨트롤을 위한 기능 -->
  <script src="/js/BootSideMenu.js"></script>
  <script src="/js/warehouse/scroll.js"></script>
  <script src="/js/member/mysessionstorage.js"></script>
  <!-- 채팅창 팝업, text-chat을 위한 socket 서버와의 통신 등을 위한 기능 -->
  <script src="/js/text-chat.js"></script>
  <script src="/js/dndTree.js"></script>
  <script src="/js/d3.min.js"></script>
  <script src="/js/warehouse/jquery-ui.js"></script>
  <script src="/js/warehouse/jquery-ui-timepicker-addon.js"></script>
  
  
</head>

<body>
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="https://project-board-css-karchev.c9users.io/">IBOU</a>
      </div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="https://project-board-css-karchev.c9users.io/warehouse">I·Warehouse</a></li>
          <li><a href="../../workbench">I·Workbench</a></li>
          <li><a href="../../Survey/#/makeHome">I·Survey</a></li>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Info Modify<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#">Team Info</a></li>
              <li><a href="#">Friend Info</a></li>
              <li><a href="#">User Info</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  
  <div id="test">
    <div class="user myId">
      <img src="http://image.priceprice.k-img.com/ph/images/common/face_japan_01.gif" alt="Esempio" class="img-thumbnail">
    </div>
    <div class="list-group friend-list">

    </div>
    <div class="video-list" id="videoArea" style="display:none;">
      <p>video</p>
    </div>
    <div class="log-list" id="logArea" style="display:none;">
      <div id="logTextArea">
      </div>
      <div class="form-group roomChatText">
        <label for="inputdefault">input log :</label>
        <input class="form-control" id="roomChatInput" type="text">
        <br/>
        <label for="inputdefault">input log by voice :</label>
        <button type="button" class="btn btn-default btn-block">voice on</button>
      </div>
			<!--<input type="text" id="roomChatText"><input type="submit" value="기록" id="roomChatInput"><br/>-->
			<!--<button id="start_button">STT START</button>-->
    </div>
  </div>
  