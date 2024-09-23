<?php

$server = "localhost";
$user = "root";
$pass = "";
$db = "medassisst_try_gabung";

$conn = mysqli_connect($server, $user, $pass, $db);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
