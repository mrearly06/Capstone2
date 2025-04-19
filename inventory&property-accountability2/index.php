<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Accountability and Inventory Management System</title>

    <!-- Custom Style -->
    <link rel="stylesheet" type="text/css" href="assets/css/index-style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Anton&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Macondo&family=Mochiy+Pop+P+One&family=Shanti&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS for grid layout -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    
    <style>
        /* Main content with gradient background */
        .main-content {
            background: linear-gradient(to right, rgb(220,220,220,0.2) 51%, #fff 47%);
            margin-left: 250px;
            transition: margin-left 0.3s ease;
            height: 100vh;
            overflow-x: hidden;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Welcome section styling */
        .welcome-section {
            color: rgb(16, 16, 16);
            padding: 40px;
            text-align: center;
            border-radius: 10px;
        }

        .welcome-section h1 {
            font-size: 3rem;
            font-weight: bold;
            font-family: "Mochiy Pop P One", sans-serif;
  font-weight: 400;
  font-style: normal;
        }

        .welcome-section p {
            font-size: 1.5rem;
            font-family: "Shanti", sans-serif;
            font-weight: 400;
            font-style: normal;
        }
        .supp-text{
            font-family: "Lato", sans-serif;
            font-weight: 400;
            font-style: normal;
            letter-spacing:1px;
        }

        /* Slider container */
        .slider {
            position: relative;
            width: 100%;
            max-width: 600px; /* Control max width if needed */
            overflow: hidden;
            border-radius: 10px;
            perspective: 1000px;
        }

        /* Slides wrapper */
        .slides {
            display: flex;
            transition: transform 0.6s ease;
            transform-style: preserve-3d;
            width: 100%; /* Set width to 100% to fit slider container */
        }

        /* Ensure each slide takes full width */
        .slides img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
            backface-visibility: hidden;
        }

        /* Flip effect */
        .slides.flip {
            transform: rotateY(180deg);
        }

        /* Navigation button styles */
        .slider-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.1);
            color: white;
            border: none;
            font-size: 2rem;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 50%;
        }

        .prev {
            left: 10px;
        }

        .next {
            right: 10px;
        }
    </style>
</head>
<body>
    <?php require "backend/session-sidebar.php"; ?>
    <?php require "header.php"; ?>
    
    <div class="main-content">
        <div class="container image-content-row">
            <div class="row align-items-center">
                <div class="col-md-6 d-flex justify-content-center left-side">
                    <div class="card ms-5 bg-transparent border border-0" style="width: 100%;">
                        <div class="card-body bg-transparent">
                            <div class="image-container slider">
                                <div class="slides">
                                    <img src="image/bg-content.png" class="img-fluid" alt="Slide 1">
                                    <img src="image/bg-content2.png" class="img-fluid" alt="Slide 2">
                                    <img src="image/bg-content3.png" class="img-fluid" alt="Slide 3">
                                </div>
                                <!-- Navigation controls -->
                                <button class="slider-btn prev" onclick="prevSlide()">&#10094;</button>
                                <button class="slider-btn next" onclick="nextSlide()">&#10095;</button>
                            </div>
                            <hr class="my-3">
                            <p id="slide-text" class="text-center supp-text" style="font-size: 1.2rem; color: #333;">
                                Streamlining your asset tracking and inventory processes for maximum efficiency.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 d-flex justify-content-center">
                    <div class="welcome-section">
                        <h1>Welcome!</h1>
                        <p>Property Accountability and Inventory Management System for Divine Word College of Legazpi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- Slider Script with Flip Effect and Auto-Sliding -->
    <script>
        let currentSlide = 0;
        let flipInterval;

        // Texts corresponding to each slide
        const slideTexts = [
            "Streamlining your asset tracking and inventory processes for maximum efficiency.",
            "Efficiently track, manage, and report your inventory with our comprehensive system.",
            "Ensure every asset is tracked, managed, and accounted for with precision."
        ];

        function showSlide(index) {
            const slides = document.querySelector('.slides');
            const totalSlides = slides.children.length;
            currentSlide = (index + totalSlides) % totalSlides;
            
            // Update the text based on the current slide index
            document.getElementById('slide-text').textContent = slideTexts[currentSlide];

            // Add flip class for effect
            slides.classList.add('flip');
            slides.style.transform = `translateX(-${currentSlide * 100}%)`;
            
            // Remove flip class after the animation duration
            setTimeout(() => {
                slides.classList.remove('flip');
            }, 600); // Match the CSS transition duration
        }

        function nextSlide() {
            showSlide(currentSlide + 1);
        }

        function prevSlide() {
            showSlide(currentSlide - 1);
        }

        function startAutoSlide() {
            flipInterval = setInterval(nextSlide, 6000); // Slide every 6 seconds
        }

        function stopAutoSlide() {
            clearInterval(flipInterval);
        }

        // Start auto-sliding on page load
        window.onload = startAutoSlide;
    </script>
</body>
</html>
