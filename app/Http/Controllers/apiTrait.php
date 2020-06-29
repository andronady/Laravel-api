<?php

namespace App\Http\Controllers;
use App\posts;


trait apiTrait{

    public function apiResponce($data=null , $error=null , $status=200)
    {
        $array = [
            'data' => $data,
            'status'=>$status == 200 ? true : false,
            'error'=>$error
        ];

        return response($array , $status);
    }

}


?>
