<html xmlns="http://www.w3.org/1999/html">
<body>
<?php
$fileName="smsniff.zip";
?>
<form action="./warehouse/downloadFile">
    <input type="hidden" name="testFile" value="<?=$fileName?>">
    <input type="submit" value="다운로드">
</form>

<?php echo isset($error)?$error:"";?>
<?php echo isset($data)?$data:"";?>
<form method="post" accept-charset="utf-8" action="warehouse/uploadFile" enctype="multipart/form-data">

<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="업로드" />
</form>
</body>
</html>