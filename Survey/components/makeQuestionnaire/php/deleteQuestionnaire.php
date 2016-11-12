<?php

    $data = json_decode(file_get_contents("php://input"));

    // db연동
    include('../../../php/config.php');

    $json_response = json_encode($data);
    echo $json_response;
    // user의 아이디
    $sid            = $data->s_num;




    // 설문지의 문제 id를 가져오고 id에 해당하는 example , qimage를 삭제
    $query      = "select qid from question where surveyid={$sid}";
    $result     =  $conn->query($query) or die(mysqli_error($conn));



        while ($recode = $result->fetch_assoc()) {
            $qid = $recode['qid'];

            $sub_query = "delete from choice where qid={$qid}";
            $sub_result = $conn->query($sub_query) or die(mysqli_error($conn));

        }

        $query = "delete from question where surveyid={$sid}";
        $result = $conn->query($query) or die(mysqli_error($conn));

            $query = "delete from survey where surveyid={$sid}";
            $result = $conn->query($query) or die(mysqli_error($conn));
    
    



?>