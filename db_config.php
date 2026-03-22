  <?php
   // db_config.php
 
   // Start a session for user management
   session_start();
 
   $servername = "localhost";
   $username = "root";
   $password = "";
 $dbname = "library_db";

 // Create connection
 $conn = new mysqli($servername, $username, $password, $dbname);

 // Check connection
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }

 // Function to enforce login protection on pages
 function require_login() {
     if (!isset($_SESSION['username'])) {
         header("Location: index.html");
         exit();
}
}
