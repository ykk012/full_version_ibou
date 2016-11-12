
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
    	sttInit();
    	init();
    	
    	console.log(socket);
    	
		var url = document.location.href;
		var workbenchID = url.substr(url.lastIndexOf("/")+1);

		getRootData(workbenchID);
		
		socket.on('adjustAttachFile',function(data){
			
			if($("#f"+data.k_num).hasClass("noFileExist")){
				$("#f"+data.k_num).removeClass("noFileExist");
				$("#f"+data.k_num).addClass("fileExist");
			}
		});
		
		socket.on('addNode',function(data){
			var newnodes = tree.nodes(data).reverse();

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

						socket.emit('keyword',nodeData);
					},
					error: function(){
						window.alert('오류가 발생하였습니다.');
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
					$(".modal-title").empty();
					$(".modal-body").empty();
					
					$(".modal-title").text("투표 리스트");
					
					$('.modal-dialog').removeClass('modal-lg');
					console.log(data);
					
					if(data.length == 0){
						$("<div></div>").appendTo(".modal-body")
						.text('생성된 투표가 없습니다.');
					}else{
					
					for(var i = 0 ; i < data.length ; i++){
						$("<div></div>").appendTo(".modal-body")
						.addClass('vote')
						.attr('id', 'vote'+data[i].v_num);
						$("<p></p>").appendTo('#vote'+data[i].v_num)
						.attr('class','vote_title')
						.text(data[i].v_title+' 하위 아이디어 투표');
						if(data[i].v_finished == 0){
							$("<p></p>").appendTo('#vote'+data[i].v_num)
							.text("진행중");
						}else{
							$("#vote"+data[i].v_num).addClass('finished');
							$("<p id='resultNode"+i+"'></p>").appendTo('#vote'+data[i].v_num)
							.text("선택 결과 : ");
							$("#resultNode"+i).append("<span style='float:right;'>"+data[i].k_word+"</span>");
							$("<p></p>").appendTo('#vote'+data[i].v_num)
							.text("완료됨");
						}
					}
					}
					
					$('.vote').click(function(){
						if($(this).hasClass('finished')){
							alert('Vote is closed!');
							return false;
						}
						
						var id = $(this).attr('id').substr(4);
						$.ajax({
							url: "https://project-board-css-karchev.c9users.io/workbench/getVoteCandidate/"+id,
							dataType: 'json',
							success: function(data){
								console.log(data);
								$(".modal-title").text($("#vote"+id + " > .vote_title").text());
								$(".modal-body").empty();
								
								for(var i = 0 ; i < data.length ; i++){
									$(".modal-body").append("<label><input type='radio' name='vote' value='"+data[i].k_num+"' />"+data[i].k_word+"</label>");
									$("<span style='float:right;'></sapn>").appendTo(".modal-body")
									.text("득표 수 : "+data[i].vk_counts);
									$("</br>").appendTo(".modal-body");
								}
								
								$("#vote_confirm").remove();
								$(".modal-footer").append('<button type="button" id="vote_confirm" class="btn btn-primary">투표</button>');
								
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
											alert('투표 완료');
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
	
	function toggleLogSideMenu(){
		$('#logArea').slideToggle();
	}
	
	
        function getRootData(id){
            $.ajax({
                url:"https://project-board-css-karchev.c9users.io/workbench/reflesh/"+id,
                dataType: 'json',
                success: function(data){
                
                	console.log(data[0]);
                    originData = JSON.stringify(data[0]);
                    root = data[0];
                    
                    treeJSON = tree(root);

            socketData = {"roomName" : id,
                        "rootNode" : originData};
                        socket.emit('roommake', socketData);
                        
                        console.log(data[1].m_num);
                     if(parseInt(data[1].m_num) == clientid){
                     	$("<li></li>").appendTo("#myMenu1 ul")
                     	.attr('id','vote')
                     	.text('투표 생성');
                     	$("<li></li>").appendTo("#myMenu1 ul")
                     	.attr('id','survey')
                     	.text('설문 생성');
                     	$('<input type="button" id="control_vote" value="투표관리" />').appendTo("#tree-menu");
                     	
                     	$('<input type="button" id="createPDF" value="PDF생성" />').appendTo("#tree-menu");
                     }
                    
                    $('#control_vote').click(function(){
                    	$.ajax({
				url:"https://project-board-css-karchev.c9users.io/workbench/getVoteList/"+id,
				dataType:'json',
				success:function(data){
					$(".modal-title").empty();
					$(".modal-body").empty();
					
					$(".modal-title").text("투표 리스트");
					$('.modal-dialog').removeClass('modal-lg');
					
					if(data.length == 0){
						$("<p></p>").appendTo(".modal-body").text('생성된 투표가 없습니다.');
					}else{
					
					for(var i = 0 ; i < data.length ; i++){
						$("<div></div>").appendTo(".modal-body")
						.addClass('vote')
						.attr('id', 'vote'+data[i].v_num);
						$("<p></p>").appendTo('#vote'+data[i].v_num)
						.attr('class','vote_title')
						.text(data[i].v_title+' 하위 아이디어 투표');
						if(data[i].v_finished == 0){
							$("<p></p>").appendTo('#vote'+data[i].v_num)
							.text("진행중");
							$("<input type='button' class='close_vote' id='vc"+data[i].v_num+"' value='투표 종료' />").appendTo('#vote' + data[i].v_num);
						}else{
							$("#vote"+data[i].v_num).addClass('finished');
							$("<p id='resultNode'></p>").appendTo('#vote'+data[i].v_num)
							.text("선택 결과 : ");
							$("#resultNode").append("<span style='float:right;'>"+data[i].k_word+"</span>");
							$("<p></p>").appendTo('#vote'+data[i].v_num)
							.text("완료됨");
						}
					}
					}
					
					$(".close_vote").click(function(){
						var voteID = $(this).attr('id').substr(2);
						
						$.ajax({
							url: "https://project-board-css-karchev.c9users.io/workbench/closeVote/"+voteID,
							dataType: 'json',
							success:function(data){
								data.roomName = id;
								console.log(data);
								socket.emit('confirmNode',data);
								
								$("#myModal").modal('toggle');
								alert('투표가 종료 되었습니다.');
							},
							error: function(){
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
                    
                    $('#createPDF').click(function(){
                    	window.open('https://project-board-css-karchev.c9users.io/workbench/createPDF/'+id);
                    });
                    
                    $('.fileExist').click(function(){
                    	var t_id = $(this).attr('id').substr(1);
                    	attach(t_id);
                    });
                    
                    $('rect').contextMenu('myMenu1',{
			bindings: {
				// 노드 오른쪽 메뉴 중 첨부파일 관리 메뉴
				'attach': function(t){
					var t_id = t.id.substr(1, t.id.lastIndexOf("_")-1);
					attach(t_id);
					
				},
				// 투표 작성 메뉴
				'vote': function(t){

					var t_id = t.id.substr(1, t.id.lastIndexOf("_")-1);
					var t_deleteCheck = t.id.substr(t.id.lastIndexOf("_")+1);
					if(t_deleteCheck == "start"){
						window.alert("하위 노드가 없어 투표를 할 수 없습니다.");
						return false;
					}

					var target_Node
					searchNode(root, function(d){
						if(d.k_num == t_id){
							target_Node = d;
							return true;
						}else {
							return false;
						}
					}, function(d) {
						return d.children && d.children.length > 0 ? d.children : null;
					});
					
					var candidate = new Array();
					candidate = target_Node.children ? target_Node.children : target_Node._children;
					var data = {};
					data.candidate = null;
					data.candidate = new Array();
					
					for(var i = 0 ; i < candidate.length ; i++){
						data.candidate[i] = candidate[i].k_num;
					}
					
					data.workbenchID = id;
					data.k_num = t_id;

					console.log(data);
					$.ajax({
						url:"https://project-board-css-karchev.c9users.io/workbench/createNewVote/",
						data: data,
						method: 'post',
						success:function(data){
							alert('투표 생성 완료');
						},
						error: function(){
							alert('error');
						}
					});

				},
				'delete': function(t){
					console.log(t.id);
					var t_id = t.id.substr(1, t.id.lastIndexOf("_")-1);
					var t_deleteCheck = t.id.substr(t.id.lastIndexOf("_")+1);
					if(t_deleteCheck == "end"){
						window.alert("삭제할 수 없는 노드입니다.");
						return false;
					}

					if(window.confirm("정말 삭제하시겠습니까?")){
						console.log(t);

						var target_Node
						searchNode(root, function(d){
							if(d.k_num == t_id){
								target_Node = d;
								return true;
							}else {
								return false;
							}
						}, function(d) {
							return d.children && d.children.length > 0 ? d.children : null;
						});

						$.ajax({
							url: "/workbench/deleteNode/",
							data: {"k_num" : target_Node.k_num,
									"k_parent": target_Node.k_parent},
							method: "post",
							success: function(data){
								window.alert("삭제 완료!");

								data = {"k_num" : target_Node.k_parent,
										"deletedNode" : target_Node.k_num,
										"roomName" : id};
								socket.emit('sendDeleteNode',data);
							},
							error: function(){
								window.alert("오류가 발생하였습니다.");
							}
						});
					}
				},
				'survey':function(t){
					var t_id = t.id.substr(1, t.id.lastIndexOf("_")-1);
					$(".modal-title").empty();
					$('.modal-body').empty();
					
					$("<form></form").appendTo('.modal-body')
						.attr('method','post')
						.attr('enctype','multipart/form-data');
						
						$(".modal-title").text("설문 타이틀");
					
						$(' <input type="textarea" class="" id="s_explain" placeholder="설문설명">')
						.appendTo('.modal-body> form');
						
						$('<button  id="survey_make_bt"class="btn btn-primary">생성</button>')
						.appendTo('.modal-footer');
							
					$('#myModal').modal('toggle');
					
	
					
				
			
				}
				
				
			}
		});

                },
                error: function(){
                    alert('오류 발생');
                }
            });
        }
        
        function attach(t_id){
        	
        	$.ajax({
						url: "https://project-board-css-karchev.c9users.io/workbench/getAttachList/"+t_id,
						dataType: 'json',
						success: function(data){
							console.log(data);
							console.log(t_id);
							$(".modal-title").empty();
							$(".modal-body").empty();
					
							$(".modal-title").text("첨부 파일");
							$('.modal-dialog').addClass('modal-lg');
					
					if(data.length == 0){
						$("<div></div>").appendTo(".modal-body").attr('id', 'fileDropBox').text('첨부된 파일이 없습니다.');
					}else{
						$("<div></div>").appendTo('.modal-body').attr('id','fileDropBox');
					
					// 각 노드에 첨부된 파일들을 보여주기 위한 for문
					for(var i = 0 ; i < data.length ; i++){
						$("<div></div>").appendTo("#fileDropBox")
						.addClass('attachedFile')
						.attr('id', 'attached'+data[i].f_num);
						if (data[i].f_ext==".tiff"||data[i].f_ext==".pdf"||data[i].f_ext==".pptx"||data[i].f_ext==".pps"||data[i].f_ext==".doc"||data[i].f_ext==".docx"){
							$("<img>").appendTo('#attached'+data[i].f_num)
							.attr('src','/img/warehouse/'+data[i].f_ext+'.png');
						}else{
							switch (data[i].f_ext) {
                        		case '.mp3':
                            		$("<img>").appendTo('#attached'+data[i].f_num)
									.attr('src','/img/warehouse/music-icon.png');
                            break;
                            case '.jpg':
                        case '.png':
                        case '.gif':
                        	$("<img>").appendTo('#attached'+data[i].f_num)
									.attr('src','/download/'+data[i].f_saved_name);
                            break;
                        case '.zip':
                        case '.rar':
                            $("<img>").appendTo('#attached'+data[i].f_num)
									.attr('src','/img/warehouse/zip-icon.png');
                            break;
                        default:
                            $("<img>").appendTo('#attached'+data[i].f_num)
									.attr('src','/img/warehouse/empty-icon.png');
                            break;
                    }
						}
						$("<p></p>").appendTo('#attached'+data[i].f_num)
						.attr('class','file_name')
						.text("파일명 : "+data[i].f_origin_name);
						$("<span style='float:right;'></span>").appendTo('#attached'+data[i].f_num+' > p');
					}
					}
					
					$("<hr>").appendTo(".modal-body").attr('style','clear:both');
					
					
					
					$("<div class='testAttach'></div>").appendTo(".modal-body")
					.addClass('upload');
					
					$("<button></button>").appendTo(".upload")
					.attr('id','attachTo'+t_id)
					.text('파일 첨부');
					
					$('#attachTo'+t_id).click(function(){
						$('.upload').empty();
						$('<div></div>').appendTo('.upload')
						.addClass('warehouse')
						.text('Warehouse');
						
						//Warehouse 파일 드래그앤드롭
						{
							$.ajax({
								url:'https://project-board-css-karchev.c9users.io/warehouse/filterView/',
								dataType:'text',
								success:function(data){
									$('.warehouse').empty();
									
									console.log(data);
									$('.warehouse').append(data);
								},
								error:function(){
									alert('error');
								}
							});
						}
						
						
						$('<div></div>').appendTo('.upload')
						.addClass('attachTarget')
						.text('Target div');
						
						//로컬 파일 드래그앤드롭
						{
						var message = [];

    					if (!window.FileReader) {
        					message = '<p>The ' +
            					'<a href="http://dev.w3.org/2006/webapi/FileAPI/" target="_blank">File API</a>s ' +
            					'are not fully supported by this browser.</p>' +
            					'<p>Upgrade your browser to the latest version.</p>';

        					document.querySelector('body').innerHTML = message;
    					}
    					else {
    						document.getElementById('fileDropBox').addEventListener('dragover', handleDragOver, false);
        					document.getElementById('fileDropBox').addEventListener('drop', handleFileSelection, false);
    					}

    					function handleDragOver(evt) {
        					evt.stopPropagation();  
        					evt.preventDefault(); 
    					}

    					function handleFileSelection(evt) {
        					evt.stopPropagation(); 
        					evt.preventDefault(); 

        					var files = evt.dataTransfer.files; 
        					console.log(files);
        					if (!files) {
        					    return;
        					}
        					
							var formData = new FormData();
							formData.append('userfile[]',files[0]);
						
							// if(!formData.has('userfile')){
							// 	alert('파일이 선택되지 않았습니다.');
							// 	return false;
							// }
							var fileData;
						
							$.ajax({
								url:"https://project-board-css-karchev.c9users.io/warehouse/uploadFromPC",
								processData: false,
        	            		contentType: false,
								data: formData,
								method: 'post',
								dataType:'json',
								success: function(data){
									console.log(data);
									
									fileData = data[0];
								
									$.ajax({
										url:"https://project-board-css-karchev.c9users.io/workbench/attachFile",
										data: {'k_num':t_id, 'f_num' : fileData},
										method: 'post',
										success:function(data){
										
										},
										error:function(){
											alert('attacherror');
										}
									});
								
									alert('success');
									$('#myModal').modal('toggle');
								},
								error: function(){
									alert('failed');
								}
							});
    					} 
						}
					});
					
					
					$(".attachedFile").click(function(){
						var f_nums = "f_nums[0]="+$(this).attr('id').substr(8);
						document.location.href = "https://project-board-css-karchev.c9users.io/warehouse/downloadFile?" + f_nums;
					});
					
					$("#myModal").modal('toggle');
						},
						error: function(){
							alert('오류발생');
						}
					});
        }
</script>
	<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">투표</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
	<!--<nav class="navbar navbar-default navbar-fixed-top secondNav">-->
	<!--  <div class="container">-->
	<!--    <div class="navbar-header">-->
	<!--      <a class="navbar-brand" href="#"></a>-->
	<!--    </div>-->
	<!--    <div class="collapse navbar-collapse" id="myNavbar">-->
	<!--      <ul class="nav navbar-nav navbar-right">-->
	<!--      	<li><a href="https://project-board-css-karchev.c9users.io/home/new_temp">RETURN</a></li>-->
	<!--        <li><a href="#" onclick="toggleChatSideMenu()">VIDEO CHAT</a></li>-->
	<!--        <li><a href="#" onclick="toggleLogSideMenu()">CHAT LOG</a></li>-->
	<!--      </ul>-->
	<!--    </div>-->
	<!--  </div>-->
	<!--</nav>-->
	<div class="container-fluid">
    <div class="row body">
		<div id="tree-container-box" class="container col-xs-10 left-side">
			<div class="col-xs-12" id="tree-container">
				
			</div>
		</div>
		
	    <div class="col-xs-2 buttonCol">
			<div class="buttonDiv">
			   	<button type="button" class="btn btn-default videotoggler"><span class="glyphicon glyphicon-facetime-video" aria-hidden="true"></span></button><br/>
				<button type="button" class="btn btn-default logtoggler"><span class="glyphicon glyphicon-list" aria-hidden="true"></span></button><br/>
				<button type="button" class="btn btn-default chattoggler"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span></button>
			</div>
	    </div>
		<!--<div class="col-xs-2 right-side">-->
		<!--	<div id="logArea">-->
		<!--		<textarea id="logTextArea"></textarea>-->
		<!--		<input type="text" id="roomChatText"><input type="submit" value="기록" id="roomChatButton"><br/>-->
		<!--		<button id="start_button">STT START</button>-->
		<!--	</div>-->
		<!--</div>-->
		<!--<div class="col-xs-2 right-side">-->
		<!--	<div id="videoArea">-->
		<!--	</div>-->
		<!--</div>-->
	</div>
	<div class="contextMenu" id="myMenu1">
		<ul>
			<li id="attach">첨부 파일</li>
			<li id="delete">노드 삭제</li>
		</ul>
	</div>
	</div>
	
	<div id="bottomMenu">
		<div id="tree-menu">
			<input type="button" id="do_vote" value="투표" />
		</div>
		<div id="input-field">
	    	<input type="text" id="keyword" size="50" name="keyword" placeholder="키워드를 입력하세요" />
	    	<button id="BtnLeave">나가기</button>
	    </div>
	</div>