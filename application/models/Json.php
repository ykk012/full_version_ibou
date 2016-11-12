<?php

class Json extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function jsonEncode($data){
        if(!is_array($data)) ErrorHandle::_init('is not array',__METHOD__,__FILE__,__LINE__);

        return json_encode($data);

    }

    public function  jsonDecode($data){
        if(is_null($data) || !$data)
            ErrorHandle::_init('is null',__METHOD__,__FILE__,__LINE__);

        return json_decode($data,true);
    }
}
?>