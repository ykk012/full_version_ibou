<script>

    $(function(){
        var element = document.getElementById('drop_upload');
        document.getElementById('drop_upload').onclick = function(){
            this.disabled=true;
            return false;

        }

        document.getElementById('drop_upload').onchange = function(event){
            //event.preventDefault ? event.preventDefault() : (event.returnValue = false);

            custom_Form('warehouse','uploadFile','main-body','form_data');
        };

    });


</script>

<div id="drop_range" >
    <form action="" method="post" enctype="multipart/form-data" id="form_data">

        <input multiple="multiple" id="drop_upload" type="file" name="userfile[]"  style="apperance: none; -webkit-apperance: none; height: 100%; width: 100%;left: 0px; opacity: 0" />

    </form>
</div>