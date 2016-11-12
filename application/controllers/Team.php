<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Team extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('Team_model');
        $this->load->model('Member_model');
         $this->load->library('session');
    }

    public function index(){
        
  
        $m_num=$_SESSION['loginInfo']->m_num;

        $data['list']=$this->Team_model-> SelectTeamNameJoin($m_num);
        
       
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->view('_templates/top');
        $this->load->view('team/team',$data);
        $this->load->view('_templates/body');
        $this->load->view('_templates/bottom');
    }
    
    public function Make_team()
    {
       
        $data['TeamName'] = $_POST['TeamName'];
        $m_num=$_SESSION['loginInfo']->m_num;
        $TeamName=$data['TeamName'];
      
        $this->Team_model->MakeTeam($TeamName,$m_num);

        $data['list']=$this->Team_model-> SelectTeamNameJoin($m_num);
       
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->view('_templates/top');
        $this->load->view('team/team',$data);
        $this->load->view('_templates/body');
        $this->load->view('_templates/bottom');

    }
     public function moblie_Make_team()
    {
        $rawBody = file_get_contents("php://input"); // 본문을 불러옴
        $data =json_decode($rawBody);
        
        // $m_num=7;//수정하셈
        //$m_num=$_SESSION['loginInfo']->m_num;
     
        $this->Team_model->MakeTeam($data->t_name,$m_num); //디비저장
        
        $data['list']=$this->Team_model-> SelectTeamNameJoin($m_num); //디비에저장된 팀불러옴
        
        echo json_encode($data['list']);


    }
    

    public function Team_Mpage()
    {   
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->view('_templates/top');
        $this->load->view('team/make_Team');
        $this->load->view('_templates/bottom');
    }

    //팀생성후 친구보여주는거
    public function Team_Friendsinsert()
    {
        $id=$_POST['id'];
        $t_num=$_POST['t_num'];
        $m_num=$this->Member_model-> MemberSearch($id);
        $m_num=$m_num[0]->m_num;
        $memberdata=$this->Team_model->Serach_m_num($t_num,$m_num);




        if($memberdata){
            $m_num=$_SESSION['loginInfo']->m_num;
            $data['list']=$this->Team_model-> SelectTeamNameJoin($m_num);
            $data['f_list']=$this->Member_model->MyFriendsSearch($m_num);
            $team_name=$this->Team_model->SelectTeamNameTnum($t_num);
            $data['team_name']=$team_name[0]->t_name;
            $data['user_name']=$this->Member_model->SearchID($m_num);
            $user_ID=$data['user_name'];//유저아이디
            $data['user_name']=$user_ID[0]->m_name;
            $data['t_member']=$this->Team_model->TeamMemberJoin($t_num);
            $data['t_list']=$this->Team_model-> SelectTeamJoin($m_num);

            $data['t_num']=$t_num;
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->view('_templates/top');
            $this->load->view('team/make_TeamAdmin',$data);
            $this->load->view('_templates/bottom');
            echo"<script>alert('이미 초대된 회원입니다.');</script>";

        }
        else{
            $this->Team_model-> insert_TeamMember($t_num ,$m_num);

            $m_num=$_SESSION['loginInfo']->m_num;
            $data['list']=$this->Team_model-> SelectTeamNameJoin($m_num);
            $data['f_list']=$this->Member_model->MyFriendsSearch($m_num);
            $team_name=$this->Team_model->SelectTeamNameTnum($t_num);
            $data['team_name']=$team_name[0]->t_name;
            $data['user_name']=$this->Member_model->SearchID($m_num);
            $user_ID=$data['user_name'];//유저아이디
            $data['user_name']=$user_ID[0]->m_name;
            $data['t_member']=$this->Team_model->TeamMemberJoin($t_num);
            $data['t_list']=$this->Team_model-> SelectTeamJoin($m_num);

            $data['t_num']=$t_num;
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->view('_templates/top');
            $this->load->view('team/make_TeamAdmin',$data);
            $this->load->view('_templates/bottom');
            echo"<script>alert('초대 완료');</script>";

        }
    }

    //팀생성
    
    //팀관리페이지
    public function Team_info(){
        $m_num=$_SESSION['loginInfo']->m_num;//이거 지우셈 로그인유저 m_num임
        //유저 친구 서치 만드셈.
        $data['team_name'] = $_POST['team_name'];
        $TeamName= $data['team_name'];
        $t_num=$this->Team_model->SelectTeamName($TeamName);
        $t_num=$t_num[0]->t_num;
        $t_auth=$this->Team_model->Serach_auth($t_num,$m_num);
        $t_auth= $t_auth[0]->t_auth;

       
        echo"<br>";
        $data['f_list']=$this->Member_model->MyFriendsSearch($m_num);
       

        $data['t_list']=$this->Team_model-> SelectTeamJoin($m_num);
        $data['user_name']=$this->Member_model->SearchID($m_num);
        //
        $data['t_member']=$this->Team_model->TeamMemberJoin($t_num);
  
        $user_ID=$data['user_name'];//유저아이디
        $data['user_name']=$user_ID[0]->m_name;
        
        $data['t_num']=$t_num;
    

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->view('_templates/top');
        if($t_auth=='1'){
        $this->load->view('team/make_TeamAdmin',$data);
        }
        else{
            $this->load->view('team/make_TeamUser',$data);
        }
        $this->load->view('_templates/bottom');
        
    }
    public function Team_NameUpdate(){
        $t_num = $_POST['t_num'];
        $t_name = $_POST['team_name'];
        $this->Team_model->UpdateTeamName($t_name,$t_num);
        $m_num=$_SESSION['loginInfo']->m_num;
        
        $data['f_list']=$this->Member_model->MyFriendsSearch($m_num);
        $team_name=$this->Team_model->SelectTeamNameTnum($t_num);
        $data['team_name']=$team_name[0]->t_name;
        $data['user_name']=$this->Member_model->SearchID($m_num);
        $data['t_member']=$this->Team_model->TeamMemberJoin($t_num);
        $data['t_list']=$this->Team_model-> SelectTeamJoin($m_num);
        $user_ID=$data['user_name'];//유저아이디
        $data['user_name']=$user_ID[0]->m_name;
        $data['t_num']=$t_num;

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->view('_templates/top');
        $this->load->view('team/make_TeamAdmin',$data);
        $this->load->view('_templates/bottom');

    }
    public function Team_delete_team(){
        
        $team['t_name'] = isset($_POST['t_name'])? $_POST['t_name'] :null;
        if($team['t_name']==null){
        $m_num=$_SESSION['loginInfo']->m_num;
        $data['list']=$this->Team_model-> SelectTeamNameJoin($m_num);
       
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->view('_templates/top');
        $this->load->view('team/team',$data);
        $this->load->view('_templates/body');
        $this->load->view('_templates/bottom');
        }
        else{
        
        $TeamName=$team['t_name'];
        $t_num=$this->Team_model->SelectTeamName($TeamName);
        $t_num=$t_num[0]->t_num;
        $this->Team_model->deleteTeam($t_num);

        $m_num=$_SESSION['loginInfo']->m_num;
        $data['list']=$this->Team_model-> SelectTeamNameJoin($m_num);
      
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->view('_templates/top');
        $this->load->view('team/team',$data);
        $this->load->view('_templates/body');
        $this->load->view('_templates/bottom');
        }       
    }
    //유저가 팀탈퇴하는것
    public function Team_delete_user(){
        $team['t_name'] = $_POST['t_name'];
        $TeamName=$team['t_name'];
        $t_num=$this->Team_model->SelectTeamName($TeamName);
        $t_num=$t_num[0]->t_num;
        
        $m_num=$_SESSION['loginInfo']->m_num;
        
       $this->Team_model->deleteTeamUser($t_num,$m_num);

        $data['list']=$this->Team_model-> SelectTeamNameJoin($m_num);
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->view('_templates/top');
        $this->load->view('team/team',$data);
        $this->load->view('_templates/body');
        $this->load->view('_templates/bottom');
    }
    public function user_delete_admin(){
        //값이 null일경우 예외처리 추가
        $t_num= $_POST['t_num'];
        $name=$_POST['name'];

        $m_num=$this->Member_model->MemberSearch($name);
        $m_num=$m_num[0]->m_num;

        $this->Team_model->deleteTeamUser($t_num,$m_num);
        
        $m_num=$_SESSION['loginInfo']->m_num;
        $data['f_list']=$this->Member_model->MyFriendsSearch($m_num);
        $team_name=$this->Team_model->SelectTeamNameTnum($t_num);
        $data['team_name']=$team_name[0]->t_name;
        $data['user_name']=$this->Member_model->SearchID($m_num);
        $data['t_member']=$this->Team_model->TeamMemberJoin($t_num);
        $data['t_list']=$this->Team_model-> SelectTeamJoin($m_num);
        $user_ID=$data['user_name'];//유저아이디
        $data['user_name']=$user_ID[0]->m_name;
        $data['t_num']=$t_num;
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->view('_templates/top');
        $this->load->view('team/make_TeamAdmin',$data);
        $this->load->view('_templates/bottom');
        echo"<script>alert('강퇴 되었습니다.');</script>";
    }

    public function Make_user()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->view('_templates/top');
        $this->load->view('team/make_TeamUser');
        $this->load->view('_templates/bottom');
    }

    public function getTeamList(){
        $loginInfo = $this->session->userdata('loginInfo');
        
        $result = $this->Team_model->getTeamList($loginInfo->m_num);
        
        echo json_encode($result);
    }
}