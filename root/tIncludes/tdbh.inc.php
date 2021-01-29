<?php
// This codes only purpuse is to connect and make sure it does connect to the database
$servername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "blogg";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection unsuccesfull: " . mysqli_connect_error());
}