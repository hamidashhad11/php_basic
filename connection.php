<?php
$server = 'localhost';
$username = 'root';
$pass = 'coeus123';
$db = 'practice';

$connection = new mysqli($server,$username, $pass, $db);
if($connection->connect_error){
    die ('cannot connect to database. '. $connection->connect_error);
}
