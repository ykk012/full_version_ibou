<?php

    //ob_start();
	$user=json_decode(file_get_contents('php://input'));  //get user from

    // db연동
    include('../../php/config.php');
    // user의 아이디

    // 설문 정보 입력
    $questionnaire_query = "select * from member where id='{$user->m_id}' and pwd='{$user->m_pwd}'";
    $result = $conn->query($questionnaire_query) or die(mysqli_error($conn));

    $recode = $result->fetch_assoc();

    $arrays = array();

	if($recode != null){
        $arrays['user']               = array();
        $arrays['user']['m_id']        = $recode['m_id'];
        $arrays['user']['m_num']        = $recode['m_num'];
        $arrays['user']['m_name']       = $recode['m_name'];


        // 결과 response
        $json_response = json_encode( $arrays );
        echo $json_response;
    }

?>