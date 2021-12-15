<?php


namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class ModelHelper
{
    public static function convert_to_slug($model, $url, $parentPage = 0){
        $url = str_slug($url, '-');

        $parentPage = $model::find($parentPage);
        if($parentPage) {
            $url = $parentPage->slug.'/'.$url;
        }


        if (self::check_if_slug_exists($model, $url)) {
            $counter = 2;
            $tempUrl = $url.'-'.$counter;
            while (self::check_if_slug_exists($model, $tempUrl)) {
                $tempUrl = $url.'-'.$counter;
                $counter += 1;
            }

            $url = $tempUrl;
        }

        return $url;
    }

    private static function check_if_slug_exists($model, $slug){
        return ($model::withTrashed()->where('slug', '=', $slug)->exists());
    }

    public static function date_str($date) {
        return date('M d, Y', strtotime($date));
    }

    public static function date_time_str($date) {
        return date('M d, Y h:i A', strtotime($date));
    }
}
