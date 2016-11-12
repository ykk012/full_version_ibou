<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Friend extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('Friend_model');
        $this->load->model('Member_model');
         $this->load->library('session');
    }
    
    public function index(){
        
        $loginInfo = $this->session->userdata('loginInfo');
        
        $result = null;
        
        $data['list']=$result;
   
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->view('_templates/top');
        $this->load->view('Friend/index', $data);
        $this->load->view('_templates/body');
    
        
    }
    public function MyFriend()
    {
        $loginInfo = $this->session->userdata('loginInfo');
        
        $result = $this->Friend_model->myFriendSearch($loginInfo->m_num);
        
        $friendsData = null;
        $tmpArr = null;
        $cnt = 0;
        foreach($result as $key){
            if($key['f_num'] == $loginInfo->m_num){
                $tmpArr[$cnt] = $key['m_num'];
            }else{
                $tmpArr[$cnt] = $key['f_num'];
            }
            $cnt++;
        }
        $tmpArr = array_unique($tmpArr);
        
        $cnt = 0;
        foreach($tmpArr as $key){
            $friendsData[$cnt] = $this->Member_model->selectMemberByMnumAsArray($key);
            $cnt++;
        }
        
        
        
        echo json_encode($friendsData);
    }


    public function Delete_Friend()
    {

    }
    public function Insert_Friend()
      {
        $m_num=$_SESSION['loginInfo']->m_num;
        $id = $_POST['id'];
        $serchID=$_POST['serchID'];
        $fnum = $this->Member_model->MemberSearch($id);
        foreach($fnum as $key=> $user){
            $f_num=$user->m_num;
        }
        
        
        $trueFriend=$this->Friend_model->FriendSearch($f_num,$m_num);
        //if 문으로 유저다시찾아서 친구되어있으면 안되게
        if($trueFriend){
            $result = $this->Member_model->FriendSearch($serchID);
            $data['list'] = $result;
            $data['ID'] = $serchID ;
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->view('_templates/top');
            $this->load->view('Friend/index', $data);
            $this->load->view('_templates/body');
         
            echo"<script>alert('이미 친구관계 입니다.');</script>";
        }
        
        else {
            $result = $this->Member_model->FriendSearch($serchID);
            $data['list'] = $result;
            $data['ID'] = $serchID ;
            $this->Friend_model->insertMember($f_num,$m_num);
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->view('_templates/top');
            $this->load->view('Friend/index', $data);
            $this->load->view('_templates/body');
          
            echo"<script>alert('성공');</script>";
        }
        
    }

}