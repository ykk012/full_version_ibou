

    

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
	
	function clearModal(){
		
		$("#myModal > div .modal-title").empty();
		$("#myModal > div .modal-body").empty();
		$("#myModal > div .modal-footer").empty();
		
		$('<button></button>').appendTo("#myModal > div .modal-footer")
		.addClass("btn btn-default")
		.attr('data-dismiss', 'modal')
		.text('Close');
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
                     	.text('投票登録');
                     	
                  
                     	$('<button class="btn btn-default" id="control_vote">投票管理</button>').appendTo("#tree-menu");
                     	
                     	$('<button class="btn btn-default" id="createPDF">PDF作成</button>').appendTo("#tree-menu");
                     }
                    
                    $('#control_vote').click(function(){
                    	$.ajax({
				url:"https://project-board-css-karchev.c9users.io/workbench/getVoteList/"+id,
				dataType:'json',
				success:function(data){
					clearModal();
					
					$("#myModal > div .modal-title").text("投票リスト트");
					$('#myModal > div .modal-dialog').removeClass('modal-lg');
					
					if(data.length == 0){
						$("<p></p>").appendTo("#myModal > div .modal-body").text('登録された投票がありません');
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
							$("<button></button>").appendTo('#vote' + data[i].v_num)
							.addClass("btn btn-primary close_vote")
							.attr('id', 'vc'+data[i].v_num)
							.text('締切');
						}else{
							$("#vote"+data[i].v_num).addClass('finished');
							$("<p id='resultNode'></p>").appendTo('#vote'+data[i].v_num)
							.text("投票結果 : ");
							$("#resultNode").append("<span style='float:right;'>"+data[i].k_word+"</span>");
							$("<p></p>").appendTo('#vote'+data[i].v_num)
							.text("終了");
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
								alert('投票の締切が完了しました');
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
                    
                    setContextMenu(id);
                },
                error: function(){
                    alert('Error');
                }
            });
        }
        
        function setContextMenu(id){
        	$('.nodeBox').contextMenu('myMenu1',{
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
						window.alert("下位アイデアがないため投票を登録できません");
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
							alert('投票の締め切りが完了しました');
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
						window.alert("削除できないアイデアです");
						return false;
					}

					if(window.confirm("このアイデアを削除しますか？")){
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
						console.log(target_Node.k_parent);

						$.ajax({
							url: "/workbench/deleteNode/",
							data: {"k_num" : target_Node.k_num,
									"k_parent": target_Node.k_parent},
							method: "post",
							success: function(data){
								window.alert("削除完了");

								data = {"k_num" : target_Node.k_parent,
										"deletedNode" : target_Node.k_num,
										"roomName" : id};
								socket.emit('sendDeleteNode',data);
							},
							error: function(){
								window.alert("Error");
							}
						});
					}
				},
				'survey':function(t){
					var t_id = t.id.substr(1, t.id.lastIndexOf("_")-1);
					clearModal();
						
					$("<form></form").appendTo('#myModal > div .modal-body')
						.attr('method','post')
						.attr('enctype','multipart/form-data');
						
						$("#myModal > div .modal-title").text("アンケート題目");
					
						$(' <input type="textarea" class="" id="s_explain" placeholder="アンケートの説明">')
						.appendTo('#myModal > div .modal-body> form');
						
						$('<button  id="survey_make_bt"class="btn btn-primary">作成</button>')
						.appendTo('#myModal > div .modal-footer');
							
					$('#myModal').modal('toggle');
					
		
				$('#survey_make_bt').click(function(){
					alert("作成完了");
					
					
						});
					
				
			
				}
				
				
			}
		});
		$('.nodeText').contextMenu('myMenu1',{
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
						window.alert("下位アイデアがないため投票を登録できません");
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
							alert('投票の締め切りが完了しました');
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
						window.alert("削除できないアイデアです");
						return false;
					}

					if(window.confirm("このアイデアを削除しますか？")){
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
						console.log(target_Node.k_parent);

						$.ajax({
							url: "/workbench/deleteNode/",
							data: {"k_num" : target_Node.k_num,
									"k_parent": target_Node.k_parent},
							method: "post",
							success: function(data){
								window.alert("削除完了");

								data = {"k_num" : target_Node.k_parent,
										"deletedNode" : target_Node.k_num,
										"roomName" : id};
								socket.emit('sendDeleteNode',data);
							},
							error: function(){
								window.alert("Error");
							}
						});
					}
				},
				'survey':function(t){
					var t_id = t.id.substr(1, t.id.lastIndexOf("_")-1);
					clearModal();
						
					$("<form></form").appendTo('#myModal > div .modal-body')
						.attr('method','post')
						.attr('enctype','multipart/form-data');
						
						$("#myModal > div .modal-title").text("アンケート題目");
					
						$(' <input type="textarea" class="" id="s_explain" placeholder="アンケートの説明">')
						.appendTo('#myModal > div .modal-body> form');
						
						$('<button  id="survey_make_bt"class="btn btn-primary">作成</button>')
						.appendTo('#myModal > div .modal-footer');
							
					$('#myModal').modal('toggle');
					
		
				$('#survey_make_bt').click(function(){
					alert("作成完了");
					
					
						});
					
				
			
				}
				
				
			}
		});
        }
        
        function attach(t_id){
        	var url = document.location.href;
		var workbenchID = url.substr(url.lastIndexOf("/")+1);
        	$.ajax({
						url: "https://project-board-css-karchev.c9users.io/workbench/getAttachList/"+t_id,
						dataType: 'json',
						success: function(data){
							console.log(data);
							clearModal();
					
							$("#myModal > div .modal-title").text("ファイル添付");
							$('#myModal > div .modal-dialog').addClass('modal-lg');
					
					if(data.length == 0){
						$("<div></div>").appendTo("#myModal > div .modal-body").attr('id', 'fileDropBox').text('添付されたファイルがありません。');
					}else{
						$("<div></div>").appendTo('#myModal > div .modal-body').attr('id','fileDropBox');
					
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
					
					$("<hr>").appendTo("#myModal > div .modal-body").attr('style','clear:both');
					
					
					
					$("<div class='testAttach'></div>").appendTo("#myModal > div .modal-body")
					.addClass('upload');
					
					$("<button></button>").appendTo(".upload")
					.addClass('btn btn-default')
					.attr('id','attachTo'+t_id)
					.text('ファイル添付');
					
					$('#attachTo'+t_id).click(function(){
						$('.upload').empty();
						$('<div></div>').appendTo('.upload')
						.addClass('warehouse')
						.text('Warehouse is loading. Please wait...');
						
						$("<button></button>").prependTo("#myModal > div .modal-footer")
						.addClass('btn btn-primary')
						.attr('id', 'fromWH')
						.text('添付');
					
						//Warehouse 파일 드래그앤드롭
						{
							$.ajax({
								url:'https://project-board-css-karchev.c9users.io/warehouse/filterView/'+t_id,
								dataType:'text',
								success:function(data){
									$('.warehouse').empty();
									
								// 	console.log(data);
									$('.warehouse').append(data);
									$('#fromWH').click(function() {
										obj.fnums =window.colum_name;
					    				$.ajax({
										url:"https://project-board-css-karchev.c9users.io/warehouse/uploadfile_workbench",
										data: JSON.stringify(obj),
										method: 'post',
										success:function(data){
											$('#f'+t_id).show();
											$("#myModal").modal('toggle');
											
											
											attachedData = {'roomName' : workbenchID,
															'k_num' : t_id};
											socket.emit('fileAttached',attachedData);
										},
										error:function(){
											alert('attacherror');
										}
										});
									});
								},
								error:function(){
									alert('error');
								}
							});
						}
						
						
						// $('<div></div>').appendTo('.upload')
						// .addClass('attachTarget')
						// .text('Target div');
						
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
							// 	alert('ファイルが選択されていません');
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
											attachedData = {'roomName' : workbenchID,
															'k_num' : t_id};
											socket.emit('fileAttached',attachedData);
										},
										error:function(){
											alert('attacherror');
										}
									});
									
									$('#f'+t_id).show();
								
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
							alert('Errorｆ');
						}
					});
        }