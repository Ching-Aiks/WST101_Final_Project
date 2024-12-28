<?php
session_start();

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
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
    if ($conn->query($sql) === TRUE) {
        // Fetch the ID of the newly created user
        $user_id = $conn->insert_id;

        // Store user details in session
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;

        // Redirect to index.php
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

