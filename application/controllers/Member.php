
<?php
class Member extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
         $this->load->library('session');
        $this->load->model('Member_model');
        
    }
    public function index(){ // 로그인 회원가입 이 보이는 화면으로 이동(메인css수정이끝나면 메인 화면이동으로 수정 해야함)
        $this->load->view('member/home');
    }
    
    public function loginPage(){
        $this->load->view('member/login');
    }
 
    public function login(){
        
        $rawBody = file_get_contents("php://input"); // 본문을 불러옴
        $data =json_decode($rawBody);
     
        $userData = $this->Member_model->checkLogin($data->m_id,$data->m_pwd);
        if(count($userData)==0){
            echo json_encode(false);
        }else{
            
            $this->session->set_userdata('loginInfo', $userData[0]);
        
            $this->load->view('member/loginedpage');
        }
    }
    public function loginedpage(){
        $this->load->view('member/loginedpage');
    }
    public function logout(){
        $this->session->unset_userdata('loginInfo');
        $this->load->view('member/home');
    }
    public function joinpage(){
        $this->load->view('member/join');
    }
    public function joinus()//메서드
    {    
       
            $rawBody = file_get_contents("php://input"); // 본문을 불러옴
            $data =json_decode($rawBody);
            
            if($this->Member_model->selectIDById($data->m_id) ){ //DB에 중복된 아이디가 있는지 검사
          
                $this->load->view('member/join',array('existed_id'=>'이미 아이디가 존재합니다.'));
                return;
            }
            else if($this->Member_model->selectPWDByPwd($data->m_pwd) ){ //DB에 중복된 비밀번호가 있는지 검사
                $this->load->view('member/join',array('existed_pwd'=>'이미 비밀번호가 존재합니다.'));
                return;
                
            }
            
        
            $insert_id = $this->Member_model->insertMember($data); //모든 검사를 끝내고 회원가입정보를 DB에 삽입
         
            
            if(isset($insert_id)){
                $this->session->set_flashdata('msg','회원가입 성공');// 귀찮아서 안쓰고있음
                $this->load->view('member/home');// / 로그인 회원가입 이 보이는 화면으로 이동(메인css수정이끝나면 메인 화면이동으로 수정 해야함)
            }/*else{
                $this->session->set_flashdata('msg','회원가입 실패'); // 이것도 안씀
                $this->load->view('member/join');// 다시 회원가입페이지로
            }*/
            
        
    }
    
    public function infopage(){
        $loginInfo = $this->session->userdata('loginInfo');
        
        $memberInfo = $this->Member_model->selectMemberByMnum($loginInfo->m_num);
        $this->load->view('member/info',array('memberInfo'=>$memberInfo[0]));
    }
    
     public function withdrawMember(){  //탈퇴
        $loginInfo = $this->session->userdata('loginInfo');
        $this->Member_model->deleteMemberByMnum($loginInfo->m_num);//로그인한 유저를 회원에서 없앰
        $this->session->unset_userdata('loginInfo');
        
        
    }
    public function modifypage(){
        $loginInfo = $this->session->userdata('loginInfo');
        $memberInfo = $this->Member_model->selectMemberByMnum($loginInfo->m_num);
        $this->load->view('member/modify',array('memberInfo'=>$memberInfo[0]));
    }
    public function modifyMember(){ //회원정보 수정

        $rawBody = file_get_contents("php://input"); // 본문을 불러옴
        $data =json_decode($rawBody);
        
        $loginInfo = $this->session->userdata('loginInfo'); //로그인한 유저의 로그인 세션정보를 변수에 저장
        $success=true;
            //-- 비밀번호,이름 수정할경우   와 비밀번호만 수정할경우,이름만수정할경우 예외처리 --
        if($data->m_pwd){ //비밀번호를 수정할경우
                
            if($this->Member_model->selectPWDByPwd($data->m_pwd) ){
                $view_data['existed_pwd'] = '이미 비밀번호가 존재합니다.';
                $success=false;
                    
            }else{
                $result['pwd']= $this->Member_model->updatePwd($data->m_pwd,$loginInfo->m_num);//비밀번호수정 쿼리
            }
                
        }
        
        if($data->m_name){// 이름을 수정할경우
            $result['name']= $this->Member_model->updateName($data->m_name,$loginInfo->m_num);// 이름수정 쿼리
        }
            //------------//
            
        $memberInfo = $this->Member_model->selectMemberByMnum($loginInfo->m_num);//수정된 회원정보 불러오기
        
        $userData = $this->Member_model->checkLogin($memberInfo[0]->m_id,$memberInfo[0]->m_pwd); //새 로그인정보 가져오기
        $this->session->unset_userdata('loginInfo');
        $this->session->set_userdata('loginInfo', $userData[0]); // 새 로그인정보 세션설정
        if($success){
        
            $this->infopage();
        }
        else{
            
            $view_data['memberInfo']=$memberInfo[0];
            
            $this->load->view('member/modify',$view_data);
        }
    }   

   
    
    
    public function search() // 친구검색 해서 신청용 쿼리
    {  

        $data['SearchID'] = isset($_POST['SearchID'])? $_POST['SearchID'] :null;
        $id = $data['SearchID'];
       
        if($id==null){
            $result = null;
            $data['list']=$result;
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->view('_templates/top');
            $this->load->view('Friend/index', $data);
            $this->load->view('_templates/body');
          
        }
            else{
            $result = $this->Member_model->FriendSearch($id);
            $data['list'] = $result;
            $data['ID'] = $id ;
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->view('_templates/top');
            $this->load->view('Friend/index', $data);
            $this->load->view('_templates/body');
            
            }
    }
}