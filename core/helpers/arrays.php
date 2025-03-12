<?php 

function splitAtFirstDot($string) {
    $parts = explode('.', $string, 2);
    return count($parts) === 2 ? $parts : [$string, ''];
}