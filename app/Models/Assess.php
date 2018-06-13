<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/28
 * Time: 23:38
 */

namespace App\Models;


use App\Services\Tokens\TokenFactory;

class Assess extends Model
{
    protected $guarded = [];
    private static $personalHistory = 2;

    public static function getTotalScore($type = '')
    {
        if (!$type) {
            return self::where('type', '<>', self::$personalHistory)
                    ->sum('score') + 3;
        }
        if ($type == self::$personalHistory) return 3;
        return self::where('type', $type)->sum('score');
    }

    public static function getUserScore($type = '')
    {
        return TokenFactory::getCurrentUser()->assesses()
            ->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })->sum('score');
    }

    public static function getScorePercent($type = '')
    {
        return 100 - round(self::getUserScore($type) / self::getTotalScore($type) * 100);
    }

    public static function getTotalResult()
    {
        $result = [];
        for ($i = 1; $i <= 5; $i++) array_push($result, self::getTypeResult($i));
        return implode(';', $result);
    }

    public static function getTypeResult($type)
    {
        $score = self::getUserScore($type);
        return call_user_func(array(__CLASS__, 'getScoreResult' . $type), $score);
    }

    private static function getScoreResult1($score)
    {
        if ($score >= 33) return '建议定期体检';
        if ($score >= 17) return '要注意保养了';
        return '健康状况不错，要继续保持';
    }

    private static function getScoreResult2($score)
    {
        if ($score == 3) return '您的职业有可能会引发职业病，要注意了';
        if ($score == 2) return '您需要定期做简单的锻炼了';
        return '您的职业可能会给您健康的身体';
    }

    private static function getScoreResult3($score)
    {
        if ($score >= 13) return '适度的锻炼加定期的体检时不错的选择';
        if ($score >= 7) return '坚持锻炼是个不错的选择';
        return '天生强健的体魄要好好珍惜';
    }

    private static function getScoreResult4($score)
    {
        if ($score >= 12) return '要立刻改变您的生活习惯，它可能已经影响您的健康了';
        if ($score >= 6) return '有些生活习惯还需要改善';
        return '良好的生活习惯要保持';
    }

    private static function getScoreResult5($score)
    {
        if ($score >= 25) return '尽快做个全面的检查，有些不妙哦';
        if ($score >= 13) return '改善生活习惯，展现更好的自己';
        return '您的身体状况不错要保持';
    }
}