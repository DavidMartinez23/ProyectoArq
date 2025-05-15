<?php

if (!function_exists('getYoutubeVideoId')) {
    function getYoutubeVideoId($url) {
        $pattern = '/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
        preg_match($pattern, $url, $matches);
        return isset($matches[1]) ? $matches[1] : null;
    }
}