<?php
class Friend_model  extends CI_Model
{
    function __construct(){
        parent::__construct();
    }
    //친구 검색창에 들어갈 쿼리
  
    //유저의 친구정보검색
 

   //친구인지 아닌지검색
    public function FriendSearch($f_num,$m_num){
        $sql = "SELECT * FROM friends  WHERE  f_num=$f_num AND m_num=$m_num";
        return $this->db->query($sql)->result();


    }
    
    public function myFriendSearch($m_num){
        $sql = "SELECT * FROM friends WHERE f_num = ".$m_num." OR m_num = ".$m_num;
        
        return $this->db->query($sql)->result_array();
    }
    
    // 친구신청
    public function insertMember($f_num,$m_num){

        $sql="INSERT INTO friends(f_num,m_num) VALUE ('{$f_num}','{$m_num}') ";
        $this->db->query($sql);
        

    }
    //친구삭제
    public function deleteFriend(){

    }
}