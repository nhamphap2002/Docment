<?php

// Word limit
function wordLimit($str, $limit = 100, $end_char = '&#8230;') {
    if (JString::trim($str) == '')
        return $str;

// always strip tags for text
    $str = strip_tags($str);

    $find = array("/\r|\n/u", "/\t/u", "/\s\s+/u");
    $replace = array(" ", " ", " ");
    $str = preg_replace($find, $replace, $str);

    preg_match('/\s*(?:\S*\s*){' . (int) $limit . '}/u', $str, $matches);
    if (JString::strlen($matches[0]) == JString::strlen($str))
        $end_char = '';
    return JString::rtrim($matches[0]) . $end_char;
}

// Character limit
function characterLimit($str, $limit = 150, $end_char = '...') {
    if (JString::trim($str) == '')
        return $str;

// always strip tags for text
    $str = strip_tags(JString::trim($str));

    $find = array("/\r|\n/u", "/\t/u", "/\s\s+/u");
    $replace = array(" ", " ", " ");
    $str = preg_replace($find, $replace, $str);

    if (JString::strlen($str) > $limit) {
        $str = JString::substr($str, 0, $limit);
        return JString::rtrim($str) . $end_char;
    } else {
        return $str;
    }
}

// Cleanup HTML entities
function cleanHtml($text) {
    return htmlentities($text, ENT_QUOTES, 'UTF-8');
}

?>