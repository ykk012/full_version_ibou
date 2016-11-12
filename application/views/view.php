<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script src="https://project-board-css-karchev.c9users.io/js/navbar-controll.js"></script>
<link rel="stylesheet" type="text/css" href="/css/workbench.css">
	<script>
    
    var clientid = <?php echo $_SESSION['loginInfo']->m_num;?>;
    var nickname = '<?php echo $_SESSION['loginInfo']->m_id;?>';
    var workbenchList;

    $(document).ready(function(){
    	$(".userID").text(nickname);
        $("#list-container").show();
        
        getWorkbenchList();

		$('#titleSubmit').click(function(){
			var title = $('#wbTitle').val();
			
			var data = { 'm_num' : clientid, 'w_name' : title};
			
			console.log(data);
			
			$.ajax({
				url: "/workbench/createWB/",
				data: data,
				method: "post",
				success: function(data){
					$("#selfListContainer").empty();
					$("#friendListContainer").empty();
					$("teamListContainer").empty();
					
					getWorkbenchList();
				},
				error: function(){
					window.alert("Error!");
				}
			});
		});
		
		// $('#myModal').modal('toggle');

    });

	function getWorkbenchList(){
		$.ajax({
			url: "https://project-board-css-karchev.c9users.io/workbench/getWorkbenchList/"+clientid,
			dataType: 'json',
			success: function(data){
				console.log(data);
				workbenchList = data.personal;
				teamWorkbenchList = data.team;
				
				// 자신이 작성한 워크벤치 및 친구에게 개인적으로 공유 받은 워크벤치 출력
				for(var i = 0 ; i < workbenchList.length ; i++){
					if(workbenchList[i].m_id == nickname){
						$("<div></div>").appendTo("#selfListContainer")
						.addClass("contents col-md-4")
						.attr("id","pwb"+i);
					}else{
						$("<div></div>").appendTo("#friendListContainer")
						.addClass("contents col-md-4")
						.attr("id","pwb"+i);
					}
				
					$("<p></p>").appendTo("#pwb"+i)
					.text("Name : " + workbenchList[i].w_name);
					$("<p></p>").appendTo("#pwb"+i)

					.text("Author : " + workbenchList[i].m_id);
					$("<p></p>").appendTo("#pwb"+i)
					.text("C_Date : " + workbenchList[i].w_created_date);
					$("<span></span>").appendTo("#pwb"+i)
					.css('float','right');
					$("<button></button").appendTo("#pwb"+i+' > span')
					.addClass('btn btn-info btn-sm')
					.attr("id","pif"+i)
					.text('詳細');
					if(workbenchList[i].m_id == nickname){
						$('<button></button>').appendTo('#pwb'+i+' > span')
						.addClass('btn btn-default btn-sm')
						.attr("id","w"+workbenchList[i].w_num)
						.text('共有');
					}
					$("<button></button>").appendTo("#pwb"+i+' > span')
					.attr("id",workbenchList[i].w_num)
					.addClass('moveToWb btn btn-primary btn-sm')
					.text('参加')
					.click(function(){
						var id = $(this).attr('id');
			
						document.location.href="https://project-board-css-karchev.c9users.io/workbench/connect/"+id;
					});
					
					$('#w'+workbenchList[i].w_num).click(function(){
						var w_num = $(this).attr('id').substr(1);
						
						set_shareModal(w_num);
						
						$('#myModal').modal('toggle');
					});
				}
				
				// 팀에게 공유받은 워크벤치 출력
				for(var i = 0 ; i < teamWorkbenchList.length ; i++){
					$("<div></div>").appendTo("#teamListContainer")
					.addClass("contents col-md-4")
					.attr("id","twb"+i);
				
					$("<p></p>").appendTo("#twb"+i)
					.text("Name : " + teamWorkbenchList[i].w_name);
					$("<p></p>").appendTo("#twb"+i)
					.text("Team : " + teamWorkbenchList[i].t_name);
					$("<p></p>").appendTo("#twb"+i)
					.text("Author : " + teamWorkbenchList[i].m_id);
					$("<p></p>").appendTo("#twb"+i)
					.text("C_Date : " + teamWorkbenchList[i].w_created_date);
					$("<span></span>").appendTo("#twb"+i)
					.css('float','right');
					$("<button></button").appendTo("#twb"+i+' > span')
					.addClass('btn btn-info btn-sm')
					.attr("id","tif"+i)
					.text('詳細');
					// if(teamWorkbenchList[i].m_id == nickname){
					// 	$('<button></button>').appendTo('#twb'+i+' > span')
					// 	.attr("id","w"+teamWorkbenchList[i].w_num)
					// 	.addClass('shareWb')
					// 	.text('공유');
					// }
					$("<button></button>").appendTo("#twb"+i+' > span')
					.attr("id",teamWorkbenchList[i].w_num)
					.addClass('moveToWb btn btn-primary btn-sm')
					.text('参加')
					.click(function(){
						var id = $(this).attr('id');
			
						location.replace("/workbench/connect/" + id);
					});
					
					// $('.shareWb').click(function(){
					// 	var w_num = $(this).attr('id').substr(1);
						
					// 	set_shareModal(w_num);
						
					// 	// $('#myModal').modal('toggle');
					// });
				}
				
				$('.btn-info').click(function(){
					var pt_check = $(this).attr('id').substr(0,1);
					var w_num = $(this).attr('id').substr(3);
					console.log(pt_check);
					console.log(w_num);
					$('.modal-title').empty();
					$('.modal-body').empty();
					
					$('.modal-title').text('Workbenchの説明');
					
					if(pt_check == 't'){
						$('.modal-body').append('<p>'+teamWorkbenchList[w_num].w_contents+'</p>');
					}else{
						$('.modal-body').append('<p>'+workbenchList[w_num].w_contents+'</p>');
					}
					
					$('#myModal').modal('toggle')
				});
			},
			error: function(){
				alert('error');
			}
		});
	}
	
	function set_shareModal(w_num){
		$('.modal-title').empty();
		$('.modal-body').empty();
		
		$('.modal-title').text('共有');
		
		$('.modal-body').append('<div role="tabpanel"></div>');
		$('.modal-body > div').append('<ul class="nav nav-tabs" role="tablist" id="myTab"></ul>');
		$('.modal-body > div > ul').append('<li role="presentation" class="active"><a href="#friends" aria-controls="friends" role="tab" data-toggle="tab">フレンド</a></li><li role="presentation"><a href="#team" aria-controls="team" role="tab" data-toggle="tab">チーム</a></li>');
		$('.modal-body > div').append('<div class="tab-content"></div>');
		$('.tab-content').append('<div role="tabpanel" class="tab-pane active" id="friends">フレンドリスト</div><div role="tabpanel" class="tab-pane" id="team">チームリスト</div>');
		
		$('#myTab a').click(function(e){
			e.preventDefault();
			$(this).tab('show');
		});
		// 
		
		// 친구 리스트를 불러오기 위한 ajax
		$.ajax({
			url:"https://project-board-css-karchev.c9users.io/friend/Myfriend",
			dataType:'json',
			success:function(data){
				console.log(data);
				
				// 친구 리스트를 출력하기 위한 for문
				for(var j = 0 ; j < data.length ; j++){
					console.log(j);
					$('<p></p>').appendTo('#friends')
					.addClass('friendToShare')
					.attr('id','fb'+data[j].m_num)
					.text(data[j].m_id);
					$('<span></span>').appendTo('#fb'+data[j].m_num)
					.addClass('BtnRight');
					$('<button></button>').appendTo('#fb'+data[j].m_num+' > span')
					.addClass('BtnShareFriend')
					.attr('id', 'm'+data[j].m_num)
					.text('共有');
				}
				
				// 친구에게 workbench를 공유하기 위한 작업
				$('.BtnShareFriend').click(function(){
					var m_num = $(this).attr('id').substr(1);
					$.ajax({
						url:"https://project-board-css-karchev.c9users.io/workbench/shareWbFriend",
						data:{'f_num':m_num, 'w_num':w_num},
						method:'post',
						success:function(data){
							alert('success');
						},
						error:function(){
							alert('errorSharing');
						}
					});
				});
			},
			error:function(){
				alert('error');
			}
		});
		
		//팀 리스트를 불러오기 위한 ajax
		$.ajax({
			url:"https://project-board-css-karchev.c9users.io/team/getTeamList",
			dataType:'json',
			success:function(data){
				console.log(data);
				
				// 팀 리스트를 출력하기 위한 for문
				for(var i = 0 ; i < data.length ; i++){
					$('<p></p>').appendTo('#team')
					.addClass('teamToShare')
					.attr('id','tb'+data[i].t_num)
					.text(data[i].t_name);
					$('<span></span>').appendTo('#tb'+data[i].t_num)
					.addClass('BtnRight');
					$('<button></button>').appendTo('#tb'+data[i].t_num+' > span')
					.addClass('BtnShareTeam')
					.attr('id', 't'+data[i].t_num)
					.text('共有');
				}
				
				// 팀에게 workbench를 공유하기 위한 작업
				$('.BtnShareTeam').click(function(){
					var t_num = $(this).attr('id').substr(1);
					$.ajax({
						url:"https://project-board-css-karchev.c9users.io/workbench/shareWbTeam",
						data:{'t_num':t_num, 'w_num':w_num},
						method:'post',
						success:function(data){
							alert('success');
						},
						error:function(){
							alert('errorSharing');
						}
					});
				});
			},
			error:function(){
				alert('error');
			}
		});
		
	}
    </script>
    <script>
    	navbarChange();
    </script>
</head>
<body>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">ヘルプ</h4>
      </div>
      <div class="modal-body">
		<p>
			このページはユーザーが参加することができるブレインストーミングのリストを見ることのできるものです。<br/>
			各タイルにあるボタンをクリックすることで該当する機能を実行することができます。<br/>
		</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- 모달 끝임 -->
<div class="row body" id="viwe-container-row">
<div class="col-md-2"></div>
<div class="col-md-8" id="list-container">
	<div>
		<button class="btn btn-default">Workbench作成</button>
		<button class="btn btn-default">Workbench共有</button>
		<button class="btn btn-default">Workbench削除</button>
	</div>
	<div><h4><span class="userID"></span>のWorkbenchリスト<span style="float:right;color:#999999;">ユーザーが作成したWorkbenchのリストです。</span></h4></div>
	<div id="selfListContainer"></div>
	<hr style="border:1px solid black;clear:both;">
	<h4><span class="userID"></span>のフレンドWorkbenchリスト<span style="float:right;color:#999999;">フレンドが共有したWorkbenchのリストです。</span></h4>
	<div id="friendListContainer"></div>
	<hr style="border:1px solid black;clear:both;">
	<h4><span class="userID"></span>のチームWorkbenchリスト<span style="float:right;color:#999999;">チームが共有したWorkbenchのリストです。</span></h4>
	<div id="teamListContainer"></div>
	<hr style="border:1px solid black;clear:both;">
    
    <!--<div class="wbCreator">-->
    <!--	<fieldset>-->
    <!--	<legend>새로운 브레인스토밍 생성</legend>-->
    <!--	<input type="text" name="title" id="wbTitle" />-->
    <!--	<input type="button" id="titleSubmit" value="생성" />-->
    <!--	</fieldset>-->
    <!--</div>-->
</div>
<div class="col-md-3"></div>
</div>
