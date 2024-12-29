<?php
function communityById($community_id, $connect) {
    $sql_query = "SELECT * FROM community WHERE community_id=?";
    $stmt = $connect->prepare($sql_query);
    $stmt->execute([$community_id]);
    return $stmt->rowCount() == 1 ? $stmt->fetch() : 0;
}
function getAllcommunitys($connect){
    $sql_query = "SELECT * FROM community";
    $stmt = $connect->prepare($sql_query);
    $stmt->execute();
    return $stmt->fetchAll();
  }
session_start();
if (
    isset($_SESSION['admin_id']) &&
    isset($_SESSION['role']) &&
    isset($_GET['community_id'])
) {
    if ($_SESSION['role'] == 'Admin') {
        include "../database-connection.php";
        $community_id = $_GET['community_id'];
        $community = communityById($community_id, $connect);
        $communitys = getAllcommunitys($connect);

    if ($community === 0) {
        header("Location: community.php");
        exit;}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Edit Community</title>
	<link rel="stylesheet" href="edit.css">
</head>
<body>
<?php 
    include "navbar.php";  ?>
<div class="back">
    <a href="community.php" class="back">Go Back</a>
</div>
<form method="post" class="edit" action="community-functions/edit-community.php">
    <h3>Edit Community</h3>
    <hr>
    <?php
    if (isset($_GET['error'])) {
        echo '<div class="error">', $_GET['error'], '</div>';
    }
    if (isset($_GET['success'])) {
        echo '<div class="success">', $_GET['success'], '</div>';
    }
    ?>
    <input type="text" value="<?= $community['community_id'] ?>" name="community_id" hidden>
    <div class="container">
    <div class="form-group">
          <label class="form-label">Community Name:</label>
          <input type="text" 
          value="<?= $community['community_name'] ?>"
                 placeholder="Enter community Name"
                 name="community_name">
        </div>
        <div class="form-group">
          <label class="form-label"> community Address:</label>
          <input type="text"
          value="<?= $community['community_address'] ?>"
                 placeholder="Enter community Address Name"
                 name="community_address">
        </div>
        <button type="submit" class="update">Update</button>
    </div>
</form>
</body>
</html>
<?php
} else {
    header("Location: community.php");
    exit;
}
} else {
    header("Location: community.php");
    exit;
}?>