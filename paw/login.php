<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pet_aoption_sys";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Store user details in session
            $_SESSION['user_id'] = $row['id']; // Ensure this is set
            $_SESSION['username'] = $row['username'];

            // Redirect to index.php
            header("Location: index.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that username.";
    }
}

$conn->close();
