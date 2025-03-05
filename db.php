<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "ecommerce";

require_once 'db_init.php';

$conn = mysqli_connect($host, $user, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
