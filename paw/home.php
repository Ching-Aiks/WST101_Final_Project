<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Pet Adoption System</title>
    <link rel="stylesheet" href="home.css">
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
    <h2 id="about">About Us</h2>
    <div class="about-container">
        <p>Welcome to the Pet Adoption System. Here, you can adopt or post pets for adoption. Join our community to give pets a new home! At the Pet Adoption System, our mission is to create a better world for animals by connecting them with loving families. Every pet deserves a second chance at life, and we are here to make that possible. Our platform provides a simple and effective way for individuals to find their perfect furry companion or to rehome pets in need. We believe that adopting a pet is more than just finding a new home—it’s about building lifelong bonds, spreading compassion, and promoting responsible pet ownership. Through this platform, we aim to bring together people and animals to create stories of love, care, and companionship. Together, we can make a difference and give every pet the happy life they deserve.</p>
    </div>

    <div class="purpose-aim-container">
        <div class="purpose">
            <h2>PURPOSE</h2>
            <div class="purpose-list">
                <div class="purpose-item">
                    <img src="pics/paw-heart (1).png" class="icon" alt="Connect loving families">
                    <span>Connect loving families with pets that need new homes.</span>
                </div>
                <div class="purpose-item">
                    <img src="pics/paw.png" class="icon" alt="Provide a safe environment">
                    <span>Provide a safe and nurturing environment for all animals.</span>
                </div>
                <div class="purpose-item">
                    <img src="pics/books.png" class="icon" alt="Promote responsible pet ownership">
                    <span>Promote responsible pet ownership and raise awareness about proper care.</span>
                </div>
                <div class="purpose-item">
                    <img src="pics/lawyer-man.png" class="icon" alt="Inspire compassion">
                    <span>Inspire compassion through education and advocacy.</span>
                </div>
            </div>
        </div>

        <div class="aim">
            <h2>GOAL</h2>
            <div class="goal-list">
                <div class="goal-item">
                    <img src="pics/heart-circle-user.png" class="icon" alt="Foster lifelong bonds">
                    <span>Foster lifelong bonds between pets and their new families.</span>
                </div>
                <div class="goal-item">
                    <img src="pics/dog-leashed.png" class="icon" alt="Highlight benefits of adopting">
                    <span>Highlight the benefits of adopting over purchasing pets.</span>
                </div>
                <div class="goal-item">
                    <img src="pics/doctor.png" class="icon" alt="Encourage responsible ownership">
                    <span>Encourage responsible ownership practices like spaying, neutering, and regular veterinary care.</span>
                </div>
                <div class="goal-item">
                    <img src="pics/population-globe.png" class="icon" alt="Create a compassionate community">
                    <span>Create a compassionate community that supports every pet in finding a loving home.</span>
                </div>
            </div>
        </div>
    </div>

    
    <div class="contact-container">
        <h2 id="contact">Contact Us</h2>
        <p>If you have any questions or need assistance, feel free to reach out to us:</p>
        <img src="pics/main1.jpg" class="blue" alt="dog in blue">
        <ul>
            <li><strong>Email:</strong> <a href="mailto:info@pawadoption.com">info@pawadoption.com</a></li>
            <li><strong>Phone:</strong> <a href="tel:+1234567890">+1 (234) 567-890</a></li>
            <li><strong>Follow us on social media:</strong></li>
            <li>
                <a href="https://www.facebook.com/pawadoption" target="_blank">Facebook</a> |
                <a href="https://www.twitter.com/pawadoption" target="_blank">Twitter</a> |
                <a href="https://www.instagram.com/pawadoption" target="_blank">Instagram</a>
            </li>
        </ul>
    </div>

    <div id="mem">
        <h3>Submitted by Group A.D.D.A:</h3>
        <div class="members-container">
            <div class="member">
                <img src="pics/din.png" class="av1" alt="Ching, Aikim">
                <a>Ching, Aikim</a>
            </div>
            <div class="member">
                <img src="pics/dan.png" class="av2" alt="Balena, Danica Lyles">
                <a>Balena, Danica Lyles</a>
            </div>
            <div class="member">
                <img src="pics/arc.png" class="av3" alt="Gracioso, Angel Robert">
                <a>Gracioso, Angel Robert</a>
            </div>
            <div class="member">
                <img src="pics/aiks.png" class="av4" alt="Recare, Dionisio">
                <a>Recare, Dionisio</a>
            </div>
        </div>
        <a>BSIT 3C</a>
    </div>

    <div class="foot">
        <div class="footer-content">
            <h3>Final Project in:</h3>
            <p>Web Systems and Technologies 1</p>
        </div>
    </div>
</main>
</body>
</html>