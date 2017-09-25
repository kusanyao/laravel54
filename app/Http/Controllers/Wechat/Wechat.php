<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;

use App\Logic\Wechat as WechatLogic;
use App\Logic\Auth;

class Wechat extends Base
{	

    /**
     * 微信授权联登
     */
    public function login(Request $request)
    {
        $wechat = session('wechat');
        var_dump($wechat);
         session('wechat',['a','b']);
        
        // die;
        // $redirect_uri = $request->input('redirect_uri');
        // if ( $this->member || $this->wechat ) {
        //     if ( $redirect_uri ) {
        //         return redirect($redirect_uri);
        //     }
        //     return redirect('/');
        // }
        // session('login_redirect_uri',$redirect_uri);
        // $wechatLogic = new WechatLogic();
        // $wechatLogic->getCode();
    }

    /**
     * 微信静默登录
     */
    public function silentLogin(Request $request)
    {

        $redirect_uri = $request->input('redirect_uri');
        if ( $this->member || $this->wechat ) {
            if ( $redirect_uri ) {
                return redirect($redirect_uri);
            }
            return redirect('/');
        }
        session('login_redirect_uri',$redirect_uri);
        $wechatLogic = new WechatLogic();
        $wechatLogic->getCode();
    }

    /**
     * 绑定手机号，页面
     */
    public function bindMobile()
    {
        return view();
    }

    /**
     * 授权认证回调地址
     */
    public function callback(Request $request)
    {
        $code = $request->input('code');
        $wechatLogic = new WechatLogic();
        $tokenInfo = $wechatLogic->getAccessTokenByCode($code);
        if($tokenInfo == false){
            die('false');
        }
        $userInfo = $wechatLogic->getUserInfo($tokenInfo['access_token']
            ,$tokenInfo['openid']);
        if($userInfo == false){
            die('false');
        }
        
        $authLogic = new Auth();
        $wechatId = $authLogic->authWechatByUserinfo($userInfo);
        if( !$wechatId ){
            die('false');
        }
        $authLogic->authUserByWechat();
        $url = session('login_redirect_uri');
        header('location'.$url);
    }


}
