<?php
session_start(); // Start the session to access session variables

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pet_aoption_sys"; // Corrected database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch pets and their owners
$sql = "SELECT pets.*, users.username FROM pets JOIN users ON pets.owner_id = users.id";
$result = $conn->query($sql);

$pets = [];
if ($result) { // Check if the query was successful
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pets[] = $row;
        }
    }
} else {
    echo "Error fetching pets: " . $conn->error; // Error handling for the query
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Adoption</title>
    <link rel="stylesheet" href="index.css">
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
            <?php if (isset($_SESSION['user_id'])): ?>
                <span>User: <?= htmlspecialchars($_SESSION['username']) ?></span>
                <a href="home.php">Home</a>
                <a href="index.php">View Pets</a>
                <a href="dashboard.php">My Dashboard</a>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="auth_redirect.php">View Pets</a>
                <a href="register.html">Register</a>
                <a href="login.html">Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main>
    <h2>Available Pets for Adoption</h2>
    
    <div class="gallery">
        <?php if (count($pets) > 0): ?>
            <?php foreach ($pets as $pet): ?>
                <div class="pet-card">
                    <img src="<?= htmlspecialchars($pet['image']) ?>" alt="<?= htmlspecialchars($pet['name']) ?>">
                    <h3><?= htmlspecialchars($pet['name']) ?></h3>
                    <div id="con">
                        <p>
                            <strong id="age">Age:</strong> <?= htmlspecialchars($pet['age']) ?>
                            <strong id="breed">Breed:</strong> <?= htmlspecialchars($pet['breed']) ?>
                        </p>
                        <p><strong>About Me:</strong> <?= htmlspecialchars($pet['description']) ?></p>
                        <p><strong>Posted by:</strong> <?= htmlspecialchars($pet['username']) ?></p>
                    </div>  
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="nv">No pets available for adoption at the moment.</p>
        <?php endif; ?>
    </div>
</main>
</body>
</html>