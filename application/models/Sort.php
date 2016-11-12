<?php

class Sort extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

   public function sort_data($sorts){
       $loginInfo = $this->session->userdata('loginInfo');
       $where = "";
       if($sorts->share=="share"){
                $rel="f.";
        }
        else{
            $rel="f.";
        }
       if(isset($sorts->sort) && $sorts->sort != new stdClass()) {
           
           $count = 0;
           
           foreach ($sorts->sort as $not_order) {
               if(is_array($not_order)){
                    $count += count($not_order);
               }
               else{
                    $count++;
               }
           }
           
           
            
           if(isset($sorts->sort->ext) && count($sorts->sort->ext)!=0){
                if ($count != 0) {
                   $where .= " AND ";
                   $count--;
               }
               $ext_array = $sorts->sort->ext;
               $where .= " ( ";
               for($i = 0; $i < count($ext_array); $i++){
                   switch($ext_array[$i]){
                       case "image" : $where .= $rel."f_ext = '.jpg' OR ".$rel."f_ext = '.png' OR ".$rel."f_ext = '.gif' ";
                           break;
                       case "archive" : $where .= $rel."f_ext = '.zip' ";
                           break;
                       case "document" : $where .= $rel."f_ext = '.pptx' OR ".$rel."f_ext = '.pdf' OR ".$rel."f_ext = '.docx' ";
                           break;    
                   }

                   if(count($ext_array) > 1 && $i != (count($ext_array)-1) ){
                       $where .= " OR ";
                       $count--;
                   }

               }
               $where .= " ) ";
               
           }
           if(isset($sorts->sort->search) ) {
               if ($count != 0) {
                   $where .= " AND ";
                   $count--;
               }

               switch ($sorts->search_mod) {
                   case "before" :
                       $where .= $rel."f_origin_name regexp '^(" . $sorts->sort->search . ")+[*\\/+?{}()]*[가-힇]*[[:space:]]*[[:alnum:]]*[*\\/+?{}()]*[가-힇]*[[:space:]]*[[:alnum:]]*' ";
                       break;
                   case "mid" :
                       $where .= $rel."f_origin_name regexp '[*\\/+?{}()]*[가-힇]*[[:space:]]*[[:alnum:]]*[*\\/+?{}]*[가-힇]*[[:space:]]*[[:alnum:]]*(".$sorts->sort->search. ")+[*\\/+?{}()]*[가-힇]*[[:space:]]*[[:alnum:]]*[*\\/+?{}()]*[가-힇]*[[:space:]]*[[:alnum:]]*' ";
                       break;
                   case "after" :
                       $where .= $rel."f_origin_name regexp '[*\\/+?{}()]*[가-힇]*[[:space:]]*[[:alnum:]]*[*\\/+?{}]*[가-힇]*[[:space:]]*[[:alnum:]]*(".$sorts->sort->search. ")+$' ";
                       break;
               }
           }
           if(isset($sorts->sort->date1) ) {
               if ($count != 0) {
                   $where .= " AND ";
                   $count--;
                   
               }
               $date1 = $sorts->sort->date1;
               
               $where .= $rel."f_upload_date >= STR_TO_DATE('".$date1."','%Y-%m-%d')";
           }
           if(isset($sorts->sort->date2) ) {
               if ($count != 0) {
                   $where .= " AND ";
                   $count--;
               }
               
               $date2 = $sorts->sort->date2;
               
               $where .= $rel."f_upload_date <= STR_TO_DATE('".$date2."','%Y-%m-%d')";
           }

       }else{
           $where = "";
       }
       if(isset($sorts->order) && $sorts->order!=="") {
           switch($sorts->order){
               case "DESC" : $where .= " ORDER BY ".$rel."f_upload_date DESC";
                   break;
               case "ASC" : $where .= " ORDER BY ".$rel."f_upload_date ASC";
                   break;
           }
           
       }
       
       
               
       if($sorts->share=="share"){
            if($where != "") {
           
                return $this->Test_model->getShareBySort($where,$loginInfo->m_num);
            }
            else{
                return $this->Test_model->getShare($loginInfo->m_num);
            }
       }else if($sorts->share==""){
           if($where != "") {
           
                return $this->Test_model->getFilesBySort($where,$loginInfo->m_num);
            }
            else{
                return $this->Test_model->getData($loginInfo->m_num);
            }
       }
        
   }
}
?>