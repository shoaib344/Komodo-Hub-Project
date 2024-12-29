<?php 
function UniqueUsername($username, $connect, $member_id = 0) {
  $sql_query = "SELECT username, member_id FROM member WHERE username=?";
  $stmt = $connect->prepare($sql_query);
  $stmt->execute([$username]);

  if ($member_id == 0) {
      return $stmt->rowCount() === 0;
  } else {
      if ($stmt->rowCount() >= 1) {
          $member = $stmt->fetch();
          return $member['member_id'] == $member_id;
      } else {
          return true;
      }
  }
}

session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
    
  include '../../database-connection.php';
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $username = $_POST['username'];
  $member_id = $_POST['member_id'];
  $community_id = $_POST['community_id'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $urlData = 'member_id=' . $member_id;

  if (empty($first_name) || empty($last_name) || empty($username) || empty($community_id) || empty($email) || empty($phone)) {
      $error_message = "All fields are required";
      header("Location: ../edit-member.php?error=$error_message&$urlData");
      exit;
  } elseif (!UniqueUsername($username, $connect, $member_id)) {
      $error_message = "Username is taken! Try another.";
      header("Location: ../edit-member.php?error=$error_message&$urlData");
      exit;
  } else {
      $sql_query = "UPDATE member SET username=?, first_name=?, last_name=?, community_id=?, email=?, phone=? WHERE member_id=?";
      $stmt = $connect->prepare($sql_query);
      $stmt->execute([$username, $first_name, $last_name, $community_id, $email, $phone, $member_id]);
      $success_message = "Successfully updated!";
      header("Location: ../edit-member.php?success=$success_message&$urlData");
      exit;
  }
} else {
  header("Location: ../../logout.php");
  exit;
}