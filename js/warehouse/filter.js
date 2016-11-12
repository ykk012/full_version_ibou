
$(function() {

    
    window.obj={
        sort : {},
        share : "",
        fnums : new Array(),
        search_mod: "before",
        view_mode : "table"
    };



    $("input:text[name=date1]").datetimepicker({
        showSecond: true,
        dateFormat: 'yy-mm-dd',
        timeFormat: 'hh:mm:ss'
    });
    $("input:text[name=date2]").datetimepicker({
        showSecond: true,
        dateFormat: 'yy-mm-dd',
        timeFormat: 'hh:mm:ss'
    });

    $("input:radio[name=order]").bind('click',function() {
        window.obj.order = "";
        $("input:radio[name=order]:checked").each(function (index) {

            obj.order = this.value;

        });
        if(!$("input:radio[name=order]").is(":checked")){
            delete obj.order;
        }

        console.log(obj);
        custom_Post('warehouse','sorted_files_workbech','main-body',JSON.stringify(obj));

    });

    $("input:checkbox[name=share]").bind('click',function() {
        window.obj.share = "";
        $("input:checkbox[name=share]:checked").each(function (index) {

            window.obj.share= this.value;

        });

        console.log(obj);
        custom_Post('warehouse','sorted_files_workbech','main-body',JSON.stringify(obj));
    });

    $("input:checkbox[name=ext]").bind('click',function() {
        window.obj.sort.ext = new Array();
        $("input:checkbox[name=ext]:checked").each(function (index) {

            obj.sort.ext[index] = this.value;

        });
        if(!$("input:checkbox[name=ext]").is(":checked")){
            delete obj.sort.ext
        }
        console.log(obj);
        custom_Post('warehouse','sorted_files_workbech','main-body',JSON.stringify(obj));
    });
    $("input:radio[name=search_mod]").bind('click',function() {

        $("input:radio[name=search_mod]:checked").each(function () {
            obj.search_mod = this.value;

        });

        if(!$("input:radio[name=search_mod]").is(":checked")){
            delete obj.search_mod
        }
        console.log(obj);
        custom_Post('warehouse','sorted_files_workbech','main-body',JSON.stringify(obj));
    });
    $('#search_query').keyup(function(event) {
        var query = "";
        query = $('#search_query').val();
        console.log(query);
        if(query !== "") {
            obj.sort.search = query;
        }else {
            delete obj.sort.search;
        }
        custom_Post('warehouse','sorted_files_workbech','main-body',JSON.stringify(obj));

    });
    var query1 = "";
    $("input:text[name=date1]").bind('change',function(event) {


        if(query1==""){
            query1 = $(this).val();
            console.log(query1);
            if(query !== "") {
                obj.sort.date1 = query;
            }else {
                delete obj.sort.date1;
            }
            custom_Post('warehouse','sorted_files_workbech','main-body',JSON.stringify(obj));
        }
    });
    var query2 = "";
    $("input:text[name=date2]").bind('change',function(event) {

        if(query2==""){
            query2 = $(this).val();
            console.log(query2);
            if(query !== "") {
                obj.sort.date2 = query;
            }else {
                delete obj.sort.date2;
            }
            custom_Post('warehouse','sorted_files_workbech','main-body',JSON.stringify(obj));
        }
    });


});