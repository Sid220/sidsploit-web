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
if (!isset($_POST["output"])) {
    return_err("No output provided");
} else {
    $stmt = $mysqli->prepare("UPDATE exploits SET output = CONCAT(output, ?) WHERE id = ?");
    $output = urldecode($_POST["output"]);
    $stmt->bind_param("ss", $output, $_POST["id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($_POST["output"] !== "") {
        if ($stmt->affected_rows !== 1) {
            return_err("Invalid ID");
        }
    }
    return_succ("OK");
}