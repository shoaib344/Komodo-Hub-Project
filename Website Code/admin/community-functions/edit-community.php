<?php 
function UniqueCommunityName($community_name, $connect, $community_id = 0) {
  $sql_query = "SELECT community_name, community_id FROM community WHERE community_name=?";
  $stmt = $connect->prepare($sql_query);
  $stmt->execute([$community_name]);

  if ($community_id == 0) {
      return $stmt->rowCount() === 0;
  } else {
      if ($stmt->rowCount() >= 1) {
          $community = $stmt->fetch();
          return $community['community_id'] == $community_id;
      } else {
          return true;
      }}}
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
  include '../../database-connection.php';
  $community_name = $_POST['community_name'];
$community_address = $_POST['community_address'];
  $community_id = $_POST['community_id'];
  $urlData = 'community_id=' . $community_id;
  if (empty($community_name) || empty($community_address)
  ) {
      $error_message = "All fields are required";
      header("Location: ../add-community.php?error=$error_message");
      exit;
  }
  elseif (!UniqueCommunityName($community_name, $connect, $community_id)) {
      $error_message = "community_name is taken! Try another.";
      header("Location: ../edit-community.php?error=$error_message&$urlData");
      exit;
  } else {
      $sql_query = "UPDATE community SET community_name=?, community_address=? WHERE community_id=?";
      $stmt = $connect->prepare($sql_query);
      $stmt->execute([$community_name,$community_address, $community_id]);
      $success_message = "Successfully updated!";
      header("Location: ../edit-community.php?success=$success_message&$urlData");
      exit;
  }
} else {
  header("Location: ../../logout.php");
  exit;
}?>