<?php

// json의 데이터 가져오기
$data = json_decode(file_get_contents("php://input"));

// db연동
include('config.php');

$result = $data->result;



// 결과값 입력
for($i = 0 ; $i < count($result) ; $i++){
    // 현재 문제
    $question = $result[$i];

    if($question->type == 'multiple' || $question->type == 'dropdown'){
        $questionnaire_query = "INSERT INTO result (panelid, surveyid, qid, chk_ob) VALUES
              ({$data->panelid}, {$data->s_num}, {$question->qid}, {$question->answer})";
        echo $questionnaire_query;
        $conn->query($questionnaire_query) or die(mysqli_error($conn));
    }
    else if($question->type == 'singleTextbox'){
        $questionnaire_query = "INSERT INTO result (panelid, surveyid, qid, chk_sub) VALUES
              ({$data->panelid}, {$data->s_num}, {$question->qid}, '{$question->answer}')";
        $conn->query($questionnaire_query) or die(mysqli_error($conn));
    }
    else if($question->type == 'date'){
        $questionnaire_query = "INSERT INTO result (panelid, surveyid, qid, chk_date) VALUES
              ({$data->panelid}, {$data->s_num}, {$question->qid}, '{$question->answer}')";
        $conn->query($questionnaire_query) or die(mysqli_error($conn));
    }

    else if($question->type == 'matrix'){
        $row=$question->row;
        for($i=0 ; $i< count($row) ; $i++){
            $questionnaire_query = "INSERT INTO result (panelid, surveyid, qid, chk_ob,qnum) VALUES
              ({$data->panelid}, {$data->s_num}, {$question->qid}, {$row[$i]->answer},{$row[$i]->num})";
            $conn->query($questionnaire_query) or die(mysqli_error($conn));

        }



    }

    //matrix


}

$questionnaire_query = "update survey set respondent = respondent+1 where s_num='{$data->s_num}'";
$conn->query($questionnaire_query) or die(mysqli_error($conn));

?>