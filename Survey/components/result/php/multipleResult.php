<?php

function multiple_Query($conn, $surveyid, $qid) {

    $multipleCCountArray    = array();

    // 결과 테이블에서 문제에 객관식 선택 갯수, 보기내용 가져오기
    $qry3 = $conn->query("select r.surveyid, r.qid, c.cnum, c.choicecontent, r.chk_ob, count(r.chk_ob)
                                      from result r, (select cnum, choicecontent from choice where qid={$qid}) c
                                      where s_num={$surveyid} and qid={$qid} and (c.cnum = r.chk_ob)
                                      group by chk_ob");
    while( $res = $qry3->fetch_assoc()) {
        $tempArray = array(
            "choiceCount"   => (int)$res['count(r.chk_ob)'],
            "choiceContent" => $res['choicecontent']
        );
        array_push($multipleCCountArray, $tempArray);
    }

    //Array 3개 묶어서 return
    //$tripleArray = array("merge" => $multipleCCountArray);

    return $multipleCCountArray;
}

function dateGraph_Query($conn, $surveyid, $qid) {

    $dateCCountArray    = array();

    // 결과 테이블에서 날짜와 날짜별 선택갯수 가져오기
    $qry3 = $conn->query("select count(chk_date), chk_date from result
                      where s_num={$surveyid} and qid={$qid} group by chk_date order by chk_date");

    while( $res = $qry3->fetch_assoc()) {
        $tempArray = array(
            "date" => $res['chk_date'],
            "Count" => $res['count(chk_date)']
        );
        array_push($dateCCountArray, $tempArray);
    }

    return $dateCCountArray;
}

function imgSelect_Query($conn, $surveyid, $qid) {

    $imgCCountArray    = array();

    // 결과 테이블에서 문제에 객관식 선택 갯수, 보기내용 가져오기
    $qry3 = $conn->query("select r.surveyid, r.qid, c.cnum, c.choicecontent, r.chk_ob, count(r.chk_ob)
                                      from result r, (select cnum, choicecontent from choice where qid={$qid}) c
                                      where s_num={$surveyid} and qid={$qid} and (c.cnum = r.chk_ob)
                                      group by chk_ob");

    $tempArray["name"] = 'gg';

    while( $res = $qry3->fetch_assoc()) {
        $tempArray[] = (int)$res['count(r.chk_ob)'];
    }
    array_push($imgCCountArray, $tempArray);
    return $imgCCountArray;
}

function subInline_Query($conn, $surveyid, $qid) {

    $subInlineCCountArray    = array();

    // 결과 테이블에서 주관식 문제 쿼리해서 가져오기
    $qry3 = $conn->query("select chk_sub from result where surveyid={$surveyid} and qid={$qid}");


    while( $res = $qry3->fetch_assoc()) {
        $count = 1;
        $subInlineCCountArray = array(
            "num" => $count++,
            "Content" => $res['chk_sub']
        );
        array_push($subInlineCCountArray, $tempArray);
    }

    return $subInlineCCountArray;
}

function matrix_Query($conn, $surveyid, $qid) {

    $matrixCCountArray    = array();

    // 결과 테이블에서 보기의 각 선택 갯수
    $qry = $conn->query("select r.surveyid, q.qcontent as content, r.qid, count(r.qid)
                                      from result r, (select qcontent, qid
                                                      from question
                                                      where surveyid={$surveyid} and type = 'matrix'
                                                            and qindex is null and qgroup = {$qid}) q
                                      where s_num={$surveyid} and (q.qid = r.qid)
                                      group by r.qid");

    while( $res = $qry->fetch_assoc()) {
        $tempArray = array(
            "choiceCount"   => (int)$res['count(r.qid)'],
            "choiceContent" => $res['content']
        );
        array_push($matrixCCountArray, $tempArray);
    }

    return $matrixCCountArray;
}

// 유저 id로 된 모든 설문지를 가져오기
$data = json_decode(file_get_contents("php://input"));

// db연동
include('../../../php/config.php');

$sid                = $data->sid;

$sid_query          = "select * from question where s_num={$sid}";
$result             = $conn->query($sid_query) or die(mysqli_error($conn));
// 문제id
$temp               = array();

while($recode = $result->fetch_assoc()) {
    $temp[] = $recode;
}

$sending_data = array();

for($i = 0 ; $i < count($temp) ; $i++){
    $qid = $temp[$i]['qid'];

    if($temp[$i]['type'] == "multiple"){
        $sending_data['multiple'] = multiple_Query($conn, $sid, $qid);
        break;
    }
}

// 결과 response
$json_response = json_encode($sending_data);
echo $json_response;



?>
