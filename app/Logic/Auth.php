<?php

namespace App\Logic;

use Illuminate\Support\Facades\DB;
use App\Logic\User as UserLogic;

class Auth
{
	/**
	 * 认证微信登录
	 */
	public function authWechatByUserinfo(Array $userinfo)
	{
		// 判断是否存在微信用户
		$wechatTable = DB::table('wechat');
		$id = $wechatTable->where('openid',$userinfo['openid'])->value('id');
		$userinfo['privilege'] = json_encode($userinfo['privilege']);
			$userinfo['updated_at'] = time();
		if( $id > 0 ){
			$wechatTable->where('id',$id)->update($userinfo);
		}else{
			$userinfo['created_at'] = time();
			$id = $wechatTable->insertGetId($userinfo);
		}
		$userinfo['id'] = $id;
		session('wechat',$userinfo);
		return $id;
	}

	/**
	 * 根据微信信息认证用户登录
	 */
	public static function authUserByWechat()
	{
		$wechat = session('auth_wechat');
		var_dump($wechat);die;
		$userTable = DB::table('user');
		$user = $userTable->where('wechat',$wechat['id'])->first();
		if(empty($user)){
			$userLogic = new UserLogic();
			$user = $userLogic->createUserByWechat($wechat);
		}
		session('user',$user);
	}

	/**
	 * 刷新认证用户用户登录
	 */
	public static function authUserByUid($uid)
	{
		$userTable = DB::table('user');
		$user = $userTable->where('user',$uid)->first();
		if(empty($user)){
			return false;
		}
		session('user',$user);
	}
}
