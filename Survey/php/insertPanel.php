<?php
// json의 데이터 가져오기
$data = json_decode(file_get_contents("php://input"));

// db연동
include('config.php');
// user의 아이디
$ip = $_SERVER['REMOTE_ADDR'];

// 설문 정보 입력
$questionnaire_query = "INSERT INTO panel (s_num, gender, agegroup, area, pdate, ip) VALUES
({$data->s_num}, '{$data->gender}', '{$data->agegroup}', '{$data->area}', sysdate(), '{$ip}')";
$conn->query($questionnaire_query) or die(mysqli_error($conn));

$temp   = "select * from panel order by panelid desc limit 0, 1";
$result = $conn->query($temp) or die(mysqli_error($conn));
$user_recode = $result->fetch_assoc();


// 결과 response
$json_response = json_encode($user_recode);
echo $json_response;

?>