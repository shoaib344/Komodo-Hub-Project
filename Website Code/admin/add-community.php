
<?php 

session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
       include "../database-connection.php";
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Add Community</title>
        <link rel="stylesheet" href="add.css">
</head>
<body>
<?php 
    include"navbar.php";  
?>

     <div class="back">
        <a href="community.php"
           class="back">Go Back</a>

        <form method="post"
              class="add" 
              action="community-functions/add-community.php">
        
              <h3>Add New Community</h3>
              <hr>
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




<div class="container">

      <div class="form-group">
          <label class="form-label">Community Name:</label>
          <input type="text" 
                 placeholder="Enter community Name"
                 name="community_name">
        </div>
        
        <div class="form-group">
          <label class="form-label"> Community Address:</label>
          <input type="text"
                 placeholder="Enter community Address Name"
                 name="community_address">
        </div>
 
          

      <button type="submit" class="add">Add</button>
     </form>
    
    </div>
      

</body>
</html>

<?php 

  }else {
    header("Location: ../login.php");
    exit;
  } 
}else {
	header("Location: ../login.php");
	exit;
} 
?>
