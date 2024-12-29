<?php 
function removeSchool($id, $connect){
    $sql_query  = "DELETE FROM schools
           WHERE school_id=?";
   $stmt = $connect->prepare( $sql_query);
   $re   = $stmt->execute([$id]);
   if ($re) {
     return 1;
   }else {
    return 0;
   }
 }
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])     &&
    isset($_GET['school_id'])) {
  if ($_SESSION['role'] == 'Admin') {
     include "../database-connection.php";
     $id = $_GET['school_id'];
     if (removeSchool($id, $connect)) {
     	$success_message = "Successfully deleted!";
        header("Location: school.php?success=$success_message");
        exit;
     }else {
        $error_message = "Unknown error occurred";
        header("Location: school.php?error=$error_message");
        exit;
     }
  }else {
    header("Location: school.php");
    exit;
  } 
}else {
	header("Location: school.php");
	exit;
} 
?>