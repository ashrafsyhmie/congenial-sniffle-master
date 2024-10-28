<?php

$password = "dLobjz@0";

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

echo $hashedPassword;
