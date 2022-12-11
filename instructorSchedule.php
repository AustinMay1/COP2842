<?php

require "programClasses.php";

$connection = "mysql:host=localhost;dbname=classschedules;charset=utf8mb4";
$user = "root";
$password = "";
$err = "";
$instructors = array();
try
{
    $pdo = new PDO($connection, $user, $password);
    
}
catch (PDOException $e) 
{
    $err = $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Schedule</title>
</head>
<body>
    
</body>
</html>