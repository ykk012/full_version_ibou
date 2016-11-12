<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
class Warehouse extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('FileManager');
        $this->load->model('Test_model');
        $this->load->model('Json');
        $this->load->model('Sort');
        $this->load->model('Thumbnail');
        $this->load->model('Member_model');
        
        $this->load->library('session');
        $this->load->helper(array('form', 'url','date'));


    }

    public function index()
    {   
        $loginInfo = $this->session->userdata('loginInfo');
        $result=$this->Test_model->getData($loginInfo->m_num);
        $friendlist=$this->Member_model->MyFriendsSearch($loginInfo->m_num);
        //$this->load->view('new_templates/top_ware');
        $this->load->view('new_templates_mk2/top');
        
        $this->load->view('templetes/head');
        $this->load->view('templetes/body_1',array('body_1'=>'application/views/warehouse/naver.php'));
        $this->load->view('templetes/body_2',array('body_2a'=>'application/views/warehouse/sidebar.php','body_2b'=>'application/views/warehouse/table.php','body_2c'=>'application/views/warehouse/drop_upload_explorer.php','files'=>$result));
        $this->load->view('templetes/body_3',array('body_3'=>'application/views/warehouse/modals.php','friendlist'=>$friendlist));
    
       
    }
    
    // 워크벤치에서 자신의 파일 데이터 받아오기
    public function getFileList($m_num){
        $result = $this->Test_model->getBenchData($m_num);
        
        echo json_encode($result);
    }
    
    public function sorted_files_workbech(){  // 준성이 형님이 쓰시면됨니다
        $rawBody = file_get_contents("php://input"); // 모든 request를 불러온다.
        $sorts =json_decode($rawBody);
        
        $result = $this->Sort->sort_data($sorts); // 필로 정렬된 모든 files 칼럼 내용들을 객체형태로 불러온다
        $this->load->view('warehouse/'.$sorts->view_mode."-modal",array('files'=>$result));
        
    }
    function filterView($t_id){ // 필터 부분
         $loginInfo = $this->session->userdata('loginInfo');
        $result=$this->Test_model->getData($loginInfo->m_num);
       
        $this->load->view('warehouse/filter2',array('files'=>$result,'k_num'=>$t_id)); //필터 뷰를 불러온다;
        
    }
    
    public function sorted_files(){
        


        $rawBody = file_get_contents("php://input"); 
        $sorts =json_decode($rawBody);
        
        $result = $this->Sort->sort_data($sorts); 
        
        $this->load->view('warehouse/'.$sorts->view_mode,array('files'=>$result));
    }

    public function downloadFile(){

        $dir="./download/";

        $f_nums = $_REQUEST['f_nums'];
        $loginInfo = $this->session->userdata('loginInfo');
        foreach($f_nums as $f_num) {
        
            $f_name = $this->Test_model->getSaveNameFromM_FByFnum($f_num); //이 부분 공유관계에 따라 다르므로 커스텀이 필요
            
            $ext = explode(".", $f_name->f_origin_name)[1];
            if ($ext == "avi" || $ext == "asf") $file_type = "video/x-msvideo";
            else if ($ext == "mpg" || $ext == "mpeg") $file_type = "video/mpeg";
            else if ($ext == "jpg" || $ext == "jpeg") $file_type = "image/jpeg";
            else if ($ext == "gif") $file_type = "image/gif";
            else if ($ext == "png") $file_type = "image/png";
            else if ($ext == "txt") $file_type = "text/plain";
            else if ($ext == "zip") $file_type = "application/x-zip-compressed";
            
            $ret = $this->FileManager->download_file($f_name->f_origin_name,$dir.$f_name->f_saved_name); //서버에저장된파일이름 ,경로 ,헤더정보로보낼 파일 타입 
            
            if ($ret == 1) echo("지정하신 파일이 없습니다.");
        }
        
        



    }
    public function uploadFromPC2(){
        $loginInfo = $this->session->userdata('loginInfo');
        $files = $_FILES['userfile'];
        $share_name = isset($files['share'])?$files['share']:null;
        //$k_num = isset($files['k_num'])?$files['k_num']:null;
        
        $result=$this->FileManager->upload($files,'userfile',$loginInfo);
        //$this->Test_model->insertf_k_rel($result, $k_num);
        
        if($share_name=="share"){
            $result=$this->Test_model->getShare($loginInfo->m_num);
           
        }
        else if($share_name== null){
             $result=$this->Test_model->getData($loginInfo->m_num);
        }
        //echo json_encode($result);
    }
    public function uploadFromPC(){
        $loginInfo = $this->session->userdata('loginInfo');
        $files = $_FILES['userfile'];
        
        $result = $this->FileManager->upload($files,'userfile',$loginInfo);
        
        echo json_encode($result);
        
         if(!is_array($result)){
             $this->Test_model->insertf_k_rel($result, $k_num);
         }
        
    }
   
    public function uploadFile(){
        $loginInfo = $this->session->userdata('loginInfo');  // 로그인정보에 있는 m_num값을 사용하기위해 
        $files = $_FILES['userfile']; // userfile라는 이름으로 $_FILES을 받아올때 
        
        $share_name = isset($files['share'])?$files['share']:null;
        /*$this->FileManager 여기 들어가서 upload 부분 커스텀해서 메서드 만드세요*/
        $insert_id_array = $this->FileManager->upload($files,'userfile',$loginInfo);
        if($insert_id_array==false){//첫번째 $_FILES변수 ,userfile라는 name의 폼에서 보낸 $_FILES를 참조하기위해 2번째 파라미터에 input type='file' 의 name의 이름을 넘겨준다
            
        }else{
            if ( !is_array($insert_id_array) ){
                
            }
            else if ( count($insert_id_array) > 0 ){
                
                foreach ( $insert_id_array as $f_num){
              
                $f_save=$this->Test_model->getSaveNameByFnum($loginInfo->m_num,$f_num);
                $ext = explode(".", $f_save)[1];
                    switch($ext){
                        case 'jpg':
                        case 'jpeg':
                        case 'gif':
                        case 'png':
                            $this->Thumbnail->create_thumbnail('./download/'.$f_save,'./img/warehouse/thumbnail/'.$f_num.".jpg",256,258,$ext);
                            break;
                    }
                
                }
            }
        }
        if($share_name=="share"){
            $result=$this->Test_model->getShare($loginInfo->m_num);
           
        }
        else if($share_name==""){
             $result=$this->Test_model->getData($loginInfo->m_num);
        }
        $this->load->view('warehouse/table',array('files'=>$result));//warehouse 뷰단임
       



    }
    function uploadfile_workbench(){
        $rawBody = file_get_contents("php://input"); 
        $f_k_array =json_decode($rawBody);
        
        foreach($f_k_array->fnums as $f_num){
        $this->Test_model->insertf_k_rel($f_num, $f_k_array->k_num);
        }
            
    }

    function deleteFile()
    {
        //header('Content-Type: application/json; charset=UTF-8');

// 컨텐츠 타입이 JSON 인지 확인한다
        $file_dir="./download/";
        
        $rawBody = file_get_contents("php://input"); // 본문을 불러옴
        $sort_and_file =json_decode($rawBody);
        
        $loginInfo = $this->session->userdata('loginInfo');
        
        $this->FileManager->delete($sort_and_file->fnums,$file_dir,$loginInfo);// 첫번째 파일이름들을 담은 배열, 두번쨰 파일경로, 세번째 로그인정보
        $this->sorted_files(); //warehouse 뷰단임

    }
    function delete(){
        $file_dir="./download/";
        
        $rawBody = file_get_contents("php://input"); // 본문을 불러옴
        $sort_and_file =json_decode($rawBody);
        
        $loginInfo = $this->session->userdata('loginInfo');
        
        $this->FileManager->delete($sort_and_file->fnums,$file_dir,$loginInfo);// 첫번째 파일이름들을 담은 배열, 두번쨰 파일경로, 세번째 로그인정보
        
    }
   
    
    function shareFile(){ // 회원,키워드 와 파일간의 공유 관계삽입부분 
        $rawBody = file_get_contents("php://input"); // 본문을 불러옴
        $friend_and_file =json_decode($rawBody);
         $loginInfo = $this->session->userdata('loginInfo');
      
         
        if(is_array($friend_and_file->friend)) {
            
            foreach( $friend_and_file->friend as $m_id) {
                $m_num = $this->Test_model->getMnumById($m_id)[0]->m_num;
             
                foreach($friend_and_file->fnums as $f_num){
                    
                    
                    $this->Test_model->insertf_k_rel($f_num,252);
                    $this->Test_model->insertm_f_rel($f_num,$m_num);
                    $this->Test_model->updateShareNums($f_num);
                }
            }
        }
    }
    
    function keywordsInFile(){
        $rawBody = file_get_contents("php://input"); // 본문을 불러옴
        $file =json_decode($rawBody);
        
        
        $keywords_list=$this->Test_model->getKeywordsInFile($file->f_num);
        
        
        $this->load->view('warehouse/keywords_list',array('keywords_list'=>$keywords_list));
    }
    function preview($f_num,$f_save){
        $rawBody = file_get_contents("php://input"); // 본문을 불러옴
        $file =json_decode($rawBody);
        
        
        $keywords_list=$this->Test_model->getKeywordsInFile($f_num);
        
        
        $this->load->view('warehouse/preview',array('f_save'=>$f_save,'keywords_list'=>$keywords_list));
    }
    

}
