<?php 
function getAllteachers($connect) {
    $sql_query = "SELECT * FROM teachers";
    $stmt = $connect->prepare($sql_query);
    $stmt->execute();
    return $stmt->fetchAll();
  }
function schoolById($school_id, $connect) {
    $sql_query = "SELECT * FROM schools WHERE school_id=?";
    $stmt = $connect->prepare($sql_query);
    $stmt->execute([$school_id]);
    return $stmt->fetch() ?: 0;
}
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
       include "../database-connection.php";
       $teachers = getAllteachers($connect);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Teachers</title>
	<link rel="stylesheet" href="../style.css">
</head>
<body>
<?php 
    include"navbar.php";  
?>
<div align="center">
  <h1>Teachers</h1>
</div>
<div class="add">
    <a href="add-teacher.php" class="add">Add New Teacher</a>
    <?php
if (isset($_GET['error'])) {
    echo '<div class="error">' , 
    $_GET['error'] , '</div>' ;
}
if (isset($_GET['success'])) {
    echo '<div class="success">' ,
     $_GET['success'] , '</div>' ;
}
?>
<div class="table">
    <?php if (!empty($teachers)) { ?>
<table class="stats">
    <thead>
    <tr>
      <th</th>
      <th scope="col">ID</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Username</th>
      <th scope="col">School Name</th>
      <th scope="col">Email</th>
      <th scope="col">Phone</th>
      <th scope="col">Manage</th>
</tr>
</thead>
<tbody>
    <?php foreach ($teachers as $teacher) { ?>
        <tr>   
          <td><?=$teacher['teacher_id']?></td> 
          <td><?=$teacher['first_name']?></td>
          <td><?=$teacher['last_name']?></td>
          <td><?=$teacher['username']?></td>
<td>
    <?php 
        $result = '';
        $schools = str_split(trim($teacher['school_id'])); 
        foreach ($schools as $school) {
            $schoolData = schoolById($school, $connect);     
            if ($schoolData != 0) {
                $result .= $schoolData['school_name'];
            }
        } 
        echo $result;
    ?>
</td>
        <td><?=$teacher['email']?></td>
          <td><?=$teacher['phone']?></td>    
          <td>
          <a href="edit-teacher.php?teacher_id=<?=$teacher['teacher_id']?>" class="edit">Edit</a>
          <a href="delete-teacher.php?teacher_id=<?=$teacher['teacher_id']?>" class="delete">Delete</a>
          </td> 
</tr>
      <?php } ?>
</tbody>
</table>
    <?php } else { ?>
          <div class="empty">
              Empty!
          </div>
    <?php } ?>
</div>
</div>
</body>
</html>
<?php 
} else {
    header("Location: ../login.php");
    exit;
} 
} else {
header("Location: ../login.php");
exit;
} 
?>