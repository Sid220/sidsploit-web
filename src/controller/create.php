<?php
require "../universal/require_login.php";
require "../universal/db.php";
require "../universal/helpers.php";
$error = "";
if($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["name"])) {
        if($_POST["name"] === "") {
            $error = "Please fill out all fields.";
        } else {
            $stmt = $mysqli->prepare("INSERT INTO exploits (id, name, owner) VALUES (?, ?, ?)");
            $uuid = uuidv4();
            $stmt->bind_param("ssi", $uuid, $_POST["name"], $_SESSION["id"]);
            $stmt->execute();
            header("Location: /");
            exit();
        }
    } else {
        $error = "Please fill out all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Exploit | SidSploit</title>
</head>
<body>
<h1>Create Exploit</h1>
<form method="POST" action="./create.php">
    <p><?= $error ?></p>
    <label>
        Name: <input type="text" name="name" placeholder="My Awesome Exploit">
    </label>
    <br>
    <input type="submit" value="Create">
</form>
</body>
</html>