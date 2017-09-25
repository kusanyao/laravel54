<?php

namespace App\Logic;

use Illuminate\Support\Facades\DB;
use App\Model\User as UserModel;
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
    	$user = new UserModel();
    	return $user->find($id);
    }

    /**
     * 创建用户名
     */
    public function getUsername($username)
    {return $username;
        // 去掉非法字符
        // if( $username != '' 
        //     && preg_match_all('/[^a-zA-Z0-9!#$%^&*\.()\x80-\xff]/',$username,$illegal)){
        //     $username = '';//array_unique($illegal[0]);
        // }
        // if($username == ''){

        // }
        // $userTable = DB::table('user');
        // $user = $userTable->where('username',$username)->first();
    }

    /**
     * 根据已注册的微信信息创建用户
     */
    public function createUserByWechat($wechat)
    {
        $userTable = DB::table('user');
        $username = $this->getUsername($wechat['username']);
        $nowTime = time();
        $id = $userTable->insertGetId([
            'username'   => $username,
            'wechat'     => $wechat['id'],
            'created_at' => $nowTime,
            'updated_at' => $nowTime,
        ]);
        return ['id'=>$id,'wehcat'=>$wechat['id']];
    }
}
