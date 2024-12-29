<?php
include '../_dbconnect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming 'details' is the name attribute of your textarea in the form
    $details = $_POST['details'];
    $name = $_POST['name'];

    // Prepare the SQL statement
    $take = "INSERT INTO post (details,name) VALUES (?,?)";
    $stmt = $conn->prepare($take);

    // Bind parameters
    $stmt->bindParam(1, $details);

    // Execute the statement and check for errors
    if ($stmt->execute([$details,$name])) {
        // Redirect the user back to the home page after successful submission
        header("Location: teacher-home.php");
        exit();
    } else {
        echo "Error adding post: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
