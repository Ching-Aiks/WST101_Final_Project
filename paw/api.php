<?php
header("Content-Type: application/json");
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pet_aoption_sys";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Handle GET request
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT pets.*, users.username FROM pets JOIN users ON pets.owner_id = users.id";
    $result = $conn->query($sql);

    $pets = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pets[] = $row;
        }
        echo json_encode($pets);
    } else {
        echo json_encode(["message" => "No pets found."]);
    }
}

// Handle POST request for submitting a new pet
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["error" => "You must be logged in to submit a pet."]);
        exit();
    }

    // Get the pet details from the request
    $name = $_POST['name'];
    $age = $_POST['age'];
    $breed = $_POST['breed'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];

    // Handle file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        echo json_encode(["error" => "File is not an image."]);
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo json_encode(["error" => "Sorry, your file is too large."]);
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo json_encode(["error" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed."]);
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo json_encode(["error" => "Sorry, your file was not uploaded."]);
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Insert pet details into the database
            $stmt = $conn->prepare("INSERT INTO pets (owner_id, name, age, breed, description, image) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssss", $user_id, $name, $age, $breed, $description, $target_file);
            if ($stmt->execute()) {
                echo json_encode(["message" => "Pet submitted successfully."]);
            } else {
                echo json_encode(["error" => "Error: " . $stmt->error]);
            }
        } else {
            echo json_encode(["error" => "Sorry, there was an error uploading your file."]);
        }
    }
}

$conn->close();
?>