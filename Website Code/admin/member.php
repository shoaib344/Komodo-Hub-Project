<?php 

function getAllmembers($connect) {
    $sql_query = "SELECT * FROM member";
    $stmt = $connect->prepare($sql_query);
    $stmt->execute();
    return $stmt->fetchAll();
  }
function communityById($community_id, $connect) {
    $sql_query = "SELECT * FROM community WHERE community_id=?";
    $stmt = $connect->prepare($sql_query);
    $stmt->execute([$community_id]);

    return $stmt->fetch() ?: 0;
}
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
       include "../database-connection.php";
       $members = getAllmembers($connect);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Members</title>
	<link rel="stylesheet" href="../style.css">

</head>
<body>
<?php 
    include"navbar.php";  
?>
<div align="center">
  <h1> Community Member</h1>
</div>

<div class="add">
    <a href="add-member.php" class="add">Add New Member</a>

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
    <?php if (!empty($members)) { ?>
<table class="stats">
    <thead>
    <tr>
      <th</th>
      <th scope="col">ID</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Username</th>
      <th scope="col">Community Name</th>
      <th scope="col">Email</th>
      <th scope="col">Phone</th>
      <th scope="col">Manage</th>
</tr>
</thead>
<tbody>
    <?php foreach ($members as $member) { ?>
        <tr>
          
          <td><?=$member['member_id']?></td>
          <td><?=$member['first_name']?></td>
          <td><?=$member['last_name']?></td>
          <td><?=$member['username']?></td>
<td>
    <?php 
        $result = '';
        $communities = str_split(trim($member['community_id']));
        
        foreach ($communities as $community) {
            $communityData = communityById($community, $connect);
            
            if ($communityData != 0) {
                $result .= $communityData['community_name'];
            }
        } 
        echo $result;
    ?>
</td>      
<td><?=$member['email']?></td>
<td><?=$member['phone']?></td>
<td>
          <a href="edit-member.php?member_id=<?=$member['member_id']?>" class="edit">Edit</a>
          <a href="delete-member.php?member_id=<?=$member['member_id']?>" class="delete">Delete</a>
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