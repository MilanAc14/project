<?php
//connecting to database
$server = "localhost";
$username = "root";
$password = "";
$database = "ecommerce";

$conn = mysqli_connect($server, $username, $password, $database);
if (!$conn){
//     echo "success";
// }
// else{
    die("Error". mysqli_connect_error());
}

?>