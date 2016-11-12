<?php
function areaCodeConverter($areaCode) {

    switch($areaCode) {
        // html input의 value값을 각 지역번호로 넘기도록 함
        case 20: return "管理";break;
        case 51:return "経営";break;
        case 53:return "金融";break;
        case 32:return "教育";break;
        case 62:return "研究";break;
        case 42:return "法律";break;
        case 52:return "医療";break;
        case 44:return "福祉";break;
        case 31:return "芸術";break;
        case 33:return "運転";break;
        case 43:return "営業";break;
        case 41:return "警備";break;
        case 63:return "美容";break;
        case 61:return "スポーツ";break;
        case 54:return "サービス";break;
        case 55:return "機械・建設";break;
        case 64:return "農業・漁業";break;
        case 65:return "電子・電気";break;
        case 66:return "情報通信";break;
        case 67:return "その他";break;
    }
}

// 현재 설문정보를 가지고
// php 쿼리해오기 응답자수/ 응답 날짜 / 설문정보
// 남녀비율 / 지역 / 나이대 / 응답률/ 날짜 진행도
// 문제별 분석

// 유저 id로 된 모든 설문지를 가져오기
$data = json_decode(file_get_contents("php://input"));

// db연동
include('../../../php/config.php');

$sid            = $data->s_num;
$send_data      = array();

// 설문지 정보 가져오기
$sid_query      = "select * from survey where s_num={$sid}";
$result         = $conn->query($sid_query) or die(mysqli_error($conn));

$recode = $result->fetch_assoc();

$send_data['surveyInfo'] = $recode;

$arrayAdd = array();

// 성별 쿼리
$query = $conn->query("select gender as 'title', count(gender) as 'value' from panel where s_num = {$sid} group by gender;");
$genderArray = array();
while($res = $query->fetch_assoc()) {
    $arrayAdd = array(
        "title" => urlencode($res['title']),
        "value" => (int)$res['value']
    );
    array_push($genderArray, $arrayAdd);
}

$send_data['genderArray'] = $genderArray;

// 지역 투표 수
$query = $conn->query("select area as 'title', count(area) as 'value' from panel where s_num = {$sid} group by area;");
$areaArray = array();
while($res = $query->fetch_assoc()) {
    $arrayAdd = array(
        "title" => areaCodeConverter($res['title']),
        "value" => (int)$res['value']
    );
    array_push($areaArray, $arrayAdd);
}

$send_data['areaArray'] = $areaArray;

// 연령대 투표 수
$query = $conn->query("select agegroup as 'title', count(agegroup) as 'value' from panel where s_num = {$sid} group by agegroup;");
$ageGroupArray = array();
while($res = $query->fetch_assoc()) {
    $arrayAdd = array(
        "title" => $res['title']."代",
        "value" => (int)$res['value']
    );
    array_push($ageGroupArray, $arrayAdd);
}
$send_data['ageGroupArray'] = $ageGroupArray;

// 날짜 쿼리
$query = $conn->query("select count(pdate) as panelNum, pdate from panel where s_num={$sid}  group by pdate;");
$platformLineArray = array();
while($res = $query->fetch_assoc()) {
    $arrayAdd = array(
        "date" => $res['pdate'],
        "panelNum" => (int)$res['panelNum']
    );
    array_push($platformLineArray, $arrayAdd);
}

$send_data['platformLineArray'] = $platformLineArray;


// 설문지
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

        // 이미지 셀렉트 형일 경우 이미지를 가져오기


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


$send_data['submit_data'] = $submit_data;


// 결과 response
$json_response = json_encode($send_data);
echo $json_response;


?>