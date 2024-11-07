<?php

// $server = "localhost";
// $user = "u373315177_admin";
// $pass = "#2!U7Iw7@";
// $db = "u373315177_medassist";

$server = "localhost";
$user = "root";
$pass = "";
$db = "medassisst";

$conn = mysqli_connect($server, $user, $pass, $db);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
