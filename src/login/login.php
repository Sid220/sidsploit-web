<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
require "../universal/session.php";
require "../universal/db.php";

$error = "";

if (isset($_SESSION["email"])) {
    header("Location: /");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        if ($_POST["email"] === "" || $_POST["password"] === "") {
            $error = "Please fill out all fields.";
        } else {
            $email = $_POST["email"];
            $password = $_POST["password"];
            $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row["password"])) {
                    $_SESSION["email"] = $row["email"];
                    $_SESSION["id"] = $row["id"];
                    header("Location: /");
                    exit();
                } else {
                    $error = "Incorrect email/password.";
                }
            } else {
                $error = "Incorrect email/password.";
            }
        }
    } else {
        $error = "Please fill out all fields.";
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | SidSploit</title>
</head>
<body>
<?= $error ?>
<form method="POST" action="login.php">
    <label>
        Email: <input type="email" name="email" placeholder="Email">
    </label><br>
    <label>
        Password: <input type="password" name="password" placeholder="Password">
    </label><br>
    <p>New? <a href="register.php">Register</a></p>
    <p>Sidney Trzepacz is not in any way responsible for, nor condones, any illegal actions which may use this software</p>
    <input type="submit" value="Login">
</form>
</body>
</html>