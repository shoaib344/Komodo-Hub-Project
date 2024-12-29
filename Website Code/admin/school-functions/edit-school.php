<?php 
function UniqueSchoolName($school_name, $connect, $school_id = 0) {
  $sql_query = "SELECT school_name, school_id FROM schools WHERE school_name=?";
  $stmt = $connect->prepare($sql_query);
  $stmt->execute([$school_name]);
  if ($school_id == 0) {
      return $stmt->rowCount() === 0;
  } else {
      if ($stmt->rowCount() >= 1) {
          $school = $stmt->fetch();
          return $school['school_id'] == $school_id;
      } else {
          return true;
      }
  }
}
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {  
  include '../../database-connection.php';
  $school_name = $_POST['school_name'];
$school_address = $_POST['school_address'];
$school_type = $_POST['school_type'];;
  $school_id = $_POST['school_id'];
  $urlData = 'school_id=' . $school_id;
  if (empty($school_name) || empty($school_address) || empty($school_type) 
  ) {
      $error_message = "All fields are required";
      header("Location: ../add-school.php?error=$error_message");
      exit;
  }
  elseif (!UniqueSchoolName($school_name, $connect, $school_id)) {
      $error_message = "school_name is taken! Try another.";
      header("Location: ../edit-school.php?error=$error_message&$urlData");
      exit;
  } else {
      $sql_query = "UPDATE schools SET school_name=?, school_address=?, school_type=? WHERE school_id=?";
      $stmt = $connect->prepare($sql_query);
      $stmt->execute([$school_name,$school_address,$school_type, $school_id]);
      $success_message = "Successfully updated!";
      header("Location: ../edit-school.php?success=$success_message&$urlData");
      exit;
  }
} else {
  header("Location: ../../logout.php");
  exit;
}