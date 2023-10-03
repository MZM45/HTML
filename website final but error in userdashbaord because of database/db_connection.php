<?php

$conn = mysqli_connect("localhost", "root", "", "register");

if (!$conn) {
    die("ERROR" . mysqli_connect_error());
} else
    echo "";
