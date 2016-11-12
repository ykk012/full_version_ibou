<?php

class Test_model extends CI_Model{

    function __construct()
    {
        parent::__construct();
    }


    function getData($m_num){
        $sql = "SELECT * FROM files f,member m WHERE ( f.m_num = m.m_num ) AND f.m_num = ".$m_num;

        return $this->db->query($sql)->result();
    }
    function getFilesBySort($where,$m_num){
        $sql = "SELECT * FROM files f,member m WHERE ( f.m_num = m.m_num ) AND f.m_num = ".$m_num.$where;

        return $this->db->query($sql)->result();
    }
    function getShare($m_num){
    	  $sql = " SELECT f.f_num, m.m_id, f.f_origin_name,f.f_saved_name,f.f_path,f.f_ext,f.f_upload_date,f.f_share_nums ";
    	  $sql .= " FROM member m, files f INNER JOIN m_f_rel mf ON mf.f_num = f.f_num ";
    	  $sql .= " WHERE f.m_num = m.m_num ";
    	  $sql .= " AND  f.m_num != mf.m_num ";
          $sql .= " AND mf.m_num = ".$m_num;
        return $this->db->query($sql)->result();
    }
    function getShareBySort($where,$m_num){
    	  $sql = " SELECT f.f_num, m.m_id, f.f_origin_name,f.f_saved_name,f.f_path,f.f_ext,f.f_upload_date,f.f_share_nums ";
    	  $sql .= " FROM member m, files f INNER JOIN m_f_rel mf ON mf.f_num = f.f_num ";
    	  $sql .= " WHERE f.m_num = m.m_num ";
    	  $sql .= " AND  f.m_num != mf.m_num ";
          $sql .= " AND mf.m_num = ".$m_num;
          $sql .=$where;   
        return $this->db->query($sql)->result();
    }
    function getKeywordsInFile($f_num){
        $sql = " SELECT w.w_num, w.w_name, w.w_contents, k.k_word, k.k_created_date ";
        $sql .= " FROM workbench w, keywords k INNER JOIN f_k_rel fk ON k.k_num = fk.k_num ";
        $sql .= " WHERE k.w_num = w.w_num ";
        $sql .= " AND fk.f_num = ".$f_num;
        return $this->db->query($sql)->result();
    }
    
    function getBenchData($m_num){
        $sql = "SELECT f.f_origin_name, f.f_saved_name, f.f_num, f.f_ext, m.m_id FROM files f, m_f_rel mf, member m WHERE mf.f_num = f.f_num AND f.m_num = m.m_num AND mf.m_num = ".$m_num;

        return $this->db->query($sql)->result_array();
    }

    

// 추후 공유 부분에서 공유시 데이터 삭제권한 추가해야함 OWNER 칼럼 이용
    function deleteMicro($f_num,$m_num){
        $sql = "DElETE FROM files WHERE m_num = ".$m_num." AND f_num =".$f_num;

        return $this->db->query($sql);
    }
    function insertData($data,$m_num){
        $datestring = "%Y-%m-%d %h:%i %a";


        $insert_data = array(

            'f_origin_name'=>str_replace(" ","_",$data['upload_data']['client_name']),
            'f_saved_name'=>$data['upload_data']['file_name'],
            'f_ext' => $data['upload_data']['file_ext'],
            'f_path'=>$data['upload_data']['file_path'],
            'f_upload_date'=>date('Y-m-d'),
            'f_share_nums'=>0 ,
            'm_num' => $m_num

        );

        $this->db->insert('files',$insert_data);
        return $this->db->insert_id();
    }
    function  getSaveNameByFnum($myMnum,$f_num){
        $sql = " SELECT f_saved_name ";
        $sql .= " FROM files ";
        $sql .= " WHERE m_num = ".$myMnum;
        $sql .= " AND f_num = ".$f_num;
        
        $get_saved_names= $this->db->query($sql)->result();
        
        $f_saved_name = $get_saved_names[0]->f_saved_name;

        return $f_saved_name;
    }
    function getSaveNameFromM_FByFnum($f_num){

        $sql = " SELECT f.f_saved_name,f.f_origin_name ";
        $sql .= " FROM files f, m_f_rel m_f WHERE ";
        $sql .= " (f.f_num = m_f.f_num )";
        $sql .= " AND f.f_num = ".$f_num;

        $get_names= $this->db->query($sql)->result();


        return $get_names[0];
    }
    function getSaveNameBykeyword($k_num,$m_num){

        $sql = " SELECT f.f_saved_name ";
        $sql .= " FROM files f, f_k_rel f_k WHERE ( f.f_num = f_k.f_num  ) ";
        $sql .= " AND f_k.k_num = ".$k_num;

        $get_saved_names= $this->db->query($sql)->result();

        $f_saved_name = $get_saved_names[0]->f_saved_name;

        return $f_saved_name;
    }
    function getCountByFname($f_origin_name,$m_num){
        $sql = "SELECT count(*) as cnt ";
        $sql .= " FROM files f, f_k_rel f_k WHERE ( f.f_num = f_k.f_num ) ";
        $sql .= " AND f_origin_name like '".$f_origin_name."' ";

        return $this->db->query($sql)->result()[0]->cnt;
    }
    // 추후 공유 부분에서 공유시 데이터 삭제권한 추가해야함 OWNER 칼럼 이용

    function selectFnumByFname($f_origin_name,$m_num){
        $sql = " SELECT f_num ";
        $sql .= " FROM files WHERE ";
        $sql .= " f_origin_name like '".$f_origin_name."'"." AND m_num = ".$m_num;

        $get_fnum= $this->db->query($sql)->result();

        $f_num = $get_fnum[0]->f_num;
        return $f_num;
    }
    
    public function selectFilesByOriginName($f_origin_name){
        $sql = "SELECT * FROM files WHERE f_origin_name like '".$f_origin_name."' ";
        return $this->db->query($sql)->result();

    }
    public function insertf_k_rel($f_num,$k_num){
    	

        $sql = "INSERT IGNORE INTO f_k_rel (f_num,k_num) VALUES (".$f_num." , ".$k_num." )";
        
        return $this->db->query($sql);
        
    }
    public function insertm_f_rel($f_num,$m_num){
    	


        $sql = "INSERT IGNORE INTO m_f_rel (f_num,m_num) VALUES (".$f_num." , ".$m_num." )";
        
        return $this->db->query($sql);
        
    }
    function updateShareNums($f_num){
        $sql = "UPDATE files SET f_share_nums = (f_share_nums+1) WHERE f_num =".$f_num;

        return $this->db->query($sql);
    }
    function checkOwnerByMnum($m_num){
        $sql = "SELECT m_num FROM files WHERE m_num like '".$m_num."'";

        return $this->db->query($sql)->result()[0];
    }
    function getMnumById($m_id){
        $sql = "SELECT m_num FROM member WHERE m_id like '".$m_id."'";

        return $this->db->query($sql)->result();
    }
    
    /*function getUploadDate($date,$m_num){
        $sql = "SELECT * FROM files WHERE date(f_upload_date) >= date(subdate("
    }*/
   
}


?>