<?php

function settings($key = null)
{
    if ($key === null) {
       return app(\App\Classes\Settings::class);
    }

    return app(\App\Classes\Settings::class)->get('private');
}
