<?php

namespace App\Services;

class UserService
{

    public function uploadImage( $request){
        $avatar = $request->files->get("avatar");
        if($avatar){
            
            $avatarBlob = fopen($avatar->getRealPath(),"rb");
            return $avatarBlob;
        }
    return null;

    }

    public function validate(){
        
        return true;
    }

 

}