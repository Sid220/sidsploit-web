<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
$SRCDIR = "./";
require "universal/require_login.php";
require "universal/db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Exploits | SidSploit</title>
</head>
<body>
<h1>My Exploits</h1>
<p><?=$_SESSION['email']?> - <a href="login/logout.php">Logout</a></p>
<p><a href="controller/create.php">Create Exploit</a></p>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>View</th>
        <th>Delete</th>
    </tr>
    <?php
    $stmt = $mysqli->prepare("SELECT * FROM exploits WHERE owner = ?");
    $stmt->bind_param("i", $_SESSION["id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td><a href=\"view.php?id=" . $row["id"] . "\">View</a></td>";
        echo "<td><a href=\"controller/delete.php?id=" . $row["id"] . "\">Delete</a></td>";
        echo "</tr>";
    }
    ?>
</table>
</body>
</html>