<?php
function uuidv4()
{
    $data = openssl_random_pseudo_bytes(16);

    assert(strlen($data) == 16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function escape_javascript_string($str)
{
    // if php supports json_encode, use it (support utf-8)
    if (function_exists('json_encode')) {
        return json_encode($str);
    }
    // php 5.1 or lower not support json_encode, so use str_replace and addcslashes
    // remove carriage return
    $str = str_replace("\r", '', (string)$str);
    // escape all characters with ASCII code between 0 and 31
    $str = addcslashes($str, "\0..\37'\\");
    // escape double quotes
    $str = str_replace('"', '\"', $str);
    // replace \n with double quotes
    $str = str_replace("\n", '\n', $str);
    return "'{$str}'";
}