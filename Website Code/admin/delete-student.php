<?php 

function removeStudent($id, $connect){
    $sql_query  = "DELETE FROM students
           WHERE student_id=?";
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
    isset($_GET['student_id'])) {

  if ($_SESSION['role'] == 'Admin') {
     include "../database-connection.php";
  
     $id = $_GET['student_id'];
     if (removeStudent($id, $connect)) {
     	$success_message = "Successfully deleted!";
        header("Location: student.php?success=$success_message");
        exit;
     }else {
        $error_message = "Unknown error occurred";
        header("Location: student.php?error=$error_message");
        exit;
     }


  }else {
    header("Location: student.php");
    exit;
  } 
}else {
	header("Location: student.php");
	exit;
} 
?>