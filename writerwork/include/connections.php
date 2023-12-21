<?php
$dbHost = "localhost";
$dbUser = "root";
$dbpassword  ="";
$dbName = "writerGig";

$conn = new mysqli($dbHost, $dbUser, $dbpassword, $dbName);
if($conn->connect_error){
    die("error connecting to dababase");
}

