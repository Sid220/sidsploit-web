<?php
require "../universal/db.php";
require "../universal/api.php";
require "../conf/conf.php";


if (!isset($_GET["id"])) {
    return_err("No ID provided");
} else {
    $stmt = $mysqli->prepare("UPDATE exploits SET output = \"\" WHERE id = ?");
    $stmt->bind_param("s", $_GET["id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    return_succ("OK");
}