<?php
use Carbon\Carbon;

function getAlias($name)
{
    // Define your logic to generate the alias based on the provided name
    // For example, let's assume we want to take the first letter of each word in the name
    $words = explode(' ', $name);
    $alias = '';
    foreach ($words as $word) {
        $alias .= strtoupper(substr($word, 0, 1));
    }
    return $alias;
}


if (!function_exists('formatDate')) {
    function formatDate($timestamp, $format = 'd/m/y')
    {
        if (strlen($timestamp) <= 10) {
            return Carbon::createFromFormat('Y-m-d', $timestamp)->format($format);
        }

        return Carbon::createFromFormat('Y-m-d H:i:s', $timestamp)->format($format);
    }
}
