<?php

if (!function_exists('truncate_text')) {
    function truncate_text($text, $length) {
        $stripped_text = strip_tags($text);
        if (strlen($stripped_text) > $length) {
            $truncated_text = substr($stripped_text, 0, $length) . '...';
        } else {
            $truncated_text = $stripped_text;
        }
        return $truncated_text;
    }
}
