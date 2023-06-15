<?php
function return_err($message)
{
    header("Content-Type: application/json");
    echo json_encode(array("error" => $message));
    exit();
}

function return_succ($message)
{
    header("Content-Type: application/json");
    echo json_encode(array("success" => $message));
    exit();
}