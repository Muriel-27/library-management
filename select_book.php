<?php
// select_book.php
require_once 'db_config.php';
require_login(); // Ensure the user is logged in

$book_details = null;
$message = '';
$selected_book_id = isset($_POST['book_id']) ? (int)$_POST['book_id'] : null;

// When user selects a book from the form
if ($selected_book_id) {
    // Use Prepared Statement for secure selection
    $sql = "SELECT book_id, title, author, quantity FROM books WHERE book_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $selected_book_id); // 'i' for integer
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $book_details = $result->fetch_assoc();
        } else {
            $message = '<p class="error">Book not found.</p>';
        }
        $stmt->close();
    } else {
        $message = '<p class="error">Database error preparing statement.</p>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Select a Book</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>🔍 Select a Book From Library</h2>
        <?php echo $message; ?>

        <form method="POST">
            <label>Select Book:</label>
            <select name="book_id" required>
                <option value="">-- Choose a book --</option>
                <?php
                // Load book list into dropdown 
                // Note: This query is static and doesn't need input, so no prepared statement is required here.
                $sql = "SELECT book_id, title FROM books ORDER BY title ASC";
                $result = $conn->query($sql);

                while($row = $result->fetch_assoc()) {
                    $selected = ($selected_book_id == $row['book_id']) ? "selected" : "";
                    echo "<option value='".$row['book_id']."' $selected>" . htmlspecialchars($row['title']) . "</option>";
                }
                ?>
            </select>

            <button type="submit">View Book Details</button>
            <a href="dashboard.php" class="btn">Go to Dashboard</a>
        </form>

        <hr>

        <?php 
        // Display details if a book was successfully fetched
        if ($book_details) { 
        ?>
            <h3>Book Details</h3>
            <p><strong>Book ID:</strong> <?php echo htmlspecialchars($book_details['book_id']); ?></p>
            <p><strong>Title:</strong> <?php echo htmlspecialchars($book_details['title']); ?></p>
            <p><strong>Author:</strong> <?php echo htmlspecialchars($book_details['author']); ?></p>
            <p><strong>Quantity:</strong> <?php echo htmlspecialchars($book_details['quantity']); ?></p>
        <?php 
        } 
        ?>
    </div>
</body>
</html>
<?php $conn->close(); ?>