<?php 
function removeTeacher($id, $connect){
    $sql_query  = "DELETE FROM teachers
           WHERE teacher_id=?";
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
    isset($_GET['teacher_id'])) {

  if ($_SESSION['role'] == 'Admin') {
     include "../database-connection.php";
    
     $id = $_GET['teacher_id'];
     if (removeTeacher($id, $connect)) {
     	$success_message = "Successfully deleted!";
        header("Location: teacher.php?success=$success_message");
        exit;
     }else {
        $error_message = "Unknown error occurred";
        header("Location: teacher.php?error=$error_message");
        exit;
     }
  }else {
    header("Location: teacher.php");
    exit;
  } 
}else {
	header("Location: teacher.php");
	exit;
} 
?>