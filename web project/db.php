<?php
$host = "sql303.infinityfree.com"; // replace with your host
$username = "if0_40301223";       // replace with your username
$password = "Mama01031621";      // your database password
$database = "if0_40301223_fetena"; // your database name

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

