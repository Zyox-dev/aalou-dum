<?php

namespace App\Helpers;

class FormatHelper
{
    /**
     * Format number in Indian currency style (e.g., 10,80,000)
     */
    public static function formatIndianCurrency($number)
    {
        $number = (int)$number;
        $num = (string)$number;
        $lastThree = substr($num, -3);
        $restUnits = substr($num, 0, -3);

        if ($restUnits != '') {
            $lastThree = ',' . $lastThree;
        }

        $restUnits = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $restUnits);

        return $restUnits . $lastThree;
    }
}
