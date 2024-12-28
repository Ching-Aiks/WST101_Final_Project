<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to submit a pet.";
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pet_aoption_sys";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Insert pet details into the database
            $stmt = $conn->prepare("INSERT INTO pets (owner_id, name, age, breed, description, image) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssss", $user_id, $name, $age, $breed, $description, $target_file);
            if ($stmt->execute()) {
                // Redirect to dashboard after successful submission
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Fetch the user's name from the database using the user_id stored in the session
$user_id = $_SESSION['user_id'];
$sql = "SELECT username FROM users WHERE id = '$user_id'"; // Assuming you have a 'users' table
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['username']; // Get the username
} else {
    $username = "Guest"; // Default if no user found
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit a Pet</title>
    <link rel="stylesheet" href="submit.css">
</head>
<body>
<header>
    <div class="header-content">
        <div class="logo-container">
            <img src="pics/logo.jpg" class="logo" alt="Connect loving families">
            <div class="text-container">
                <h1>P.A.W</h1>
                <p>Pet Adoption Website</p>
            </div>
        </div>
        <nav>
            <span>User: <?= htmlspecialchars($username) ?></span>
            <a href="home.php">Home</a>
            <a href="index.php">View Pets</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="submit_pet.php">Submit Pet</a>
            <a href="logout.php">Logout</a>
        </nav>
    </div>
</header>
<main>
    <h2>Submit a Pet for Adoption!</h2>
    <form action="submit_pet.php" method="POST" enctype="multipart/form-data">
        <div style="display: flex; align-items: center; gap: 10px;">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        
            <label for="age">Age:</label>
            <input type="text" id="age" name="age" required>
        
            <label for="breed">Breed:</label>
            <input type="text" id="breed" name="breed" required>
        </div>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="image">Pet Image:</label>
        <input type="file" id="image" name="image" required>

        <button type="submit">Submit</button>
    </form>
</main>
</body>
</html>