<?php
/**
 * Created by PhpStorm.
 * User: Leemw
 * Date: 2015-06-08
 * Time: 오후 11:25
 */
    $data = json_decode(file_get_contents("php://input"));

    // db연동
    include('../../../php/config.php');

    $json_response = json_encode($data);
    echo $json_response;
    // user의 아이디
    $s_num            = $data;


    $query = "delete from survey where s_num={$s_num}";
    $result = $conn->query($query) or die(mysqli_error($conn));



    $query      = "select * from question where surveyid={$s_num}";
    $result     =  $conn->query($query) or die(mysqli_error($conn));
    $json_response = json_encode($result);
    while ($recode = $result->fetch_assoc()) {
        $qid = $recode['qid'];

        $sub_query = "delete from choice where qid={$qid}";
        $sub_result = $conn->query($sub_query) or die(mysqli_error($conn));

    }

    $query = "delete from question where surveyid={$s_num}";
    $result = $conn->query($query) or die(mysqli_error($conn));

    $query = "delete from panel where s_num={$s_num}";
    $result = $conn->query($query) or die(mysqli_error($conn));

    $query = "delete from result where surveyid={$s_num}";
    $result = $conn->query($query) or die(mysqli_error($conn));











?>