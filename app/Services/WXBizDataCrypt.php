<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/6/6
 * Time: 23:05
 */

namespace App\Services;


use App\Exceptions\BaseException;
use App\Services\Tokens\TokenFactory;

class WXBizDataCrypt
{
    private $appid;
    private $sessionKey;

    public function __construct()
    {
        $this->appid = config('wxMiniProgram.app_id');
        $this->sessionKey = TokenFactory::getCurrentTokenVar('remark');
    }

    public function decryptData($encryptedData, $iv)
    {
        if (strlen($this->sessionKey) != 24) {
            throw new BaseException('sessionKey错误', 41001);
        }
        $aesKey = base64_decode($this->sessionKey);


        if (strlen($iv) != 24) {
            throw new BaseException('iv错误', 41002);
        }
        $aesIV = base64_decode($iv);

        $aesCipher = base64_decode($encryptedData);

        $result = openssl_decrypt($aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);

        $dataObj = json_decode($result);
        if ($dataObj == NULL) {
            throw new BaseException('解密数据失败', 41003);
        }
        if ($dataObj->watermark->appid != $this->appid) {
            throw new BaseException('appid不匹配', 41004);
        }
        return json_decode($result, true);
    }
}