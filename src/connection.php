<?php
$servername = "localhost";
$username = "u148988291_wcst"; // Change username
$password = "c6ehxV57"; // Change password
$dbname = "u148988291_wcst_db"; // Change database name

$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>