<?php
// 유저 id로 된 모든 설문지를 가져오기
$data = json_decode(file_get_contents("php://input"));

// db연동
include('config.php');

// user의 아이디

$sid_query      = "select * from survey order by surveyid desc limit 0, 4";
$result         = $conn->query($sid_query) or die(mysqli_error($conn));
$submit_data    = array();

while($recode = $result->fetch_assoc()){
    $submit_data[] = $recode;
}

// 결과 response
$json_response = json_encode($submit_data);
echo $json_response;
?>