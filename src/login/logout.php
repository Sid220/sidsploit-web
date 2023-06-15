<?php
include "../universal/session.php";
session_destroy();
header("Location: /login/login.php");