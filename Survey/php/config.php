<?php

class Db_info {
    const db_url        = "localhost";
    const user_id       = "root";
    const passwd        = "";
    const db            = "ibou";
}

$conn = new mysqli(Db_info::db_url, Db_info::user_id, Db_info::passwd, Db_info::db);

$conn->set_charset("utf8");

if($conn->connect_errno){
    echo "Failed to connect to MySQL : ". $conn->connect_error;
}




?>
