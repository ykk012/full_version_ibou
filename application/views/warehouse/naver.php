

    <div class="container-fluid">
       
        <div id="navbar" class="navbar-collapse collapse">
            <div class="navbar-form">
                
                <div class="navbar-right">
                    <button class="btn btn-default btn-sm" onclick="obj.fnums = window.colum_name;
                    window.colum_name = [];
                        custom_Post('warehouse', 'deletefile', 'main-body', JSON.stringify(obj));
                        ">
                        <i class="glyphicon glyphicon-floppy-remove"></i>  削除 DELETE
                    </button>
                    <button class="btn btn-default btn-sm" data-toggle="modal" data-target="#uploadfile" >
                        <i class="glyphicon glyphicon-floppy-saved"></i> アップ・ロード UPLOAD
                    </button>
                    

                    
                    
                   

                </div>
            </div>
        </div>
    </div>