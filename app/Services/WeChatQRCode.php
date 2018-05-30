<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/14
 * Time: 17:49
 */

namespace App\Services;


use App\Exceptions\BaseException;

class WeChatQRCode
{
    /**
     * 获取邀请码
     *
     * @param $scene
     * @return mixed
     * @throws BaseException
     */
    public static function invite($scene)
    {
        return self::get($scene, 'pages/index/index');
    }

    /**
     * 获取服务码
     *
     * @param $scene
     * @return mixed
     * @throws BaseException
     */
    public static function service($scene)
    {
        return self::get($scene, 'pages/choose-service/choose-service');
    }

    /**
     * 获取众筹码
     *
     * @param $scene
     * @return mixed
     * @throws BaseException
     */
    public static function crowdFunding($scene)
    {
        return self::get($scene, 'pages/raise-friends/raise-friends');
    }

    /**
     * 获取小程序码
     *
     * @param $scene
     * @param $path
     * @return mixed
     * @throws BaseException
     */
    private static function get($scene, $path)
    {
        $url = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=' . WeChatAccessToken::get();
        $body = [
            'scene' => $scene,
            'page' => $path
        ];

        $wxResult = curl($url, '', 'POST', json_encode($body));

        if (!is_null(json_decode($wxResult))) {
            \Cache::forget('wx_access_token');
            self::get($scene, $path);
        }

        return $wxResult;
    }
}