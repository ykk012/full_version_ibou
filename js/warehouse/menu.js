function isclicked(click_tag) {
    
    if ($("."+click_tag).hasClass(click_tag + "-selected")) {
            
        return true;
    }
  
    return false;
}

function  click_menu(target_tag,click_tag,selector) {
    window.colum_name = new Array();
    $(document).ready(function () {
        //if($(this).hasClass(click_tag+"-selected")
        var rightclicked=false;
        $("."+click_tag).mousedown(function (e) {
            if(rightclicked==true){
                    window.colum_name.pop();
                    rightclicked=false;
            }
            if (e.which == 3) {
                console.log(isclicked(click_tag));
                if(!isclicked(click_tag)&& !rightclicked) {
                    var val = $(this).find(selector).attr('value');
                    window.colum_name.push(val);
                    rightclicked=true;
                }
                console.log(window.colum_name);
            }
            else if(e.which == 1){
                
                if(!$(this).hasClass(click_tag + "-selected")) {
                    if(rightclicked==true){
                        window.colum_name.pop();
                        
                    }
                    var val = $(this).find(selector).attr('value');
                    window.colum_name.push(val);
                    rightclicked=false;
                }
                else
                    window.colum_name.pop();
                console.log(window.colum_name);
            }
        });

        $("."+target_tag).contextMenu('myMenu', {

                menuStyle: {

                    border: '2px solid #000'

                },

                itemStyle: {

                    fontFamily: 'verdana',

                    backgroundColor: '#666',

                    color: 'white',

                    border: 'none',

                    padding: '1px'

                },

                itemHoverStyle: {

                    color: '#fff',

                    backgroundColor: '#0f0',

                    border: 'none'

                },
                bindings: {

                    

                    'share': function (t) {
                       
                        $('#friendList_sharing').modal();
                        
                    },

                    'delete': function (t) {

                        $(".main-body").unbind('contextmenu');

                        obj.fnums = window.colum_name;
                        window.colum_name = [];
                        custom_Post('warehouse', 'deletefile', 'main-body', JSON.stringify(obj));


                    },

                    'down': function (t) {


                        var paramessage = "";
                        var fnums = window.colum_name;
                        for (var key in fnums) {
                            paramessage += "f_nums[" + key + "]" + "=" + fnums[key];
                            paramessage += '&';
                        }
                        console.log(window.colum_name);
                        console.log(paramessage);
                        window.colum_name = [];
                        
                        document.location.href = "https://project-board-css-karchev.c9users.io/warehouse/downloadFile?" + paramessage + "view_mode=" + obj.view_mode;
                    }


                }

            }
        );
    });
}


function  click_menu_keyword(click_tag,selector) {
    window.colum_name = new Array();
    $(document).ready(function () {
        //if($(this).hasClass(click_tag+"-selected")
        var rightclicked=false;
        $("."+click_tag).mousedown(function (e) {
            
            if(rightclicked==true){
                    window.colum_name.pop();
                    rightclicked=false;
            }
            if (e.which == 3) {
                console.log(isclicked(click_tag));
                if(!isclicked(click_tag)&& !rightclicked) {
                    var val = $(this).find(selector).attr('value');
                    window.colum_name.push(val);
                    rightclicked=true;
                }
                console.log(window.colum_name);
            }
            else if(e.which == 1){
                
                if(!$(this).hasClass(click_tag + "-selected")) {
                    if(rightclicked==true){
                        window.colum_name.pop();
                        
                    }
                    var val = $(this).find(selector).attr('value');
                    window.colum_name.push(val);
                    rightclicked=false;
                }
                else
                    window.colum_name.pop();
                console.log(window.colum_name);
            }
            
        });
        
		
        
        
        
                       
        //custom_Post_unview_workbench('../../warehouse', 'uploadfile_workbench', JSON.stringify(obj));
       
    });
}
