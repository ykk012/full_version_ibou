<?php

class Workbench_model  extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    public function getWorkbenchList($id){
        $sql = "SELECT w.w_num, w.w_created_date, w.w_name, w.w_contents, m.m_id FROM workbench w, m_w_rel mw, member m WHERE w.w_num = mw.w_num AND w.m_num = m.m_num AND mw.m_num = ".$id;
        $query = $this->db->query($sql);

        return $query->result_array();
    }
    
    public function getTeamWorkbenchList($id){
        $sql = "SELECT w.w_num, w.w_created_date, w.w_name, w.w_contents, m.m_id, t.t_name FROM workbench w, t_w_rel tw, team t, t_m_rel tm, member m WHERE w.w_num = tw.w_num AND tw.t_num = t.t_num AND tw.t_num = tm.t_num AND w.m_num = m.m_num AND tm.m_num = ".$id;
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function getWorkbenchDataAsJSON($id){

        $sql = "SELECT k.k_num, k.k_word, k.k_parent, k.k_depth, k.k_confirmed, fk.a_count FROM keywords k LEFT JOIN "
        ."(SELECT COUNT( * ) AS a_count, k_num FROM f_k_rel GROUP BY k_num )fk ON k.k_num = fk.k_num "
        ."WHERE k.w_num = ".$id." ORDER BY k.k_depth, k.k_num";

        $query = $this->db->query($sql);
        $query = $query->result();

        if($query) {
            $data = array();
            $num = count($query);
            $maxDepth = 0;
            for($i = 0 ; $i < $num ; $i++) {
                $k_num = $query[$i]->k_num;
                $k_word = $query[$i]->k_word;
                $k_parent = $query[$i]->k_parent;
                $k_depth = $query[$i]->k_depth;
                $k_confirmed = $query[$i]->k_confirmed;
                $a_count = $query[$i]->a_count;
                $data[$k_depth][$i]['k_num'] = $k_num;
                $data[$k_depth][$i]['name'] = $k_word;
                $data[$k_depth][$i]['k_parent'] = $k_parent;
                $data[$k_depth][$i]['k_confirmed'] = $k_confirmed;
                $data[$k_depth][$i]['a_count'] = $a_count;
                if($maxDepth < $k_depth)
                    $maxDepth = $k_depth;
            }
            for($i = $maxDepth ; $i > 0 ; $i--) {
                foreach($data[$i-1] as &$key) {
                    $k_num = $key['k_num'];
                    $cnt = 0;
                    foreach($data[$i] as $key2) {
                        if($key2['k_parent'] == $k_num){
                            $key['children'][$cnt] = $key2;
                            $cnt++;
                        }
                    }
                }
                unset($data[$i]);
            }
        }
        
        $sql = "SELECT m_num FROM workbench WHERE w_num =".$id;
        
        $query = $this->db->query($sql);
        
        $result = $query->result_array();
        
        $data[0][1] = $result[0];

        $result = $data[0];
        return $result;
    }

    public function insertNewNode($data){
        $date = date("Y-m-d");
        $sql = "INSERT INTO keywords (w_num, m_num, k_word, k_parent, k_depth, k_created_date, k_edited_date) "
            ."VALUES (".$data['roomName'].", ".$data['userID'].", '".$data['name']."', ".$data['k_parent'].", ".$data['depth'].", '"
            .$date."', '".$date."');";
        $query = $this->db->query($sql);
        $k_num = $this->db->insert_id();

        $sql = "SELECT k_num, k_word, k_parent, k_depth FROM keywords WHERE k_num = ".$k_num;
        $query = $this->db->query($sql);

        if($query->num_rows() > 0)
            $query = $query->result_array();

        $result['k_num'] = $query[0]['k_num'];
        $result['name'] = $query[0]['k_word'];
        $result['k_parent'] = $query[0]['k_parent'];

        return $result;
    }
    
    public function deleteNode($data){
        $sql = "DELETE FROM keywords WHERE k_num = ".$data['k_num'];
        $query = $this->db->query($sql);
    }
    
    public function createNewWorkbench($data){
        $date = date("Y-m-d");
        $sql = "INSERT INTO workbench (m_num, w_name, w_created_date, w_edited_date) VALUES (".$data['m_num'].", '".$data['w_name']."', '".$date."', '".$date."');";
        $query = $this->db->query($sql);
        
        $w_num = $this->db->insert_id();
        
        $sql = "INSERT INTO keywords (w_num, m_num, k_word, k_parent, k_depth, k_created_date, k_edited_date) "
            ."VALUES (".$w_num.", ".$data['m_num'].", '".$data['w_name']."', 0, 0, '"
            .$date."', '".$date."');";
        $query = $this->db->query($sql);
        
        $sql = "INSERT INTO m_w_rel (m_num, w_num) VALUES (".$data['m_num'].", ".$w_num.")";
        $query = $this->db->query($sql);
    }
    
    public function getAttachList($data){
        $sql = "SELECT f.f_origin_name, f.f_saved_name, f.f_ext, f.f_num, m.m_id FROM f_k_rel fk, files f, member m WHERE f.m_num = m.m_num AND fk.f_num = f.f_num AND fk.k_num = ".$data;
        $query = $this->db->query($sql);
        
        $result = $query->result_array();
        
        return $result;
    }
    
    public function createNewVote($data){
        $sql = "INSERT INTO vote (w_num, k_num) VALUES (".$data['workbenchID'].", ".$data['k_num'].")";
        $query = $this->db->query($sql);
        
        $v_num = $this->db->insert_id();
        
        for($i = 0; $i < count($data['candidate']) ; $i++){
            $sql = "INSERT INTO v_k_rel (v_num, k_num) VALUES (".$v_num.", ".$data['candidate'][$i].")";
            $query =$this->db->query($sql);
        }
    }
    
    public function getVoteList($id){
        $sql = "SELECT v.v_num, k.k_word AS v_title, v.v_result AS k_word, v.v_finished FROM vote v, keywords k WHERE v.k_num = k.k_num AND v.w_num = ".$id;
        
        $query = $this->db->query($sql);
        
        $result = $query->result_array();
        if(isset($result[0])){
        for($i = 0 ; $i < count($result) ; $i++){
            if($result[$i]['k_word'] != null){
                $sql = "SELECT k_word FROM keywords WHERE k_num = ".$result[$i]['k_word'];
                $query = $this->db->query($sql);
                
                $k_word = $query->result_array();
                
                $result[$i]['k_word'] = $k_word[0]['k_word'];
            }
        }
        }
        
        return $result;
    }
    
    public function getVoteCandidate($id){
        $sql = "SELECT k.k_num, k.k_word, vk.vk_counts FROM v_k_rel vk, keywords k WHERE vk.k_num = k.k_num AND vk.v_num = ".$id;
        
        $query = $this->db->query($sql);
        
        return $result = $query->result_array();
    }
    
    public function voteCandidate($id){
        $sql = "SELECT vk_counts FROM v_k_rel WHERE k_num = ".$id;
        $query = $this->db->query($sql);
        
        $data = $query->result_array();
        
        $newCount = $data[0]['vk_counts'] + 1;
        
        $sql = "UPDATE v_k_rel SET vk_counts = '".$newCount."' WHERE k_num = ".$id;
        
        $query = $this->db->query($sql);
    }
    
    public function closeVote($id){
        $sql = "SELECT k_num FROM v_k_rel WHERE v_num = ".$id." AND vk_counts = (SELECT max(vk_counts) FROM v_k_rel WHERE v_num = ".$id.")";
        $query = $this->db->query($sql);
        
        $result = $query->result_array();
        
        $sql = "UPDATE vote SET v_finished = 1, v_result = ".$result[0]['k_num']." WHERE v_num = ".$id;
        
        $query = $this->db->query($sql);
        
        $sql = "UPDATE keywords SET k_confirmed = 1 WHERE k_num = ".$result[0]['k_num'];
        
        $query = $this->db->query($sql);
        
        return $result[0];
    }
    
    public function attachFile($data){
        $sql = "INSERT INTO f_k_rel (f_num, k_num) VALUES (".$data['f_num'].", ".$data['k_num'].")";
        
        $this->db->query($sql);
    }
    
    public function shareWbFriend($data){
        $sql = "INSERT IGNORE INTO m_w_rel (m_num, w_num) VALUES (".$data['f_num'].", ".$data['w_num'].")";
        
        $this->db->query($sql);
    }
    
    public function shareWbTeam($data){
        $sql = "INSERT IGNORE INTO t_w_rel (t_num, w_num) VALUES (".$data['t_num'].", ".$data['w_num'].")";
        
        $this->db->query($sql);
    }
}
 ?>
