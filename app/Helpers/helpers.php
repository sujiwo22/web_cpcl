<?php

use Carbon\Carbon; // Example of using a Laravel class within a helper

if (! function_exists('format_date')) {
    function format_date($date, $format = 'F j, Y')
    {
        return Carbon::parse($date)->format($format);
    }
}

if (! function_exists('custom_greeting')) {
    function custom_greeting($name)
    {
        return 'Hello, '.$name.'!';
    }
}

if (! function_exists('current_url')) {
    function current_url()
    {
        $url = str_replace('/', '', $_SERVER['REQUEST_URI']);

        return $url;
    }
}

function checkActiveMenu($menuItem)
{
    // cek menu utama
    if (request()->is($menuItem->url) || request()->is($menuItem->url.'/*')) {
        return true;
    }

    // cek children jika ada
    if ($menuItem->children && $menuItem->children->count()) {
        foreach ($menuItem->children as $child) {
            if (checkActiveMenu($child)) {
                return true;
            }
        }
    }

    return false;
}
