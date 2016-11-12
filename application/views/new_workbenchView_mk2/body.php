<div class="contextMenu" id="myMenu1">
		<ul>
			<li id="attach">ファイル添付</li>
			<li id="delete">アイデア削除</li>
		</ul>
	</div>
  <script src="//cdn.temasys.com.sg/adapterjs/0.13.x/adapter.min.js"></script>
  <script src="https://project-board-css-karchev.c9users.io/js/video-chat.js"></script>
  <script src="https://project-board-css-karchev.c9users.io/js/stt-client.js"></script>
  <script src="https://project-board-css-karchev.c9users.io/js/navbar-controll.js"></script>
<script>
	navbarChange();
	videoChatInit(); 
	sttInit()
</script>
  
<script>
	$('head').append('<link rel="stylesheet" type="text/css" href="/css/workbench.css">');
</script>

<script>
	var socket = io.connect('https://workbench-node-server-karchev.c9users.io:8080');
    var nickname = '<?php echo $_SESSION['loginInfo']->m_id;?>';
    var clientid = '<?php echo $_SESSION['loginInfo']->m_num;?>';
    var socketData;
	var nodeData;
    var originData;
	var root;
	var chosenNode;
	var treeJSON;

$(document).ready(function(){
    	console.log(socket);
    	
		var url = document.location.href;
		var workbenchID = url.substr(url.lastIndexOf("/")+1);

		getRootData(workbenchID);
		
		socket.on('adjustAttachFile',function(data){
			
			if($("#f"+data.k_num).hasClass("noFileExist")){
				$("#f"+data.k_num).removeClass("noFileExist");
				$("#f"+data.k_num).addClass("fileExist");
				$("#f"+data.k_num).click(function(){
					attach(data.k_num);
				});
			}
		});
		
		socket.on('addNode',function(data){
			var newnodes = tree.nodes(data).reverse();
			console.log(data);

			var adjNode;
			function searchNode(parent, searchFn, childrenFn){
		        if(!parent) return;

		        if(searchFn(parent)) return;

		        var children = childrenFn(parent);
		        if(children) {
		            var count = children.length;
		            for(var i = 0; i < count; i++){
		                searchNode(children[i], searchFn, childrenFn);
		            }
		        }
		    }

			searchNode(root, function(d){
				if(d.k_num == data.chosenNode){
					adjNode = d;
					return true;
				}else {
					return false;
				}
			}, function(d) {
		        return d.children && d.children.length > 0 ? d.children : null;
		    });

            if(adjNode.children && adjNode.children.length > 0)
                adjNode.children.push(newnodes[0]);
            else if(adjNode._children && adjNode._children.length > 0){
                adjNode._children.push(newnodes[0]);
            }
            else if(!adjNode._children && !adjNode.children) {
                adjNode.children = new Array();
                adjNode.children.push(newnodes[0]);
            }

            treeJSON(adjNode);
            
            setContextMenu(workbenchID);
		});

		socket.on('lockup', function(data){
			var obj = $(".id_"+data.nodeID).parent();
			console.log(obj);
		});

		$('#keyword').keypress(function(e){
			if(e.keyCode == 13 && chosenNode != null){

				nodeData = {'roomName': workbenchID,
						'name': $(this).val(),
						'chosenNode' : chosenNode.k_num,
						'k_parent' : chosenNode.k_num,
						'depth' : (parseInt(chosenNode.depth)+1),
						'userID' : clientid,
						'k_confirmed' : 0
				};

				console.log(nodeData);

				$.ajax({
					url: "/workbench/insertNode/",
					data: nodeData,
					method: "post",
					dataType: "json",
					success: function(data){
						nodeData.k_num = data.k_num;
						console.log(nodeData);

						socket.emit('keyword',nodeData);
					},
					error: function(){
						window.alert('Error!');
					}
				});

			}
	    });
	    
	    socket.on('adjustConfirmedNode',function(data){
	    	var target_Node;
			searchNode(root, function(d){
				if(d.k_num == data.k_num){
					target_Node = d;
					return true;
				}else {
					return false;
				}
			}, function(d) {
				return d.children && d.children.length > 0 ? d.children : null;
			});
			
			$("#l"+target_Node.k_parent + "_" + target_Node.k_num).addClass('confirmedLink');
			
			$("#"+target_Node.idForChange).addClass('confirmed');
			
			target_Node.k_confirmed = 1;
			console.log(target_Node);
			
			treeJSON(target_Node);
	    });

		socket.on('deleteNode',function(data){
			var target_Node;
			console.log(data);
			searchNode(root, function(d){
				if(d.k_num == data.k_num){
					target_Node = d;
					return true;
				}else {
					return false;
				}
			}, function(d) {
				return d.children && d.children.length > 0 ? d.children : null;
			});
			
			console.log(target_Node);
			for(var i = 0; i < target_Node.children.length ; i++){
				if(target_Node.children[i].k_num == data.deletedNode){
					target_Node.children = target_Node.children.slice(0,i).concat(target_Node.children.slice(i+1));
				}
			}

			treeJSON(target_Node);
		});


		
    
		$("#BtnLeave").click(function(){
			socket.emit('roomleave',1);

			location.replace("/workbench/");
		});
		
		$("#do_vote").click(function(){
			$.ajax({
				url:"https://project-board-css-karchev.c9users.io/workbench/getVoteList/"+workbenchID,
				dataType:'json',
				success:function(data){
					clearModal();
					
					$("#myModal > div .modal-title").text("投票リスト");
					
					$('#myModal > div .modal-dialog').removeClass('modal-lg');
					console.log(data);
					
					if(data.length == 0){
						$("<div></div>").appendTo("#myModal > div .modal-body")
						.text('登録された投票がありません');
					}else{
					
					for(var i = 0 ; i < data.length ; i++){
						$("<div></div>").appendTo("#myModal > div .modal-body")
						.addClass('vote_box')
						.attr('id', 'vote'+data[i].v_num);
						$("<p></p>").appendTo('#vote'+data[i].v_num)
						.attr('class','vote_title')
						.text(data[i].v_title+'下位アイデア投票');
						if(data[i].v_finished == 0){
							$("<p></p>").appendTo('#vote'+data[i].v_num)
							.text("進行中");
							$("<button></button>").appendTo('#vote'+data[i].v_num)
							.addClass('btn btn-primary vote')
							.text('参加');
						}else{
							$("#vote"+data[i].v_num).addClass('finished');
							$("<p id='resultNode"+i+"'></p>").appendTo('#vote'+data[i].v_num)
							.text("投票結果 : ");
							$("#resultNode"+i).append("<span style='float:right;'>"+data[i].k_word+"</span>");
							$("<p></p>").appendTo('#vote'+data[i].v_num)
							.text("終了");
						}
					}
					}
					
					$('.vote').click(function(){
						
						var id = $(this).parent().attr('id').substr(4);
						$.ajax({
							url: "https://project-board-css-karchev.c9users.io/workbench/getVoteCandidate/"+id,
							dataType: 'json',
							success: function(data){
								console.log(data);
								$("#myModal > div .modal-title").text($("#vote"+id + " > .vote_title").text());
								$("#myModal > div .modal-body").empty();
								
								for(var i = 0 ; i < data.length ; i++){
									$("#myModal > div .modal-body").append("<label><input type='radio' name='vote' value='"+data[i].k_num+"' />"+data[i].k_word+"</label>");
									$("<span style='float:right;'></sapn>").appendTo("#myModal > div .modal-body")
									.text("得票数 : "+data[i].vk_counts);
									$("</br>").appendTo("#myModal > div .modal-body");
								}
								
								$("#vote_confirm").remove();
								$("#myModal > div .modal-footer").prepend('<button type="button" id="vote_confirm" class="btn btn-primary">投票</button>');
								
								$("#vote_confirm").click(function(){
									var voted = $("input[type=radio]:checked").val();
									if(voted == undefined){
										alert('You need to make a choice!');
										return false;
									}
									
									$.ajax({
										url: "https://project-board-css-karchev.c9users.io/workbench/voteCandidate/"+voted,
										// dataType: 'text',
										success: function(data){
											// console.log(data);
											alert('投票完了');
										},
										error: function(){
											alert('error');
										}
									});
									
									$("#myModal").modal('toggle');
								});
							},
							error: function(data){
								alert('error');
							}
						});
					});
					
					$("#myModal").modal('toggle');
					
					
				},
				error:function(){
					alert('error');
				}
			});
		});
		
    });
    
</script>

<script src="https://project-board-css-karchev.c9users.io/js/workbench.js"></script>

	<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
  
  <div class="side-button-menu">
	<button type="button" class="btn btn-default videotoggler"><span class="glyphicon glyphicon-facetime-video" aria-hidden="true"></span></button><br/>
	<button type="button" class="btn btn-default logtoggler"><span class="glyphicon glyphicon-list" aria-hidden="true"></span></button><br/>
	<button type="button" class="btn btn-default chattoggler"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span></button>
  </div>

  <!--화면 전체 wrapper -->
  <div class="container-fluid view-outline">
    <!--svg 공간-->
    <div class="container svg-area">
    </div>
    <!--화면 하단 메뉴-->
    <div class="container bottom-button-menu">
		<div id="tree-menu">
			<button id="do_vote" class="btn btn-default">投票</button>
		</div>
		<div id="input-field">
	    	<input type="text" id="keyword" size="50" name="keyword" placeholder="アイデアを入力してください" />
	    	<button class="btn btn-default" id="BtnLeave">終了</button>
	    </div>
	</div>
  </div>
</body>
</html>
