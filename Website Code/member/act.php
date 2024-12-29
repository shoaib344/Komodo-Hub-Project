<?php
include '../_dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming 'info' is the name attribute of your textarea in the form
   // $info = $_POST['info'];
    $name = $_POST['name'];
    $details = $_POST['details'];
    $contact = $_POST['contact'];
    $time = $_POST['time'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    $reward = $_POST['reward'];
    


    // Prepare the SQL statement
    $cact = "INSERT INTO event (name,details,contact,time,date,location,reward) VALUES (?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($cact);

  

    // Bind parameters
    $stmt->bindParam(1, $name);


    // Execute the statement and check for errors
    if ($stmt->execute([$name,$details,$contact,$time,$date,$location,$reward])) {
        // Redirect the user back to the home page after successful submission
        header("Location: c_activities.php");
        exit();
    } else {
        echo "Error adding post: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
