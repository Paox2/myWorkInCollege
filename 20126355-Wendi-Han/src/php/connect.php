<!-- use to connect database -->
<?php

$servername = "localhost";
$username = "scywh1";
$password = "Hwd493hwd..";
$dbname = "scywh1";

$conn = new mysqli($servername, $username, $password, $dbname);


if($conn->connect_error)
{
die("Connection failed: " . $conn->connect_error);
}
?>