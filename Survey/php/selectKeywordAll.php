<?php
// 유저 id로 된 모든 설문지를 가져오기
$data = json_decode(file_get_contents("php://input"));

// db연동
include('config.php');

$w_num      = $data->w_num;


  $sql = "SELECT k_num, k_word, k_parent, k_depth, k_confirmed  FROM keywords 
        
        WHERE w_num = {$w_num} ORDER BY k_depth, k_num";


$query1 = $conn->query($sql) or die(mysqli_error($conn));


// $list = array();

// while($recode = $result->fetch_assoc()){
//     $list[] = $recode;
// }

for( $i = 0 ; $i < mysqli_num_rows($query1) ; $i++){
  $query[$i] = mysqli_fetch_assoc($query1);
}
   
// $query = $query->mysqli_result();

        if($query) {
            $data = array();
            $num = count($query);
            $maxDepth = 0;
            for($i = 0 ; $i < $num ; $i++) {
                $k_num = $query[$i]['k_num'];
                $k_word = $query[$i]['k_word'];
                $k_parent = $query[$i]['k_parent'];
                $k_depth = $query[$i]['k_depth'];
                $k_confirmed = $query[$i]['k_confirmed'];
                $data[$k_depth][$i]['k_num'] = $k_num;
                $data[$k_depth][$i]['name'] = $k_word;
                $data[$k_depth][$i]['k_parent'] = $k_parent;
                $data[$k_depth][$i]['k_confirmed'] = $k_confirmed;
                if($maxDepth < $k_depth)
                    $maxDepth = $k_depth;
            }
            for($i = $maxDepth ; $i > 0 ; $i--) {
                foreach($data[$i-1] as &$key) {
                    $k_num = $key['k_num'];
                    $cnt = 0;
                    foreach($data[$i] as $key2) {
                        if($key2['k_parent'] == $k_num){
                            $key['children'][$cnt] = $key2;
                            $cnt++;
                        }
                    }
                }
                unset($data[$i]);
            }
        }
        
      

  


// 결과 response
$json_response = json_encode($data[0][0]);
echo $json_response;
?>
    