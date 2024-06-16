<?php

$HOSTNAME = "localhost";
$USERNAME = "root";
$PASSWORD = "root";
$DB_NAME = "db_registration";

$conn = mysqli_connect("$HOSTNAME", "$USERNAME", "$PASSWORD", "$DB_NAME"); 

if(!$conn){
    die(mysqli_error($conn));
} 

?>