<style>
    .navbar {
      padding-top: 15px;
      padding-bottom: 15px;
      border: 0;
      border-radius: 0;
      margin-bottom: 0;
      font-size: 12px;
      letter-spacing: 5px;
    }
    .navbar-nav  li a:hover {
      color: #1abc9c !important;
    }
    footer{
      background-color: #2f2f2f; /* Black Gray */
      color: #fff;
      padding-top: 40px;
      padding-bottom: 40px;
      bottom:0;
      position:fixed;
      height:10%;
      width:100%;
    }
    .ui-icon-circle-triangle-w{
       width:0; height:0; border-style:solid; border-width:10px;
      border-color:transparent grey transparent transparent;
      
    }
    .ui-icon-circle-triangle-e{
       width:0; height:0; border-style:solid; border-width:10px;
      border-color:transparent transparent transparent grey;  
    }
</style>

<link rel="stylesheet" type="text/css" href="/css/workbench.css">

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="../css/chat.css">
<script type="text/javascript" src="/js/jquery-2.2.3.min.js"></script>
<script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
<script type="text/javascript">
  /*$('nav > li a').bind('click',function(){
    if(!localStorage.getItem('loginInfo')){
      
    }
  });*/
  
</script>
<nav class="navbar navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"><a href="/warehouse">I·Warehouse</a></span>
          <span class="icon-bar"><a href="../../workbench">I·Workbench</a></span>
          <span class="icon-bar"><a href="../../Survey">I·Survey</a></span>
        </button>
        <a class="navbar-brand" href="https://project-board-css-karchev.c9users.io/">IBOU</a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="/warehouse">I·Warehouse</a></li>
          <li><a href="../../workbench">I·Workbench</a></li>
          <li><a href="../../Survey/#/makeHome">I·Survey</a></li>
        </ul>
      </div>
    </div>
</nav>