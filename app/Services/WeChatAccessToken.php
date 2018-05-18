<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/14
 * Time: 14:04
 */

namespace App\Services;


use App\Exceptions\BaseException;
use Cache;

class WeChatAccessToken
{
    /**
     * 获取微信access_token
     *
     * @return mixed
     */
    public static function get()
    {
        /**
         * TODO 微信access_token缓存过期时间
         * 微信access_token有效期目前为7200秒，所以这里设置缓存过期时间为100分钟
         * 若后期微信团队有更改，则这里缓存过期时间也得更改
         */
        return Cache::remember('wx_access_token', 100, function () {

            $url = sprintf('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s',
                config('wxMiniProgram.app_id'), config('wxMiniProgram.app_secret'));

            $wxResult = json_decode(curl($url), true);

            if (empty($wxResult) || array_key_exists('error_code', $wxResult))
                throw new BaseException('获取微信access_token失败');

            return $wxResult['access_token'];
        });
    }
}