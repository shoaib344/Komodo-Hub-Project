<?php 
function getAllschools($connect) {
    $sql_query = "SELECT * FROM schools";
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
       
   
       $schools = getAllschools($connect);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Schools</title>
	<link rel="stylesheet" href="../style.css">
</head>
<body>

<?php 
    include"navbar.php";  
?>
<div align="center">
  <h1>Schools</h1>
</div>
<div class="add">
    <a href="add-school.php" class="add">Add New School</a>
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
    <?php if (!empty($schools)) { ?>
<table class="stats">
    <thead>
    <tr>
      <th</th>
      <th scope="col">ID</th>
      <th scope="col">School Name</th>
      <th scope="col">School Address</th>
      <th scope="col">School Type</th>
      <th scope="col">Manage</th>
</tr>
</thead>
<tbody>
    <?php foreach ($schools as $school) { ?>
        <tr>
          <td><?=$school['school_id']?></td>
          <td><?=$school['school_name']?></td>
          <td><?=$school['school_address']?></td>
          <td><?=$school['school_type']?></td>
          <td>
          <a href="edit-school.php?school_id=<?=$school['school_id']?>" class="edit">Edit</a>
          <a href="delete-school.php?school_id=<?=$school['school_id']?>" class="delete">Delete</a>
          </td> 
</tr>
      <?php } ?>
</tbody>
</table>
    <?php } else { ?>
          <div class="empty">
              No School Found!
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