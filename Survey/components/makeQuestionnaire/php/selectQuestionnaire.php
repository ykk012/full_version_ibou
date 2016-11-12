<?php
// 유저 id로 된 모든 설문지를 가져오기
$data = json_decode(file_get_contents("php://input"));

// db연동
include('../../../php/config.php');

    $sid                = $data->s_num;


$sid_query          = "select * from question where surveyid={$sid}";
$result             = $conn->query($sid_query) or die(mysqli_error($conn));
$submit_data        = array();
$temp_data          = array();


// 문제마다 보기 설정.
while($recode = $result->fetch_assoc()){
    $qid                = $recode['qid'];
    $temp               = array();
    $example            = array();
    $img                = array();


    // 문제의 유형이 보기가 있을 경우 보기 가져 오기
    if($recode['type'] == 'multiple' || $recode['type'] == 'dropdown' || $recode['type'] == 'imageSelect'){

        // 문제에 해당하는 보기값 입력
        $eid_query = "select * from choice where qid={$qid}";
        $e_result  = $conn->query($eid_query) or die(mysqli_error($conn));


        while($e_recode = $e_result->fetch_assoc()){
            $temp[] = $e_recode;
        }

        // index 변환
        for( $i = 0 ; $i < count($temp); $i++ ){
            $example[$i]['content']     = $temp[$i]['choicecontent'];
            $example[$i]['exam_index']  = $temp[$i]['cnum'];

        }



        $recode['example'] = $example;

    }

    // 메트릭스 상위 문제 가져오기
    else if($recode['type'] == 'matrix' && $recode['qindex'] != null){

        // matrix 가져오기의 하위 문제 가져오기
        $eid_query          = "select * from question where surveyid={$sid} and type = 'matrix' and qindex is null and qgroup = {$qid}";
        $e_result           = $conn->query($eid_query) or die(mysqli_error($conn));

        // 배열에 저장
        while($e_recode = $e_result->fetch_assoc()){
            $temp[] = $e_recode;
        }

        for($i = 0 ; $i < count($temp) ; $i++){
            // row에 입력하기
            $example[$i]['content']    = $temp[$i]['qcontent'];
            $example[$i]['exam_index'] = $temp[$i]['qnum'];
        }

        $recode['row']   = $example;

        // 컬럼 입력
        $temp            = array();
        $example         = array();

        //
        $eid_query          = "select * from choice where qid={$qid}";
        $e_result           = $conn->query($eid_query) or die(mysqli_error($conn));

        // 배열에 저장
        while($e_recode = $e_result->fetch_assoc()){
            $temp[] = $e_recode;
        }

        for($i = 0 ; $i < count($temp) ; $i++){
            // row에 입력하기
            $example[$i]['content']    = $temp[$i]['choicecontent'];
            $example[$i]['exam_index'] = $temp[$i]['cnum'];
        }


        // 최종 셋팅
        $recode['colum'] = $example;

    }

    // 하위 문제 건너 뛰기
    else if($recode['type'] == 'matrix' && $recode['qindex'] == null){
        continue;

    }

    $temp_data[] = $recode;
}


// index 변환
for( $i = 0 ; $i < count($temp_data); $i++ ){
    $submit_data[$i]['qid']                 = $temp_data[$i]['qid'];
    $submit_data[$i]['num']                 = intval($temp_data[$i]['qnum']);
    $submit_data[$i]['index']               = $temp_data[$i]['qindex'];
    $submit_data[$i]['question_content']    = $temp_data[$i]['qcontent'];
    $submit_data[$i]['important']           = $temp_data[$i]['requirecheck'];
    $submit_data[$i]['type']                = $temp_data[$i]['type'];
    $submit_data[$i]['template']            = $temp_data[$i]['type'].".html";
    $submit_data[$i]['makeShow']            = false;
    $submit_data[$i]['viewShow']            = true;
    $submit_data[$i]['logicX']              = 200;
    $submit_data[$i]['logicY']              = 0;

    if($temp_data[$i]['type'] == 'multiple' || $temp_data[$i]['type'] == 'dropdown' || $temp_data[$i]['type'] == 'imageSelect') {
        $submit_data[$i]['example'] = $temp_data[$i]['example'];
    }
    else if($temp_data[$i]['type'] == 'matrix' && $temp_data[$i]['qgroup'] == null){
        $submit_data[$i]['row'] = $temp_data[$i]['row'];
        $submit_data[$i]['colum'] = $temp_data[$i]['colum'];
    }

}

// 결과 response
$json_response                      = json_encode($submit_data);
echo $json_response;
?>