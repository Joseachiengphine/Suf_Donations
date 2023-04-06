<?php
if (!function_exists('setting')) {
    /**
     * Get a setting value from the database
     * @param string $slug
     * @param mixed $default
     * @return mixed
     */
    function setting($slug, $default=null) {
        $setting = \App\Setting::query()->whereSlug($slug)->first();
        if (!$setting) return $default;
        return $setting->payload ?? $default;
    }
}
