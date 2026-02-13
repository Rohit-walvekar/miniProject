<?php
session_start();



$username = $_SESSION['username'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Notes Provider App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="miniProject.css" />
</head>
<body>
<header>
  <nav class="nav-bar">
    <div class="logo"><a href="#home">Noted</a></div>

    <ul>
        <li><a href="#home" class="active">Home</a></li>
        <li><a href="#language">Languages</a></li>
        <li><a href="#about">About Us</a></li>

        <?php if ($username): ?>
    
        <div class="dropdown" id="profileDropdown">
            <button type="button" class="profile-btn" aria-haspopup="true" aria-expanded="false" aria-controls="profileMenu">
            <span class="btn-left">
                <i class="fa-solid fa-user" aria-hidden="true"></i>
                <span class="btn-label">Profile</span>
            </span>
            </button>
                <ul class="profile-menu" id="profileMenu" role="menu" aria-labelledby="profileDropdown">
                    <li role="menuitem"><a href="profile.php">My Profile</a></li>
                    <li role="menuitem">
                <button class="logout-btn" type="button" onclick="window.location.href='logout.php'">Logout</button>
                </li>
            </ul>
        </div>


        <?php else: ?>
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>

        <li><a href="feedback.php">FeedBack</a></li>
    </ul>

  </nav>
</header>


    <main>
        <section id="home">
            <div class="main-sec">
                <div class="languages">
                    <h1 class="lan-h1">Programming Notes Hub</h1>
                    <p class="subtitle">Master <span class="lan-span"> C and C++</span> comprehensive notes...!</p>
                </div>
            </div>

            <div class="founder-images">
                <figure>
                    <img src="images/Dennis_Ritchie_2011.jpg" alt="Dennis Ritchie, Founder of C">
                    <figcaption>Dennis Ritchie (C)</figcaption>
                </figure>
                <figure>
                    <img src="images/Bjarne2018.jpg" alt="Bjarne Stroustrup, Founder of C++">
                    <figcaption>Bjarne Stroustrup (C++)</figcaption>
                </figure>
            </div>

        </section>

        <section id="language">
        <div class="language-sec">
            <h1>Languages</h1>
            <div class="lan-container">
                <div class="c-lan">
                    <div class="c-name">C Language</div>
                    <p>C is a general-purpose, procedural, imperative computer programming language developed in 1972 by Dennis M. Ritchie at Bell Labs for use with the Unix operating system. It is known for its efficiency, flexibility, and ability to interact closely with hardware, making it suitable for system-level programming.</p>
                    <a href="c.html" target="_blank">Explore C</a>
                </div>
                <div class="cpp-lan">
                    <div class="cpp-name">C++ Language</div>
                    <p>C++ is a multi-paradigm, general-purpose programming language developed by Bjarne Stroustrup at Bell Labs in the early 1980s. It was designed as an extension of the C programming language, aiming to add OOP capabilities and other features while retaining C's efficiency and low-level memory manipulation abilities.</p>
                    <a href="cpp.html" target="_blank">Explore C++</a>
                </div>
            </div>
        </div>
        </section>

        <section id="about">
            <h1>About Us</h1>
            <div class="about-content">
                <p>Welcome to **Noted**, your dedicated hub for mastering programming fundamentals. We believe that clear, concise, and accessible notes are the foundation of successful coding. Our mission is to provide high-quality educational resources for popular languages like C and C++, helping students and developers build a strong, reliable knowledge base.</p>
                <p>The **Noted** team is committed to continuously expanding our library, ensuring our notes are always up-to-date and easy to understand. Start your journey with us and turn complex concepts into manageable knowledge!</p>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-brand">
                <h2>Noted</h2>
                <p>Your path to programming mastery.</p>
            </div>
            <div class="footer-links">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#language">Languages</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="feedback.php" target="_blank">Give Feedback</a></li>
                </ul>
            </div>
            <div class="footer-contact">
                <h3>Connect</h3>
                <p>Email: support@notedapp.com</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            &copy; 2025 Noted. All Rights Reserved.
        </div>
    </footer>

    <script>
    document.addEventListener("DOMContentLoaded", () => {

    const profileBtn = document.querySelector(".profile-btn");
    const menu = document.querySelector(".profile-menu");

    profileBtn.addEventListener("click", (event) => {
        event.stopPropagation(); 
        menu.classList.toggle("show");
    });

    document.addEventListener("click", (event) => {
        if (!menu.contains(event.target) && !profileBtn.contains(event.target)) {
            menu.classList.remove("show");
        }
    });

});
</script>

</body>
</html>