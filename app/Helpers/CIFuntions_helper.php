<?php

use App\Libraries\CIAuth;
use App\Models\User;


/**
 * CIfuntion_helper.php
 *
 * Helper functions for sending emails using PHPMailer.
 */
if(!function_exists('get_user')){
    function get_user()  {
        if(CIAuth::check()){
            $user = new User();
            $userId = CIAuth::id();
            return $user->asObject()->where('id',$userId)->first();
        }else{
            return null;
        }
    }
}
