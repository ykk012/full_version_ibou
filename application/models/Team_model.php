<?php

class Team_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
//팀 만들기
    public function MakeTeam($TeamName,$m_num)
    {

        $sql = "INSERT INTO team(t_name) VALUE ('{$TeamName}') ";
        $this->db->query($sql);
        //오토인크리먼트 처뻔째 꺼 + m_num 저장해야됨.
        $result = $this->db->insert_id();
    
        $sql = "INSERT INTO t_m_rel(m_num,t_num,t_auth) VALUE('$m_num','$result','1') ";
        $this->db->query($sql);
    }
    //팀에 멤버넣기
    public function insert_TeamMember($t_num,$m_num){
        $sql="INSERT INTO t_m_rel(t_num,m_num,t_auth) VALUE ('{$t_num}','{$m_num}','0') ";
        $this->db->query($sql);

    }
    //팀에소속된 애들찾기
    public function TeamMemberJoin($t_num){
        $sql="select m.m_name from member m, t_m_rel t where m.m_num=t.m_num AND t.t_num='".$t_num."' order by t.t_auth desc";
        return $this->db->query($sql)->result();
    }

    //유저의 m_num으로 팀이름찾는 쿼리
    public function SelectTeamNameJoin($m_num){
        $sql = "select t.t_name from team t, t_m_rel r  where t.t_num=r.t_num AND r.m_num='".$m_num."'";
        $query = $this->db->query($sql);
		$number_of_rows = ceil($query->num_rows()/3);
        $result[]=array();
        for($i = 0 ; $i < $number_of_rows; $i++){
            $sql = "select t.t_name from team t, t_m_rel r  where t.t_num=r.t_num AND r.m_num='".$m_num."' limit ".strval($i*3)." , 3 ";
            $result[$i] = $this->db->query($sql)->result();
            
        }
        
        return $result;
    }
    
    public function getTeamList($m_num){
        $sql = "SELECT t.t_name, t.t_num FROM team t, t_m_rel tm WHERE t.t_num = tm.t_num AND tm.m_num = ".$m_num;
        return $this->db->query($sql)->result_array();
    }
    
     public function SelectTeamJoin($m_num){
       
        $sql = "select t.t_name from team t, t_m_rel r  where t.t_num=r.t_num AND r.m_num='".$m_num."'";
        return $this->db->query($sql)->result();
      
    }
    
    
     public function SelectTeamNameTnum($t_num){
        $sql="select t_name from team where t_num='".$t_num."'";
        return $this->db->query($sql)->result();
    }
    //팀이름 수정용 쿼리 팀번호가져와서 수정
    public function SelectTeamName($TeamName){
        $sql = "select t_num from team  where t_name= '".$TeamName."'";
        return $this->db->query($sql)->result();
    }
    //관리자인지 아닌지찾기
    public function Serach_auth($t_num,$m_num){
        $sql="select t_auth from t_m_rel where t_num='".$t_num."' and m_num='".$m_num."'";
        return $this->db->query($sql)->result();
    }
      public function Serach_m_num($t_num,$m_num){
        $sql="select m_num from t_m_rel where t_num='".$t_num."' and m_num='".$m_num."'";
        return $this->db->query($sql)->result();
    }
    


    public function UpdateTeamName($TeamName,$t_num){
        $sql = "UPDATE team SET t_name='".$TeamName."' WHERE t_num='".$t_num."'";
        $this->db->query($sql);

    }
    //팀 지우면서 소속된애들까지지우는거
    public function deleteTeam($t_num){
        $sql = "DELETE FROM team WHERE t_num='".$t_num."'";
        $this->db->query($sql);
        $sql = "DELETE FROM t_m_rel WHERE t_num='".$t_num."'";
        $this->db->query($sql);
    }


    public function deleteTeamUser($t_num,$m_num){
        $sql = "DELETE FROM t_m_rel WHERE t_num='".$t_num."' AND m_num='".$m_num."'";
        $this->db->query($sql);
    }





}