<?php

class Thumbnail extends CI_Model{

    function __construct(){
        parent::__construct();
    }
    
    function create_thumbnail($file, $save_filename, $max_width, $max_height,$ext){
        
        switch($ext){
                        case 'jpg':
                        case 'jpeg':
                            $src_img = @imagecreatefromjpeg($file);
                            break;
                        case 'gif':
                            $src_img = @imagecreatefromgif($file);
                            break;
                        case 'png':
                            $src_img = @imagecreatefrompng($file);
                            break;
        }
        $src_img = ImageCreateFromJPEG($file); //JPG파일로부터 이미지를 읽어옵니다
 
        $img_info = getImageSize($file);//원본이미지의 정보를 얻어옵니다
        $img_width = $img_info[0];
        $img_height = $img_info[1];
 
        /*if(($img_width/$max_width) == ($img_height/$max_height))
        {//원본과 썸네일의 가로세로비율이 같은경우
            $dst_width=$max_width;
            $dst_height=$max_height;
        }
 
        elseif(($img_width/$max_width) < ($img_height/$max_height))
        {//세로에 기준을 둔경우
            $dst_width=$max_height*($img_width/$img_height);
            $dst_height=$max_height;
        }
 
        else
        {//가로에 기준을 둔경우
            $dst_width=$max_width;
            $dst_height=$max_width*($img_height/$img_width);
        }*/
 
 
        $dst_img = imagecreatetruecolor($max_width, $max_height); //타겟이미지를 생성합니다
   
        ImageCopyResized($dst_img, $src_img, 0, 0, 0, 0, $max_width, $max_height, $img_width, $img_height); 
        //타겟이미지에 원하는 사이즈의 이미지를 저장합니다
   
        ImageInterlace($dst_img);
        ImageJPEG($dst_img,  $save_filename); //실제로 이미지파일을 생성합니다
        ImageDestroy($dst_img);
        ImageDestroy($src_img);
    }
}
