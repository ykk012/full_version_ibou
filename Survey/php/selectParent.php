<?php
// 유저 id로 된 모든 설문지를 가져오기
$data = json_decode(file_get_contents("php://input"));

// db연동
include('config.php');

$k_parent      = $data->k_parent;

$servey_query = "select k_word,k_num,k_depth from keywords where k_num={$k_parent}";
$result = $conn->query($servey_query) or die(mysqli_error($conn));


$survey_list = array();

while($recode = $result->fetch_assoc()){
    $survey_list[] = $recode;
}

// 결과 response
$json_response = json_encode($survey_list);
echo $json_response;
?>
