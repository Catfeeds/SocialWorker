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
     * 获取小程序码
     *
     * @param $scene
     * @return mixed
     * @throws BaseException
     */
    public static function get($scene)
    {
        $url = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=' . WeChatAccessToken::get();
        $body = [
            'scene' => $scene,
            'path' => 'pages/index/index'
        ];

        $wxResult = curl($url, '', 'POST', json_encode($body));

        if (empty($wxResult))
            throw new BaseException('获取小程序码失败');

        return $wxResult;
    }
}