<?php
if(!isset($SRCDIR))
    $SRCDIR = "../";
require $SRCDIR . "universal/session.php";
require $SRCDIR . "universal/db.php";

if(!isset($_SESSION["email"])) {
    header("Location: /login/login.php");
    exit();
}
