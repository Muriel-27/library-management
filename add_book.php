<?php  
// add_book.php 
require_once 'db_config.php';
require_login(); 
$message = '';
if (isset($_POST['add'])) {  
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    // Cast quantity to integer for safety
    $quantity = (int)$_POST['quantity']; 
  
    $sql = "INSERT INTO books (title, author, quantity) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssi", $title, $author, $quantity);
        if ($stmt->execute()) {  
            $message = '<p class="success">Book added successfully!</p>'; 
            // Clear post data to prevent re-submission on refresh
            $_POST = array(); 
        } else {  
            $message = '<p class="error">Error: ' . $stmt->error . '</p>';
        }
        $stmt->close();
    } else {
         $message = '<p class="error">Error preparing statement: ' . $conn->error . '</p>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
    <title>Add Book</title>
</head>
<body>S
    <div class="container">
        <h2>Add a New Book</h2>
        <?php echo $message; ?>
        <form method="POST">
            <label>Book Title:</label>
            <input type="text" name="title" required><br>
            
            <label>Author Name:</label>
            <input type="text" name="author" required><br>
            
            <label>Quantity:</label>
            <input type="number" name="quantity" required min="0"><br>
            
            <button type="submit" name="add">Add Book</button>
            <a href="dashboard.php" class="btn">Go to Dashboard</a>
        </form>
    </div>
</body>
</html>
<?php $conn->close(); ?>S