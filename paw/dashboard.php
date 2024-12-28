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

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM pets WHERE owner_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$pets = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pets[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="dash.css">
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
    <h2>Your Posted Pets</h2>
    <div class="gallery">
        <?php if (count($pets) > 0): ?>
            <?php foreach ($pets as $pet): ?>
                <div class="pet-card">
                    <img src="<?= htmlspecialchars($pet['image']) ?>" alt="<?= htmlspecialchars($pet['name']) ?>">
                    <h3><?= htmlspecialchars($pet['name']) ?></h3>
                    <p><strong>Age:</strong> <?= htmlspecialchars($pet['age']) ?></p>
                    <p><strong>Breed:</strong> <?= htmlspecialchars($pet['breed']) ?></p>
                    <p><strong>Description:</strong> <?= htmlspecialchars($pet['description']) ?></p>
                    <form action="delete_pet.php" method="POST">
                        <input type="hidden" name="pet_id" value="<?= $pet['id'] ?>">
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this pet?');">Delete</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="note">You haven't posted any pets yet.</p>
        <?php endif; ?>
    </div>
</main>
</body>
</html>