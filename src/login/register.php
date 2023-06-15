<?php
require "../universal/session.php";
require "../universal/db.php";

$error = "";

if (isset($_SESSION["email"])) {
    header("Location: /");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        if ($_POST["email"] === "" || $_POST["password"] === "" || (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))) {
            $error = "Please fill out all fields.";
        } else {
            $email = $_POST["email"];
            $password = $_POST["password"];
            $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows === 0) {
                $stmt = $mysqli->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt->bind_param("ss", $email, $password_hash);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $_SESSION["email"] = $row["email"];
                $_SESSION["id"] = $row["id"];
                header("Location: /");
                exit();
            } else {
                $error = "Email already in use.";
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
    <title>Register | SidSploit</title>
</head>
<body>
<?= $error ?>
<form method="POST" action="register.php">
<label>
    Email: <input type="email" name="email" placeholder="Email">
</label><br>
<label>
    Password: <input type="password" name="password" placeholder="Password">
</label><br>
<p>Already have an account? <a href="login.php">Login</a></p>
    <p>Sidney Trzepacz is not in any way responsible for, nor condones, any illegal actions which may use this
        software</p>
    <input type="submit" value="Register">
</form>
</body>
</html>