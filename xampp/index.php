
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TripMate | Explore Your World</title>

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <!-- Navigation Bar -->
    <header class="navbar">
        <a href="index.php" class="logo">Trip<span>Mate.</span></a>

        <nav class="nav-links">
            <a href="#home">Home</a>
            <a href="#destinations">Destinations</a>
            <a href="#about">About</a>
        </nav>

        <a href="#planner" class="nav-button">Plan Your Trip ↗</a>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">

        <div class="hero-content">
            <p class="tagline">✦ YOUR JOURNEY, YOUR STORY</p>

            <h1>Discover the world.<br>
                <span>One trip at a time.</span>
            </h1>

            <p class="hero-description">
                Find beautiful destinations, plan unforgettable
                journeys and create memories that last forever.
            </p>

            <a href="#destinations" class="primary-button">
                Explore Destinations →
            </a>
        </div>

        <div class="hero-note">
            <span>✈</span>
            <p>Travel beyond<br>the ordinary.</p>
        </div>

    </section>

    <!-- Destinations Section -->
    <section class="destinations" id="destinations">

        <div class="section-heading">
            <div>
                <p class="tagline">✦ FIND YOUR NEXT ADVENTURE</p>
                <h2>Popular Destinations</h2>
            </div>
            <p>Places worth exploring.</p>
        </div>

        <div class="destination-grid">

            <div class="destination-card">
                <img src="https://images.unsplash.com/photo-1519501025264-65ba15a82390?w=700"
                     alt="New York city">
                <div class="card-info">
                    <h3>New York</h3>
                    <p>USA · City Escape</p>
                </div>
            </div>

            <div class="destination-card">
                <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?w=700"
                     alt="Beautiful mountain landscape">
                <div class="card-info">
                    <h3>Swiss Alps</h3>
                    <p>Switzerland · Nature</p>
                </div>
            </div>

            <div class="destination-card">
                <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=700"
                     alt="Bali tropical destination">
                <div class="card-info">
                    <h3>Bali</h3>
                    <p>Indonesia · Tropical</p>
                </div>
            </div>

        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <p class="tagline">✦ TRAVEL MADE SIMPLE</p>
        <h2>Your next adventure starts here.</h2>
        <p>
            TripMate helps you discover destinations,
            organize itineraries and plan your travel budget
            all in one place.
        </p>
    </section>

    <!-- Trip Planner Section -->
    <section class="planner" id="planner">
        <p class="tagline">✦ LET'S GET STARTED</p>
        <h2>Ready to plan your next trip?</h2>
        <p>Your dream destination is just a plan away.</p>
        <a href="pages/planner.php" class="primary-button">
            Start Planning →
        </a>
    </section>

    <!-- Footer -->
    <footer>
        <h2>TripMate.</h2>
        <p>Made for explorers, dreamers and travellers.</p>
        <p>© 2026 TripMate. All rights reserved.</p>
    </footer>

    <script src="assets/js/script.js"></script>

</body>
</html>
