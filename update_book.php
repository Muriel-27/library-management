<?php  
// update_book.php (Update)
require_once 'db_config.php';
require_login(); 

$data = null;
$message = '';
$book_id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['book_id']) ? (int)$_POST['book_id'] : null);

//  Handle Update Submission
if (isset($_POST['update']) && $book_id) {  
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $quantity = (int)$_POST['quantity'];
  
    $sql = "UPDATE books SET title=?, author=?, quantity=? WHERE book_id=?";  
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssii", $title, $author, $quantity, $book_id);
        if ($stmt->execute()) {  
            $message = '<p class="success">Book updated successfully!</p>';
        } else {  
            $message = '<p class="error">Update failed: ' . $stmt->error . '</p>';
        }
        $stmt->close();
    }
}

// Fetch/Refetch Book Details
if ($book_id) {
    $sql = "SELECT book_id, title, author, quantity FROM books WHERE book_id=?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $book_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Book</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Update Book</h2>
        <?php echo $message; ?>
        
        <form method="GET" action="update_book.php">
            <label>Select a Book:</label>
            <select name="id" onchange="this.form.submit()" required>
                <option value="">--Choose--</option>
                <?php  
                $books = $conn->query("SELECT book_id, title FROM books ORDER BY title ASC");  
                while ($row = $books->fetch_assoc()) {  
                    $selected = ($book_id == $row['book_id']) ? "selected" : "";  
                    echo "<option value='".$row['book_id']."' $selected>".htmlspecialchars($row['title'])."</option>";  
                }
                ?>
            </select>
        </form>
        
        <?php if ($data) { ?>
        <hr>
        <form method="POST">
            <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($data['book_id']); ?>">
            
            <label>Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($data['title']); ?>" required><br>
            
            <label>Author:</label>
            <input type="text" name="author" value="<?php echo htmlspecialchars($data['author']); ?>" required><br>
            
            <label>Quantity:</label>
            <input type="number" name="quantity" value="<?php echo htmlspecialchars($data['quantity']); ?>" required min="0"><br>
            
            <button type="submit" name="update" class="btn-update">Update Book</button>
            <a href="dashboard.php" class="btn">Go to Dashboard</a>
        </form>
        <?php } ?>
    </div>
</body>
</html>
<?php $conn->close(); ?>