
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
	<title>Admin - Add School</title>
        <link rel="stylesheet" href="add.css">
</head>
<body>
<?php 
    include"navbar.php";  
?>

     <div class="back">
        <a href="school.php"
           class="back">Go Back</a>

        <form method="post"
              class="add" 
              action="school-functions/add-school.php">
        
              <h3>Add New School</h3>
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
          <label class="form-label">School Name:</label>
          <input type="text" 
                 placeholder="Enter School Name"
                 name="school_name">
        </div>
        
        <div class="form-group">
          <label class="form-label"> School Address:</label>
          <input type="text"
                 placeholder="Enter School Address Name"
                 name="school_address">
        </div>
 
            <div class="form-group">
                <label class="form-label">School Type:</label>
                <select class="form-label" name="school_type" >
                    <option value="Govt">Govt</option>
                    <option value="Private">Private</option>
                    <option value="Other">Other</option>
                </select>
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
