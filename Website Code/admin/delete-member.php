<?php 

function removeMember($id, $connect){
    $sql_query  = "DELETE FROM member
           WHERE member_id=?";
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
    isset($_GET['member_id'])) {

  if ($_SESSION['role'] == 'Admin') {
     include "../database-connection.php";
    

     $id = $_GET['member_id'];
     if (removeMember($id, $connect)) {
     	$success_message = "Successfully Deleted!";
        header("Location: member.php?success=$success_message");
        exit;
     }else {
        $error_message = "Unknown error occurred";
        header("Location: member.php?error=$error_message");
        exit;
     }


  }else {
    header("Location: member.php");
    exit;
  } 
}else {
	header("Location: member.php");
	exit;
} 


?>