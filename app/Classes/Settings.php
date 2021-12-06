<?php
namespace App\Classes;

use Illuminate\Support\Facades\Storage;

class Settings
{
    public static $publicData;

    public static function loadSettings()
    {
        if (Storage::disk('local')->exists(env('PUBLIC_FILENAME')) === false) {
            return false;
        }

        self::$publicData = Storage::disk('local')->get(env('PUBLIC_FILENAME'));

        return true;
    }

    public static function get()
    {
        return self::$publicData;
    }
}
