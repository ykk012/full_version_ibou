<?php
// dirname 디렉토리만 가져오는 함수
// __FILE__ 시스템 전체에서 ㄱ져옴
// DIRECTORY_SEPARATOR = /, \

if ( !empty( $_FILES ) ) {

    $tempPath = $_FILES[ 'file' ][ 'tmp_name' ];
    $uploadPath = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'thumbnail' . DIRECTORY_SEPARATOR. $_FILES[ 'file' ][ 'name' ];
    move_uploaded_file( $tempPath, $uploadPath );

    $answer = array( 'answer' => 'File transfer completed', 'path' =>  $_FILES[ 'file' ][ 'name' ]);
    $json = json_encode( $answer );

    echo $json;

} else {
    echo 'No files';
}

?>