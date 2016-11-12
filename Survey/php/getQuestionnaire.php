<?php
// 유저 id로 된 모든 설문지를 가져오기
$data = json_decode(file_get_contents("php://input"));
// db연동
include('config.php');
$sid            = $data->sid;

$sid_query      = "select * from survey where s_num={$sid}";
$result         = $conn->query($sid_query) or die(mysqli_error($conn));

$recode = $result->fetch_assoc();

// 결과 response
$json_response = json_encode($recode);
echo $json_response;
?>