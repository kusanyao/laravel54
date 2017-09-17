<?php

namespace App\Logic;

use Illuminate\Database\Eloquent\Model;

class Auth
{
	
    private $appid  = 'wxa4ecb0681fba754c';
    private $appsecret = '093743fe335eb4371e6001e342d05cbf';

    private $getCodeUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=APPID&redirect_uri=REDIRECT_URI&response_type=code&scope=SCOPE&state=STATE#wechat_redirect';

    private $getTokenUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code';

    private $refreshTokenUrl = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=APPID&grant_type=refresh_token&refresh_token=REFRESH_TOKEN ';

    private $getUserinfoUrl = 'https://api.weixin.qq.com/sns/userinfo?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN';

    private $getJsTicketUrl = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=ACCESS_TOKEN&type=jsapi';

    private $Sessionkey = 'com.yuejie.m.wechat_return_url';


	/**
	 * 帐号密码登录
	 */
    public function login($username,$password)
    {

    }

    /**
     * 微信登录
     */
    public function loginWechat($id)
    {

    }

    /**
     * 手机验证码登录
     */
    public function loginMobile($phone,$code)
    {

    }

    /**
     * 
     */
    private function loginUid($id)
    {
    	$authinfo = array(
    		'id'     => '',
    		'mobile' => '',
    		'email'  => '',
    		'wechat' => '',
    		'avatar' => '',
    	);
    }

    /**
     * 
     */
    public static function wechatGetCode()
    {
        $callback = urlencode('http://www.inklego.com/wechat/callback');
        $url = str_replace(['APPID','REDIRECT_URI','SCOPE'], 
            [$this->appid,$callback,'snsapi_userinfo'], $this->getCodeUrl);
        header("location: ".$url);
    }

    
}
