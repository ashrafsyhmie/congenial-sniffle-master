<?php
// Include your database connection
require_once './db conn.php'; // Assuming this contains your MySQL connection setup

// Check if the 'id' parameter exists in the URL
if (isset($_GET['id'])) {
    $articleId = $_GET['id'];

    // Sanitize the ID to prevent SQL injection
    $articleId = intval($articleId);

    // Create the delete query
    $deleteQuery = "DELETE FROM article WHERE id = $articleId";

    // Execute the query using the mysqli connection
    if (mysqli_query($conn, $deleteQuery)) {
        // If successful, redirect to the articles list page
    location: header('Location: manage_article.php');
        exit;
    } else {
        // Handle errors if the query fails
        echo "Error deleting the article: " . mysqli_error($conn);
    }
} else {
    // Handle case where 'id' is not provided
    echo "Invalid article ID.";
}

// Close the database connection
mysqli_close($conn);
?>
