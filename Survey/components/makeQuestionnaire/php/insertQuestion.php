<?php
    // json의 데이터 가져오기
    $data = json_decode(file_get_contents("php://input"));

    // db연동
    include('../../../php/config.php');

    // 임시 설문지 ID
    $surveyid       = $data->current_questionnaire->s_num;
    $cq             = $data->current_questionnaire;

    // 객관식 문형의 경우
    for($i = 0 ; $i < count($cq->preview) ; $i++) {

        $question = $cq->preview[$i];

        // 객관식 일 경우
        if ($question->type == 'multiple') {

            // question table에 insert
            $question_query = "insert into question (surveyid, qnum, qindex, qcontent, logiccheck, requirecheck, type) values ($surveyid, {$question->num} , {$question->index},'{$question->question_content}', false, false, '{$question->type}')";
            echo $question_query;
            $conn->query($question_query) or die(mysqli_error($conn));

            // 문제 아이디 쿼리 해오기
            $question_query = "select qid from question where surveyid=$surveyid and qindex={$question->index}";
            $result = $conn->query($question_query) or die(mysqli_error($conn));
            $recode = $result->fetch_assoc();
            $qid = $recode['qid'];

            // 문제 보기입력
            for ($j = 0; $j < count($question->example); $j++) {

                $example = $question->example[$j];
                $exam_query = "insert into choice (cnum, choicecontent, qid) values ($example->exam_index, '{$example->content}', {$qid})";
                $conn->query($exam_query);
            }
        } // 행렬형 문제일 경우
        else if ($question->type == 'matrix') {

            // 상위 question insert
            $question_query = "insert into question (surveyid, qnum, qindex, qcontent, requirecheck, type) values ($surveyid, {$question->num} , {$question->index},'{$question->question_content}', 0, '{$question->type}')";
            $conn->query($question_query) or die(mysqli_error($conn));

            // qid 가져오기
            $question_query = "select qid from question where surveyid=$surveyid and qindex={$question->index}";
            $result = $conn->query($question_query) or die(mysqli_error($conn));
            $recode = $result->fetch_assoc();
            $qid = $recode['qid'];

            // row insert
            for ($j = 0; $j < count($question->row); $j++) {

                $row = $question->row[$j];

                $question_query = "insert into question (surveyid, qnum, qcontent, qgroup, type) values ($surveyid, {$row->exam_index} , '{$row->content}', $qid, '{$question->type}')";
                echo $question_query;
                $conn->query($question_query) or die(mysqli_error($conn));


            }

            // colum insert
            for ($l = 0; $l < count($question->colum); $l++) {

                $colum = $question->colum[$l];

                $question_query = "insert into choice (cnum, choicecontent, weighting, qid) values ({$colum->exam_index}, '{$colum->content}', {$colum->exam_index}, {$qid})";
                echo $question_query;
                $conn->query($question_query) or die(mysqli_error($conn));
            }

        } // 드롭다운 일 경우
        else if ($question->type == 'dropdown') {

            // question table에 insert
            $question_query = "insert into question (surveyid, qnum, qindex, qcontent, requirecheck, type) values ($surveyid, {$question->num} , {$question->index},'{$question->question_content}', 0, '{$question->type}')";
            $conn->query($question_query) or die(mysqli_error($conn));

            // 문제 아이디 쿼리 해오기
            $question_query = "select qid from question where surveyid={$surveyid} and qindex={$question->index}";
            $result = $conn->query($question_query) or die(mysqli_error($conn));
            $recode = $result->fetch_assoc();
            $qid = $recode['qid'];


            // 문제 보기입력
            for ($j = 0; $j < count($question->example); $j++) {

                $example = $question->example[$j];
                $exam_query = "insert into choice (cnum, choicecontent, qid) values ($example->exam_index, '{$example->content}', {$qid})";
                $conn->query($exam_query);
            }

        } else if ($question->type == 'imageSelect') {

            // question table에 insert
            $question_query = "insert into question (surveyid, qnum, qindex, qcontent, requirecheck, type) values ($surveyid, {$question->num} , {$question->index},'{$question->question_content}', 0, '{$question->type}')";
            $conn->query($question_query) or die(mysqli_error($conn));

            // 문제 아이디 쿼리 해오기
            $question_query = "select qid from question where surveyid={$surveyid} and qindex={$question->index}";
            $result = $conn->query($question_query) or die(mysqli_error($conn));
            $recode = $result->fetch_assoc();
            $qid = $recode['qid'];

            // 문제 보기입력
            for ($j = 0; $j < count($question->example); $j++) {

                $example = $question->example[$j];
                $exam_query = "insert into choice (cnum, choicecontent, qid) values ($example->exam_index, '{$example->content}', {$qid})";
                $conn->query($exam_query);
                $image_query = "insert into q_image (imagepath, qid) values ('{$example->image}', {$qid})";
                $conn->query($image_query);
            }

        } else if ($question->type == 'singleTextbox') {
            // question table에 insert
            $question_query = "insert into question (surveyid, qnum, qindex, qcontent, requirecheck, type) values ($surveyid, {$question->num} , {$question->index},'{$question->question_content}', 0, '{$question->type}')";
            $conn->query($question_query) or die(mysqli_error($conn));
        } else if ($question->type == 'date') {
            // question table에 insert
            $question_query = "insert into question (surveyid, qnum, qindex, qcontent, requirecheck, type) values ($surveyid, {$question->num} , {$question->index},'{$question->question_content}', 0, '{$question->type}')";
            $conn->query($question_query) or die(mysqli_error($conn));
        } else if ($question->type == 'text') {
            // question table에 insert
            $question_query = "insert into question (surveyid, qindex, qcontent, type) values ($surveyid, {$question->index},'{$question->question_content}', '{$question->type}')";
            $conn->query($question_query) or die(mysqli_error($conn));
        } else if ($question->type == 'image') {
            // question table에 insert
            $question_query = "insert into question (surveyid, qindex, type) values ($surveyid, {$question->index},'{$question->type}')";
            $conn->query($question_query) or die(mysqli_error($conn));

            // 문제 아이디 쿼리 해오기
            $question_query = "select qid from question where surveyid={$surveyid} and qindex={$question->index}";
            $result = $conn->query($question_query) or die(mysqli_error($conn));
            $recode = $result->fetch_assoc();
            $qid = $recode['qid'];

            $image_query = "insert into q_image (imagepath, qid) values ('{$question->image}', {$qid})";
            $conn->query($image_query);
        }
    }
?>