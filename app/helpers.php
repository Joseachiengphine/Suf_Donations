<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    /**
     * Get a setting value from the database
     * @param string $slug
     * @param mixed $default
     * @return mixed
     */
    function setting($slug, $default=null) {
        $setting = Setting::query()->whereSlug($slug)->first();
        if (!$setting) return $default;
        return $setting->payload ?? $default;
    }
}
