<?php
	// 계정 관리에 관한 클래스, 로그인 / 회원가입 / ID, PW 찾기 기능(미구현) / 비밀번호 변경
	class Member_model extends CI_Model {
		function __construct(){
			parent::__construct();
		}
		
		public function insertMember($mInfo){
		
			$insert_data=array(
				'm_id'=>$mInfo->m_id,
				'm_pwd'=>$mInfo->m_pwd,
				'm_name' => $mInfo->m_name

			);
			$this->db->insert('member',$insert_data);
			return $insert_id = $this->db->insert_id();
			
		}
		public function selectMemberByMnum($m_num){
			$sql = "SELECT * FROM member WHERE  m_num = ".$m_num;
			return $this->db->query($sql)->result();
		}
		public function selectMemberByMnumAsArray($m_num){
			$sql = "SELECT m_num, m_id FROM member WHERE  m_num = ".$m_num;
			$result = $this->db->query($sql)->result_array();
			return $result[0];
		}
		public function selectIDById($m_id){
			$sql = "SELECT m_id FROM member WHERE  m_id like '". $m_id ."' ";
			return $this->db->query($sql)->result();
		}
		public function selectPWDByPwd($m_pwd){
			$sql = "SELECT m_pwd FROM member WHERE  m_pwd like '". $m_pwd ."' ";
			return $this->db->query($sql)->result();
		}
		
		public function updatePwd($m_pwd,$m_num){
			$sql = "UPDATE member SET m_pwd = '".$m_pwd."' WHERE m_num = ".$m_num;
			return $this->db->query($sql);
		}
		public function updateName($m_name,$m_num){
			$sql = "UPDATE member SET m_name = '".$m_name."' WHERE m_num = ".$m_num;
			return $this->db->query($sql);
		}
		public function deleteMemberByMnum($m_num){
			$sql = "DELETE FROM member WHERE m_num = ".$m_num;
			return $this->db->query($sql);
		}
		public function checkLogin($m_id,$m_pwd){
			$sql = "SELECT * FROM member WHERE  m_id like '". $m_id ."' AND m_pwd like '". $m_pwd . "'";
			return $this->db->query($sql)->result();
		}
	
		//친구찾는거
		public function FriendSearch($id){
			$sql = "SELECT m_id FROM member WHERE  m_id like '%". $id ."%' ";
			return $this->db->query($sql)->result();
		}
		
		//친구 insert용 쿼리 M_num버값 찾는거
		public function MemberSearch($id){
			$sql = "SELECT m_num FROM member WHERE  m_id like '". $id ."' ";
			return $this->db->query($sql)->result();
		}
		//이름으로 이름찾는거
		public function MemberSearch_name($id){
			$sql = "SELECT m_num FROM member WHERE  m_name like '". $id ."' ";
			return $this->db->query($sql)->result();
		}
		
		
		//팀생성시 친구테이블m_num으로 친구이름 찾는 조인 쿼리문
		public function MyFriendsSearch($m_num){
			$sql = "SELECT m_id FROM member m,friends f WHERE  m.m_num=f.f_num AND f.m_num='".$m_num."'";
			return $this->db->query($sql)->result();
		}
		
		public function SearchID($m_num){
			$sql = "SELECT m_name FROM member WHERE  m_num like '". $m_num ."' ";
			return $this->db->query($sql)->result();
		}
		




	
		
	}
?>
