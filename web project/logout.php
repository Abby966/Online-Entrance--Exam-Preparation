<?php
session_start();

if (isset($_COOKIE['remember_me_token'])) {
    $conn = new mysqli("localhost", "root", "", "intrance_prep_app");
    if (!$conn->connect_error) {
        $token = $_COOKIE['remember_me_token'];
        $stmt = $conn->prepare("DELETE FROM remember_me WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

    setcookie("remember_me_token", "", time() - 3600, "/"); // Expire cookie
}

session_unset();
session_destroy();

header("Location: login.php");
exit();

