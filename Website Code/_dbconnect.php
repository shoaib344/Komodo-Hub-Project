

<?php  

$serverName = "localhost";
$databaseUser = "root";
$databasePassword = "";
$databaseName = "komodo";

try {
    $conn = new PDO("mysql:host=$serverName;dbname=$databaseName", $databaseUser, $databasePassword);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
	exit;
}



?>