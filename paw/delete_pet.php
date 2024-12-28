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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $pet_id = $_POST['pet_id'];
    $user_id = $_SESSION['user_id'];

    // Check if the pet belongs to the logged-in user
    $sql = "SELECT * FROM pets WHERE id = $pet_id AND owner_id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Delete the pet
        $sql = "DELETE FROM pets WHERE id = $pet_id";
        if ($conn->query($sql) === TRUE) {
            echo "Pet deleted successfully.";
        } else {
            echo "Error deleting pet: " . $conn->error;
        }
    } else {
        echo "You are not authorized to delete this pet.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();

// Redirect back to the dashboard
header("Location: dashboard.php");
exit();
?>

