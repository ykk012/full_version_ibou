<?php
// 유저 id로 된 모든 설문지를 가져오기
$data = json_decode(file_get_contents("php://input"));

// db연동
include('config.php');

$w_num      = $data->w_num;

$servey_query = "select w_name from workbench where w_num={$w_num}";
$result = $conn->query($servey_query) or die(mysqli_error($conn));


$survey_list = array();

while($recode = $result->fetch_assoc()){
    $survey_list = $recode;
}

// 결과 response
$json_response = json_encode($survey_list);
echo $json_response;
?>
