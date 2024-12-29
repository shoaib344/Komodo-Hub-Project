<?php 
function removeCommunity($id, $connect){
    $sql_query  = "DELETE FROM community
           WHERE community_id=?";
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
    isset($_GET['community_id'])) {
  if ($_SESSION['role'] == 'Admin') {
     include "../database-connection.php";
     $id = $_GET['community_id'];
     if (removeCommunity($id, $connect)) {
     	$success_message = "Successfully Deleted!";
        header("Location: community.php?success=$success_message");
        exit;
     }else {
        $error_message = "Unknown error occurred";
        header("Location: community.php?error=$error_message");
        exit;
     }
  }else {
    header("Location: community.php");
    exit;
  } 
}else {
	header("Location: community.php");
	exit;
} 
?>