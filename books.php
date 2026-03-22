<?php
// books.php (Read/View)
require_once 'db_config.php';
require_login(); 

$result = $conn->query("SELECT book_id, title, author, quantity FROM books ORDER BY book_id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Available Books</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Available Book Inventory</h2>
        
        <div class="actions">
            <a href="dashboard.php" class="btn">🏠 Go to Dashboard</a>
            <a href="add_book.php" class="btn btn-add">➕ Add Book</a>
        </div>
        <hr>

        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
            <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= htmlspecialchars($row['book_id']) ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['author']) ?></td>
                <td><?= htmlspecialchars($row['quantity']) ?></td>
                <td>
                    <a href="update_book.php?id=<?= $row['book_id'] ?>">Edit</a> | 
                    <a href="delete_book.php?id=<?= $row['book_id'] ?>">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
<?php $conn->close(); ?>