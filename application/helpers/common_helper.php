<?php
function getMonthDiff($start = "", $end = "")
{
    if ($start && $end) {
        $startYear = date('Y', strtotime($start));
        $startMonth = date('m', strtotime($start));
        $endYear = date('Y', strtotime($end));
        $endMonth = date('m', strtotime($end));
        $monthDiff = (($endYear * 12) + $endMonth) - (($startYear * 12) + $startMonth) + 1;
        return $monthDiff;
    } else {
        return 0;
    }
}