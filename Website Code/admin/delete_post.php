<?php
include '../_dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    // Assuming 'id' is the name attribute of your hidden input field
    $postId = $_POST['id'];

    // Prepare the SQL statement
    $deleteQuery = "DELETE FROM post WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);

    // Bind parameters
    $stmt->bindParam(1, $postId);

    // Execute the statement and check for errors
    if ($stmt->execute()) {
        // Redirect the user back to the home page after successful deletion
        header("Location: admin-home.php");
        exit();
    } else {
        echo "Error deleting post: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
