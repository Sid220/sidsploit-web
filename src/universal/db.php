<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

if(!isset($SRCDIR))
    $SRCDIR = "../";
require $SRCDIR . "conf/conf.php";

$mysqli = new mysqli($DATABASE["host"], $DATABASE["username"], $DATABASE["password"], $DATABASE["database"]);