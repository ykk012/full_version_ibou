<?php
/**
 * Created by PhpStorm.
 * User: SooJu
 * Date: 2015-07-15
 * Time: 오전 9:23
 */

$data = json_decode(file_get_contents("php://input"));

// db연동
include('../../../php/config.php');

$sid                = $data->s_num;

$dataFormatQuery    = "select r.qid, r.panelid, p.gender, p.agegroup, p.area, r.chk_ob
                      from panel p, (select qid, panelid, chk_ob from result where surveyid = {$sid}) r
                      where r.panelid = p.panelid";
$result             = $conn->query($dataFormatQuery) or die(mysqli_error($conn));

$arr                = array();

while($res = $result->fetch_assoc()) {
    $arrTemp = array(
        "qid" => $res['qid'],
        "panelid" => $res['panelid'],
        "gender" => $res['gender']=='man'?'m':'w',
        "agegroup" => $res['agegroup'],
        "area" => $res['area'],
        "chk_ob" => $res['chk_ob']
    );
    array_push($arr, $arrTemp);
}
echo json_encode($arr);

?>