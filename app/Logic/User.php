<?php

namespace App\Logic;

use App\Model\User;
use App\Model\Userinfo;
use App\Model\Wechat;
use App\Model\Password;

class User
{
    /**
     * 获取用户信息
     * @param int $id 用户id
     */
    public function getUserinfo($id)
    {
    	$user = new User();
    	return $user->find($id);	
    }
}
