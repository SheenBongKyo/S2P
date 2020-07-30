<?php
function diffMonthCount($start = "", $end = "")
{
    if ($start && $end) {
        $startMonth = substr($start, 0, 7);
        $endMonth = substr($end, 0, 7);
        $dateDiff = date_diff(new DateTime($startMonth), new DateTime($endMonth));
        return $monthCount = $dateDiff->y * 12 + $dateDiff->m + 1;
    } else {
        return 0;
    }
}