<?php
// delete_book.php (Delete Handler)
require_once 'db_config.php';
require_login(); 

$book_id = isset($_POST['book_id']) ? (int)$_POST['book_id'] : (isset($_GET['id']) ? (int)$_GET['id'] : null);
$message = '';

if ($book_id) {
    // Use Prepared Statement for secure deletion
    $sql = "DELETE FROM books WHERE book_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $book_id);
        if ($stmt->execute()) {
            $message = "Book ID $book_id deleted successfully!";
        } else {
            $message = "Error deleting book: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Error preparing statement: " . $conn->error;
    }
} else {
    $message = "No Book ID specified for deletion.";
}

// Show a simple confirmation page and redirect
echo "
    <!DOCTYPE html>
    <html>
    <head><link rel='stylesheet' href='styles.css'><title>Deletion Status</title></head>
    <body>
        <div class='container'>
            <h2>Deletion Status</h2>
            <p class='".(strpos($message, 'Error') !== false ? 'error' : 'success')."'>$message</p>
            <p>Redirecting to dashboard...</p>
            <a href='dashboard.php' class='btn'>Go to Dashboard Now</a>
            <script>setTimeout(function(){ window.location.href='dashboard.php'; }, 3000);</script>
        </div>
    </body>
    </html>
";
$conn->close();
?>
