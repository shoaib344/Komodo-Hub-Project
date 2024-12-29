<?php  

$serverName = "localhost";
$databaseUser = "root";
$databasePassword = "";
$databaseName = "user_management";

try {
    $connect = new PDO("mysql:host=$serverName;dbname=$databaseName", $databaseUser, $databasePassword);
	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
	exit;
}



?>