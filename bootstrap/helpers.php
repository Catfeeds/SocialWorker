<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/3/21
 * Time: 1:04
 */

/**
 * 发送http请求
 *
 * @param $url
 * @param string $header
 * @param string $method
 * @param string $body
 * @return mixed
 */
function curl($url, $header = '', $method = 'GET', $body = '')
{
    // 初始化curl
    $curl = curl_init();
    // 设置请求方法
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    // 设置请求url
    curl_setopt($curl, CURLOPT_URL, $url);
    if ($header) {
        // 设置请求头
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    }
    // 设置请求发生错误时是否显示，true为不显示
    curl_setopt($curl, CURLOPT_FAILONERROR, false);
    // 请求成功只返回结果，不自动输出任何内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // 是否在输出中包含头部信息
    curl_setopt($curl, CURLOPT_HEADER, false);
    if (1 == strpos("$" . $url, "https://")) {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    }
    if ($body) {
        // 设置请求体
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
    }
    // 执行curl
    $fileContents = curl_exec($curl);
    // 关闭curl
    curl_close($curl);
    // 返回结果
    return $fileContents;
}

/**
 * 获取指定长度的随机字符串
 *
 * @param $length
 * @param $num
 * @return null|string
 */
function getRandChar($length, $num = false)
{
    $str = null;
    $strPol = $num ? '0123456789' : 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
    $max = strlen($strPol) - 1;

    for ($i = 0; $i < $length; $i++) {
        $str .= $strPol[rand(0, $max)];
    }

    return $str;
}

/**
 * 生成订单号
 *
 * @return string
 */
function makeOrderNo()
{
    $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T');
    $orderSn = $yCode[intval(date('Y')) - 2018]
        . strtoupper(dechex(date('m')))
        . date('d') . substr(time(), -5)
        . substr(microtime(), 2, 5)
        . sprintf('%02d', rand(0, 99));

    return $orderSn;
}

/**
 * 生成guid
 *
 * @param null $namespace
 * @return string
 */
function createGuid($namespace = null)
{
    static $guid = '';
    $uid = uniqid("", true);

    $data = $namespace;
    $data .= $_SERVER ['REQUEST_TIME'];     // 请求那一刻的时间戳
    $data .= $_SERVER ['HTTP_USER_AGENT'];  // 获取访问者在用什么操作系统
    $data .= $_SERVER ['SERVER_ADDR'];      // 服务器IP
    $data .= $_SERVER ['SERVER_PORT'];      // 端口号
    $data .= $_SERVER ['REMOTE_ADDR'];      // 远程IP
    $data .= $_SERVER ['REMOTE_PORT'];      // 端口信息

    $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
//    $guid = substr($hash, 0, 8) . '-' . substr($hash, 8, 4) . '-' . substr($hash, 12, 4) . '-' . substr($hash, 16, 4) . '-' . substr($hash, 20, 12);

    $guid = substr($hash, 1, 6) . '-' . substr($hash, 10, 4) . '-' . substr($hash, 16, 4) . '-' . substr($hash, 24, 8);

    return $guid;
}

/**
 * 获取指定年月第一天的时间戳
 *
 * @param string $year
 * @param string $month
 * @return false|string
 */
function getFirstDayOfTheMonth($year = '', $month = '')
{
    if (empty($year)) $year = date('Y');
    if (empty($month)) $month = date('m');
    $day = '01';

    //检测日期是否合法
    if (!checkdate($month, $day, $year)) return '输入的时间有误';

    //获取当年当月第一天的时间戳(时,分,秒,月,日,年)
    $timestamp = mktime(0, 0, 0, $month, $day, $year);
    $result = date('t', $timestamp);
    return $result;
}

function taxRate($x)
{
    if ($x <= 800) return 0;
    if ($x > 800 && $x < 4000) return ($x - 800) * 0.2;
    if ($x >= 4000 && $x < 21000) return ($x - $x * 0.2) * 0.2;
    if ($x >= 21000 && $x < 49500) return ($x - $x * 0.2) * 0.3 - 2000;
    if ($x >= 49500) return ($x - $x * 0.2) * 0.4 - 7000;
}