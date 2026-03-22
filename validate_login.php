<?php
// validate_login.php
require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.html");
    exit();
}

$username = trim($_POST['username']);
$password = $_POST['password']; 


$sql = "SELECT username FROM users WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ss", $username, $password); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        header("Location: index.html?error=invalid");
        exit();
    }

    $stmt->close();
} else {
    die("Error preparing statement: " . $conn->error);
}
$conn->close();
?>