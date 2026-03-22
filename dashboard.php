<?php
// dashboard.php
require_once 'db_config.php';
require_login(); 

$username = htmlspecialchars($_SESSION['username']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Library Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-card">
        <h2> Library Management System</h2>
        <p>Welcome, *<?php echo $username; ?>*! Select an option:</p>

        <div class="action-grid">
            <a href="add_book.php" class="btn btn-add">➕ Add Book</a>
            <a href="books.php" class="btn btn-view">📖 View Books</a>
            <a href="update_book.php" class="btn btn-update">✏ Update Book</a>
            <a href="delete_book_form.php" class="btn btn-delete">🗑 Delete Book</a>
            <a href="select_book.php" class="btn btn-view">🔍 Search/Select</a>
            
        </div>
    </div>
</body>
</html>
<?php $conn->close()?>