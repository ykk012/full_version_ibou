<?php
// 유저 id로 된 모든 설문지를 가져오기
$data = json_decode(file_get_contents("php://input"));

// db연동
include('config.php');

$w_name      = $data->w_name;

$servey_query = "select w_name,w_num from workbench where w_name like '{$w_name}'";

$result = $conn->query($servey_query) or die(mysqli_error($conn));


$list = array();

while($recode = $result->fetch_assoc()){
    $list[] = $recode;
}

   

        
      

  


// 결과 response
$json_response = json_encode($list);
echo $json_response;
?>
