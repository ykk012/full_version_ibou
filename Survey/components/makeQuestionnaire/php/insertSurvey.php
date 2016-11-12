<?php
    // json의 데이터 가져오기
    $data = json_decode(file_get_contents("php://input"));

    
    // db연동
    include('../../../php/config.php');

    // user의 num
    $uid            = $data->m_num;
    $board_num            = $data->b_num;
    $list             = $data->current_questionnaire;

    // 설문 정보 입력
    $questionnaire_query = "insert into survey (m_num, b_num,s_subject,s_explain,s_date)values ({$uid},'{$board_num}','{$list->s_subject}','{$list->s_explain}','{$list->s_date}') ";

    $result=$conn->query($questionnaire_query) or die(mysqli_error($conn));

    if($result){
        $result =  mysqli_insert_id($conn);
    }
    // 결과 response
    $json_response = json_encode($result);
    echo $json_response;
?>