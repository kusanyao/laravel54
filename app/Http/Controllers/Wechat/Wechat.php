<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Logic\Auth;

class Wechat extends Controller
{
	public function __construct()
	{

		$this->wechat = session('auth_wechat');
		$this->member = session('auth_member');
	}
	
    /**
     * 注册页面
     */
    public function register(Request $request)
    {
    	$redirect_uri = $request->input('redirect_uri');
        if ( $this->member ) {
            if($redirect_uri){
                return redirect($redirect_uri);
            }
            return redirect('/');
        }
        if ( !$this->wechat ) {
            session('wechat_register_redirect_uri',$redirect_uri);
            $redirect_uri = urlencode('/wechat/register');
            return redirect('/wechat/login?redirect_uri='.$redirect_uri);
        }
    	return view('Wechat/register',['url'=>$redirect_uri]);
    }

    /**
     * 微信联等url
     */
    public function login(Request $request)
    {
        $redirect_uri = $request->input('redirect_uri');
        if ( $this->member || $this->wechat ) {
            if ( $redirect_uri ) {
                return redirect($redirect_uri);
            }
            return redirect('/');
        }
        session('wechat_logic_redirect_uri',$redirect_uri);
        Auth::wechatGetCode();
    }

    public function callback()
    {
        $code = $request->input('code');
        $tokenInfo = model('Wechat','logic')->getTokenByCode($code);
        if($tokenInfo == false){
            die('false');
        }
        $userInfo = model('Wechat','logic')->getUserInfo($tokenInfo);
    }
}
