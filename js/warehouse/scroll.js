
function createRequestObject() {
    var reqObj;
    if(window.XMLHttpRequest) {
        try {
            reqObj = new XMLHttpRequest();
        } catch(e) {
            reqObj = false;
        }
    } else if(window.ActiveXObject) {
        try {
            reqObj = new ActiveXObject("Msxml2.XMLHTTP");
        } catch(e) {
            try {
                reqObj = new ActiveXObject("Microsoft.XMLHTTP");
            } catch(e) {
                reqObj = false;
            }
        }
    }
    return reqObj;
}


//POST 방식
function custom_Post(controller,method,list_tag_class,json) {
    var req = createRequestObject();
   
    console.log(json);
    req.open("POST",  "../"+controller + "/" + method, true);
    req.setRequestHeader("Content-Type", "application/json");//URL : 경로
    
    req.onreadystatechange = function () {
        if (req.readyState == 4) {
                
                $("." + list_tag_class).html(req.responseText);

        }
    }
    req.send(json);
}
function v_custom_Post(controller,method,list_tag_class,json) {
    var req = createRequestObject();
   
    console.log(json);
    req.open("POST",  "../../"+controller + "/" + method, true);
    req.setRequestHeader("Content-Type", "application/json");//URL : 경로
    //req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=UTF-8");
    //req.setRequestHeader("Cache-Control","no-cache, must-revalidate");
    //req.setRequestHeader("Pragma","no-cache");

    req.onreadystatechange = function () {
        if (req.readyState == 4) {
                
                $("." + list_tag_class).html(req.responseText);

        }
    }
    req.send(json);
}
function custom_Post_unview(controller,method,json) {
    var req = createRequestObject();
    console.log(json);

    req.open("POST",  "../"+controller + "/" + method, true);
    req.setRequestHeader("Content-Type", "application/json");//URL : 경로
    //req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=UTF-8");
    //req.setRequestHeader("Cache-Control","no-cache, must-revalidate");
    //req.setRequestHeader("Pragma","no-cache");

    req.onreadystatechange = function () {
        if (req.readyState == 4) {
             alert("슈ㅔ어링성공");

        }
    }
    req.send(json);
}
function custom_Post_unview_workbench(controller,method,json) {
    var req = createRequestObject();
    console.log(json);

    req.open("POST",  controller + "/" + method, true);
    req.setRequestHeader("Content-Type", "application/json");//URL : 경로
    //req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=UTF-8");
    //req.setRequestHeader("Cache-Control","no-cache, must-revalidate");
    //req.setRequestHeader("Pragma","no-cache");

    req.onreadystatechange = function () {
        if (req.readyState == 4) {
             alert("슈ㅔ어링성공");

        }
    }
    req.send(json);
}

function custom_Form_explorer(controller,method,list_tag_class,files,variable_name) {
    var req = createRequestObject();
    var formData = new FormData();
    var file_var = variable_name+"[]";
    for (var i = 0; i < files.length; i++) {
        formData.append(file_var,files[i]);
    }
    req.open("POST","../"+controller + "/" + method, true);
    //req.setRequestHeader("Content-Type", "application/json");//URL : 경로
    //req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=UTF-8");


    req.onreadystatechange = function () {
        if (req.readyState == 4) {
            $("." + list_tag_class).html(req.responseText);

        }
    }
    req.send(formData);

}
function custom_Form(controller,method,list_tag_class,form_tag) {
    var req = createRequestObject();
    var form = document.getElementById(form_tag);
    var formData = new FormData(form);

    req.open("POST", "../"+controller + "/" + method, true);
    //req.setRequestHeader("Content-Type", "application/json");//URL : 경로
    //req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=UTF-8");


    req.onreadystatechange = function () {
        if (req.readyState == 4) {
            $( list_tag_class).html(req.responseText);

        }
    }
    req.send(formData);
}


function infinite_scroll(controller,method,scroll_tag,className){

    $(function() {

        $(window).load();
        $(scroll_tag).scroll(function () {
            var scroller = $(scroll_tag);


            if (scroller[0].scrollHeight == Math.round(scroller.scrollTop()) + scroller.outerHeight() ) {
                alert("scroll");
                $.post("../index.php/" + controller+"/"+method,{js :"dsad"},
                    function (data) { /*data html 코드가 닮겨있음 */
                        if (data != "") {
                            $("."+className+":last").after(data);


                        }

                        /*$('div#lastPostsLoader').empty();*/
                    });


            }

        });
    });
};




