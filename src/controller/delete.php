<?php
require "../universal/require_login.php";
require "../universal/db.php";
require "../universal/helpers.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    echo $_POST["DODELETE"];
    if (isset($_POST["DODELETE"]) && $_POST["DODELETE"] !== "") {
        $stmt = $mysqli->prepare("DELETE FROM exploits WHERE id = ?");
        $stmt->bind_param("s", $_POST["DODELETE"]);
        $stmt->execute();
        header("Location: /");
        exit();
    }
}
else {
    if(!isset($_GET['id'])) {
        header("Location: /");
        exit();
    }
    if($_GET['id'] === "") {
        header("Location: /");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Delete Exploit | SidSploit</title>
</head>
<body>
<h1>Delete Exploit</h1>
<p>Are you sure you wish to delete exploit <?= htmlspecialchars($_GET['id']) ?>?</p>
<form method="POST" action="./delete.php">
    <input type="hidden" name="DODELETE" value="<?= htmlspecialchars($_GET['id']) ?>">
    <a href="/">
        <button type="button">Cancel</button>
    </a>
    <input type="submit" value="Delete">
</form>
</body>
</html>