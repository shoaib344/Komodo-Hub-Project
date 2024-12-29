<?php 

function getAllAdmins($connect) {
    $sql_query = "SELECT * FROM admin";
    $stmt = $connect->prepare($sql_query);
    $stmt->execute();
    return $stmt->fetchAll();
  }



function adminById($admin_id, $connect) {
    $sql_query = "SELECT * FROM admin WHERE admin_id=?";
    $stmt = $connect->prepare($sql_query);
    $stmt->execute([$admin_id]);

    return $stmt->fetch() ?: 0;
}



session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
       include "../database-connection.php";
       
   
       $admins = getAllAdmins($connect);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - admins</title>
	<link rel="stylesheet" href="../style.css">

</head>
<body>

<?php 
    include"navbar.php";  
?>
<div align="center">
  <h1>Admins</h1>
</div>
<div class="add">
    <a href="add-admin.php" class="add">Add New admin</a>

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
    <?php if (!empty($admins)) { ?>
<table class="stats">
    <thead>
    <tr>
      <th</th>
      <th scope="col">ID</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Username</th>
</tr>
</thead>
<tbody>
    <?php foreach ($admins as $admin) { ?>
        <tr>
          
          <td><?=$admin['admin_id']?></td>
          <td><?=$admin['first_name']?></td>
          <td><?=$admin['last_name']?></td>
          <td><?=$admin['username']?></td>
           
         
        
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