<?php


use QCod\Gamify\Classes\PointType;
use QCod\Gamify\Models\Badge;
use QCod\Gamify\Models\LevelQualifier;
use QCod\Gamify\Models\ReputationPoint;


if ( ! function_exists('getBadgeIdByName')) {
    function getBadgeIdByName($name)
    {
        $badge  =   Badge::where('name', $name)->active()->first();

        return (!empty($badge))    ?   $badge->id  :   config('badge_default_level');
    }
}



if (!function_exists('givePoint')) {

    /**
     * Give point to user
     *
     * @param $pointType
     * @param User $user
     * @param string $payee
     * @param string $action
     */
    // $pointtype is Class of any class inherited with PointType class
    // $subject is the class on which the action is performed
    // $user is type of User
    // $payee is the name of relation between subject and user e.g: post and user // post is subject and user is payee
    // $action is name of action to get the reputation point from DB
    function givePoint($pointType, $user, string $payee, string $action)
    {
        $reputationPoint    =   ReputationPoint::active()->where('action', $action)->first();
        if($reputationPoint)
        {
            $pointType   =   new $pointType($user, $reputationPoint->points, $payee);
            $user->givePoint($pointType);
        }
    }
}

if (!function_exists('getLevelQualifier')) {
    function getLevelQualifier($className)
    {
        $qualifier  =   LevelQualifier::where('class_name',$className)->first();
        $qualifier  =   !empty($qualifier) ? $qualifier->qualifying_points : 5000000;
        return $qualifier;
    }
}

if (!function_exists('getLevelOrder')) {
    function getLevelOrder($className)
    {
        $level  =   LevelQualifier::where('class_name',$className)->first();
        $level  =   !empty($level) ? $level->order : config('gamify.default_level_order');
        return $level;
    }
}


if (!function_exists('undoPoint')) {

    /**
     * Undo a given point
     *
     * @param PointType $pointType
     * @param null $payee
     */
    function undoPoint(PointType $pointType, $payee = null)
    {
        $payee = $payee ?? auth()->user();

        if (!$payee) {
            return;
        }

        $payee->undoPoint($pointType);
    }
}

if (!function_exists('short_number')) {

    /**
     * Convert large positive numbers in to short form like 1K+, 100K+, 199K+, 1M+, 10M+, 1B+ etc
     *
     * @param $n int
     * @return string
     */
    function short_number($n)
    {
        if ($n >= 0 && $n < 1000) {
            $n_format = floor($n);
            $suffix = '';
        } else if ($n >= 1000 && $n < 1000000) {
            $n_format = floor($n / 1000);
            $suffix = 'K+';
        } else if ($n >= 1000000 && $n < 1000000000) {
            $n_format = floor($n / 1000000);
            $suffix = 'M+';
        } else {
            $n_format = floor($n / 1000000000);
            $suffix = 'B+';
        }

        return !empty($n_format . $suffix) ? $n_format . $suffix : '0';
    }
}
