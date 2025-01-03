<?php
// Update account info accordingly
$dsn = "mysql:host=localhost;port=3306;dbname=online_market;charset=utf8mb4";  // Change dbname to your actual DB name
$user = "root";  // Set your DB username
$pass = "";  // Set your DB password

try {
    // Create a new PDO instance
    $db = new PDO($dsn, $user, $pass);

    // Set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $ex) {
    // If connection fails, show the error message and stop the script
    echo "<p>Connection Error: " . $ex->getMessage() . "</p>";
    exit;
}
?>