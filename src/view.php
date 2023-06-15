<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
$SRCDIR = "./";
require "universal/require_login.php";
require "universal/db.php";
require "universal/helpers.php";

if (!isset($_GET["id"])) {
    header("Location: /");
    exit();
}

$stmt = $mysqli->prepare("SELECT * FROM exploits WHERE id = ?");
$stmt->bind_param("s", $_GET["id"]);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows !== 1) {
    header("Location: /");
    exit();
}
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Exploit | SidSploit</title>
    <link rel="stylesheet" href="static/main.css"/>
</head>
<body>
<h1><?= $row["name"] ?></h1>
<pre id="output">Loading...</pre>
<div id="send-container">
    <input type="text" id="send-input">
    <button id="send-button">SEND</button>
    <button id="send-button-pure">SEND (no newline)</button>
    <button class="send-sig" data-signal="SIGINT">CTRL+C (SIGINT)</button>
    <button class="send-sig" data-signal="SIGTERM">SIGTERM</button>
    <button class="send-sig" data-signal="SIGQUIT">SIGQUIT</button>
    <button class="send-sig" data-signal="SIGKILL">SIGKILL</button>
    <button class="send-sig" data-signal="\n">\n (Newline)</button>
    <button class="send-sig" data-signal="\t">\t (Tab)</button>
    <button id="reset">RESET</button>
    <a href="http://localhost:8089/api/get_out.php?id=<?= htmlspecialchars($_GET["id"]) ?>" target="_blank">
        <button>Download</button>
    </a>
</div>
<script>
    function getData() {
        fetch("http://localhost:8089/api/get_out.php?id=<?= $_GET["id"] ?>")
            .then((response) => response.text())
            .then((text) => {
                if (text === "") {
                    text = "[NONE]";
                }
                document.getElementById("output").innerText = text;
            });
    }

    setInterval(getData, 1000);

    document.getElementById("reset").addEventListener("click", () => {
        fetch("http://localhost:8089/controller/clear.php?id=<?= $_GET["id"] ?>");
        getData();
    });

    const stdin = document.getElementById("send-input");

    const sendInput = (newLine = true) => {
        fetch("http://localhost:8089/api/post_in.php",
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: "id=<?= $_GET["id"] ?>&input=" + encodeURIComponent(stdin.value) + (newLine ? "%0A" : ""),
            }
        )
            .then((response) => response.json())
            .then((data) => {
                if (typeof data["success"] === "undefined") {
                    alert("Error: " + data["error"]);
                } else {
                    stdin.value = "";
                }
            });
    }

    document.getElementById("send-button").addEventListener("click", sendInput);
    document.getElementById("send-button-pure").addEventListener("click", () => {
        sendInput(false)
    });

    stdin.addEventListener("keydown", (event) => {
        if (event.key === "Enter") {
            sendInput();
        }
    });

    [...document.getElementsByClassName("send-sig")].forEach((ele) => {
        ele.addEventListener("click", () => {
            stdin.value = "[SIDSIG]" + ele.dataset.signal + "[/SIDSIG]";
            sendInput(false);
        });
    });
</script>
</body>
</html>