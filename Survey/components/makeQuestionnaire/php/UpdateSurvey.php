<?php

$data = json_decode(file_get_contents("php://input"));

// db연동
include('../../../php/config.php');

$json_response = json_encode($data);
echo $json_response;
// user의 아이디
$s_num            = $data->s_num;



        $query      = "update survey set state='share' where s_num='{$s_num}'";
        $result     = $conn->query($query) or die(mysqli_error($conn));
  



?>