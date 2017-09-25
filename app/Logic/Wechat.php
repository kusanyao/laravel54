<?php

namespace App\Logic;

use Illuminate\Database\Eloquent\Model;

class Wechat
{
	
    private $appid  = 'wxba958eeb6da7edd6';
    private $appsecret = '43239f351e3afe6da2fd3c7c96c7acd0';

    // 获取code
    private $getCodeUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=APPID&redirect_uri=REDIRECT_URI&response_type=code&scope=SCOPE&state=STATE#wechat_redirect';

    private $getTokenUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code';

    private $getFulTokenUrl = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET';

    private $refreshTokenUrl = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=APPID&grant_type=refresh_token&refresh_token=REFRESH_TOKEN';

    private $getUserinfoUrl = 'https://api.weixin.qq.com/sns/userinfo?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN';

    private $getJsTicketUrl = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=ACCESS_TOKEN&type=jsapi';

    /**
     * 获取code
     */
    public function getCode($scope='snsapi_userinfo')
    {
        $callback = urlencode('http://wx.lakegouwu.cn/callback');
        $url = str_replace(['APPID','SCOPE','REDIRECT_URI'], 
            [$this->appid,$scope,$callback], $this->getCodeUrl);
        header('location: '.$url);
    }

    /**
     * 获取网页授权access_token
     */
    public function getAccessTokenByCode($code)
    {
    	$url = str_replace(['APPID','SECRET','CODE'], 
			[$this->appid,$this->appsecret,$code], $this->getTokenUrl);
		return $this->httpGet($url);
    }

	/**
	 * 获取微信用户的详细信息
	 */
	public function getUserInfo($access_token,$openid)
	{
		$url = str_replace(['ACCESS_TOKEN','OPENID'], 
			[$access_token,$openid], $this->getUserinfoUrl);
		return $this->httpGet($url);
	}

	/**
	 * 获取基础支持access_token
	 */
	public function getAccessToken()
	{
		// 从中控服务器获取

	}

	/**
	 * 获取jsapi_ticket
	 */
	public function getJsapiTicket($access_token)
	{
		$url = str_replace(['ACCESS_TOKEN'], 
			[$access_token,$openid], $this->getJsTicketUrl);
		return $this->httpGet($url);
	}

	/**
	 * http get
	 */
    private function httpGet($url) 
    {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 500);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($curl, CURLOPT_URL, $url);
		$res = curl_exec($curl);
		curl_close($curl);
		$result = json_decode($res,true);
		if( isset($result['errcode']) && $result['errcode'] > 0 ){
			return false;
		}
		return $result;
	}

	/*
	Array ( 
		[access_token] => zePHMKmdiu9JAe2-aqE08HhlUmx9BCzg0jG0GSikuD5FeUTpMNFxswHml7IthTYp98uF1YofDoYMI02SF8fbplBXwEXhmpYRbKDk02ph_O8 
		[expires_in] => 7200 
		[refresh_token] => 3ZhdkqRMXurrQ_zakMKoZMbpFoKJbgRSj-7TnwhFL_mAQ-C6B_pAFXZMKoGjuDmsidvNjnNbjbcXvsA7Si8NGfO5pHiGDlzp-HBygBPPY8Q 
		[openid] => ownYnw2la4EobC3nulfeMXcfCuNk [scope] => snsapi_userinfo 
		[unionid] => obTbe1UYj3QUMJOWuSsyblNtB5FA
	)
	Array ( 
		[errcode] => 40001 
		[errmsg] => invalid credential, access_token is invalid or not latest, hints: 
		[ req_id: I9OuGA0722s178 ] 
	)
	Array ( 
		[openid] => ownYnw2la4EobC3nulfeMXcfCuNk 
		[nickname] => 这个杀手不怕冷 
		[sex] => 1 
		[language] => zh_CN 
		[city] => 河源 
		[province] => 广东 
		[country] => 中国 
		[headimgurl] => http://wx.qlogo.cn/mmopen/bIB4mOvMJHmZxzKKUSh31mvHeicEh3yq1cxEIbeiagjaqIhuynzQhNekXLRtFNVnv61TTOvOzlNgJcUiaPHSiakMSuen6PMKCDj9/0 
		[privilege] => Array ( ) 
		[unionid] => obTbe1UYj3QUMJOWuSsyblNtB5FA 
	)
	*/
}
