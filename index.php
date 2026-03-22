<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Library Login</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <div class="container">
        <header>
            <h2>Library Management System</h2>
            <h1>User Login</h1>
        </header>

        <form action="validate_login.php" method="POST">
            <?php
            // A quick way to display a message after redirection
            if (isset($_GET['error']) && $_GET['error'] == 'invalid') {
                echo '<p class="error">Invalid Username or Password!</p>';
            }
            ?>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">LOG IN</button>
        </form>
    </div>
</body>
</html>