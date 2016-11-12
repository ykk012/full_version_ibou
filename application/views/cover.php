<!DOCTYPE html>
<html>

<head>
  <meta charset="utf8">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.7/jquery.slimscroll.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.fullpage/2.5.9/jquery.fullPage.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/jquery.fullpage/2.5.9/jquery.fullPage.min.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="/css/cover.css">
  
  <script type="text/javascript">
		$(document).ready(function() {
		  
			$('#fullpage').fullpage({
        anchors: ['firstPage', 'secondPage', '3rdPage', 'lastPage'],
				css3: true,
        menu: '#menu',
				scrollingSpeed: 1000
			});
		});
		
		function redirect(){
		  
		}
	</script>
</head>

<body>
  <div id="fullpage">
    
    <div class="section" id="section0">
    <!-- 정 중앙 -->
    <div class="row">
      <div class="col-md-offset-5 col-md2">
        <img id="/img/covericon1" src="/img/cover/icon1.png"/>
      </div>
    </div>
    <div class="row">
      <div id="textArea" class="col-md-offset-4">
        <h4>IBOU</h4>
        <blockquote>
        <p>설명설명설명설명설명설명설명</p>
        <footer>간지 타이포그래프</footer>
        </blockquote>
      </div>
    </div>
    <div class="row">
      <div class="col-md-offset-5 col-md-2">
        <p class="text-center">if u want more</p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-offset-5 col-md-2">
        <img src="/img/cover/scrollDownicon.png"/>
      </div>
    </div>
    </div>
    
    <div class="section" id="section1">
      
    <div class="row">
        <div id="icon2" class="col-md-offset-2 col-md-1"></div>
        <div class="col-md-9">
          <h4>IBOU</h4>
          <blockquote>
          <p>설명설명설명설명설명설명설명</p>;
          <footer>간지 타이포그래프</footer>
        </blockquote>
        </div>
    </div>
    <div class="row section1-rows">
        <div id="icon3" class="col-md-offset-2 col-md-1"></div>
        <div class="col-md-9">
          <h4>IBOU</h4>
          <blockquote>
          <p>설명설명설명설명설명설명설명</p>
          <footer>간지 타이포그래프</footer>
        </div>
    </div>
    <div class="row section1-rows">
        <div id="icon4" class="col-md-offset-2 col-md-1"></div>
        <div class="col-md-9">
          <h4>IBOU</h4>
          <blockquote>
          <p>설명설명설명설명설명설명설명</p>
          <footer>간지 타이포그래프</footer>
        </div>
    </div>
    
    <div class="row">
      <div class="col-md-offset-5 col-md-1">
        <button onclick="location.href=' https://project-board-css-karchev.c9users.io/home/new_temp'" type="button" class="btn btn-default btn-lg">Join!</button>
      </div>
    </div>
    
    </div>
    
  </div>
</body>

</html>