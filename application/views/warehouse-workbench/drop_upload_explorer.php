

<div id="fileDropBox" style="height: 100%;width: 100%;"></div>
<script>
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
        if (!files) {

            return;
        }

        custom_Form_explorer('warehouse','uploadFile','main-body',files,'userfile');
    } 
</script>