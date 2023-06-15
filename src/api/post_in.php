<?php
require "../universal/db.php";
require "../universal/api.php";
require "../conf/conf.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    return_err("Invalid request method. Only accept POST requests");
}
if (!isset($_POST["id"])) {
    return_err("No ID provided");
}
if (!isset($_POST["input"])) {
    return_err("No input provided");
} else {
    $stmt = $mysqli->prepare("UPDATE exploits SET stdin = CONCAT(stdin, ?) WHERE id = ?");
    $input = urldecode($_POST["input"]);
    $stmt->bind_param("ss", $input, $_POST["id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($_POST["input"] !== "") {
        if ($stmt->affected_rows !== 1) {
            return_err("Invalid ID");
        }
    }
    return_succ("OK");
}