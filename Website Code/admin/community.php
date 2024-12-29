<?php 
function getAllcommunitys($connect) {
    $sql_query = "SELECT * FROM community";
    $stmt = $connect->prepare($sql_query);
    $stmt->execute();
    return $stmt->fetchAll();
  }
function communityById($community_id, $connect) {
    $sql_query = "SELECT * FROM communitys WHERE community_id=?";
    $stmt = $connect->prepare($sql_query);
    $stmt->execute([$community_id]);

    return $stmt->fetch() ?: 0;
}
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
       include "../database-connection.php";
       $communities = getAllcommunitys($connect);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - communitys</title>
	<link rel="stylesheet" href="../style.css">
</head>
<body>
<?php 
    include"navbar.php";  ?>
<div align="center">
  <h1>Communities</h1>
</div>
<div class="add">
    <a href="add-community.php" class="add">Add New community</a>
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
    <?php if (!empty($communities)) { ?>
<table class="stats">
    <thead>
    <tr>
      <th</th>
      <th scope="col">ID</th>
      <th scope="col">Community Name</th>
      <th scope="col">Community Address</th>
      <th scope="col">Manage</th>
</tr>
</thead>
<tbody>
    <?php foreach ($communities as $community) { ?>
        <tr>    
    <td><?=$community['community_id']?></td>
    <td><?=$community['community_name']?></td>
    <td><?=$community['community_address']?></td>    
    <td>
    <a href="edit-community.php?community_id=<?=$community['community_id']?>" class="edit">Edit</a>
    <a href="delete-community.php?community_id=<?=$community['community_id']?>" class="delete">Delete</a>
    </td>     
</tr><?php } ?>
</tbody>
</table>
    <?php } else { ?>
    <div class="empty">
        No Community found!
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