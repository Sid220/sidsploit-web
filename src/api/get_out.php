<?php
require "../universal/db.php";
require "../universal/api.php";
require "../conf/conf.php";


if (!isset($_GET["id"])) {
    return_err("No ID provided");
} else {
    $stmt = $mysqli->prepare("SELECT output FROM exploits WHERE id = ?");
    $stmt->bind_param("s", $_GET["id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows !== 1) {
        return_err("Invalid ID");
    } else {
        header("Content-Type: text/plain");
        $row = $result->fetch_assoc();
        echo $row["output"];
    }
}