<?php
include '../_dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming 'info' is the name attribute of your textarea in the form
   // $info = $_POST['info'];
    $info = $_POST['info'];
    $feed = $_POST['feed'];


    // Prepare the SQL statement
    $tfeed = "INSERT INTO t_learn (info,feed) VALUES (?,?)";
    $stmt = $conn->prepare($tfeed);

  

    // Bind parameters
    $stmt->bindParam(1, $info);


    // Execute the statement and check for errors
    if ($stmt->execute([$info,$feed])) {
        // Redirect the user back to the home page after successful submission
        header("Location: t_learning_materials.php");
        exit();
    } else {
        echo "Error adding post: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
