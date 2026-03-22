<?php  
// delete_book_form.php
require_once 'db_config.php';
require_login();
?>
<!DOCTYPE html>  
<html>  
<head>  
<link rel="stylesheet" href="styles.css">  
    <title>Delete a Book</title>  
</head>  
<body>  
    <div class="container">
        <h2>Delete Book by ID</h2>  
        <form action="delete_book.php" method="POST">  
            <label>Enter Book ID:</label>  
            <input type="number" name="book_id" required>  
            <button type="submit" class="btn-delete">Delete</button>
            <a href="dashboard.php" class="btn">Go to Dashboard</a>
        </form>
    </div>
</body>  
</html>