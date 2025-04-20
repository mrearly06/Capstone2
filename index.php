
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
    background: url('image/homep-bg.jpg') no-repeat center center fixed;
    background-size: cover;
    margin-left: 250px;
    transition: margin-left 0.3s ease;
    height: 100vh;
    overflow-x: hidden;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    height:100vh;
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

        .slider {
    position: relative;
    width: 100%;
    max-width: 600px; /* Control max width if needed */
    overflow: hidden;
    border-radius: 10px;
    perspective: 1000px;
}

.slides {
    display: flex;
    transition: transform 0.6s ease;
    transform-style: preserve-3d;
    width: 100%; /* Set width to 100% to fit slider container */
    height: 400px; /* Set a fixed height for the slides */
    align-items: center; /* Center the slides vertically */
}

.slides img {
    width: 100%;
    height: 100%; /* Make the image fill the slide */
    object-fit: cover;
    border-radius: 10px;
    backface-visibility: hidden;
}

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
    z-index: 1; /* Ensure buttons are on top of the slides */
}

.prev {
    left: 10px;
}

.next {
    right: 10px;
}

.slide-text-container {
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(255, 255, 255, 0.8);
    padding: 10px 20px;
    border-radius: 10px 0 0 10px;
    max-width: 300px;
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

<!-- Main Content Section with Gradient Background -->
<div class="main-content" style="
    background: linear-gradient(to bottom, #ffffff, rgb(220,220,220));
    backdrop-filter: blur(12px) saturate(120%);
    -webkit-backdrop-filter: blur(12px) saturate(120%);
    padding: 3rem 0;
">
    <div class="container px-4 text-center">

        <!-- Title Section Without Card -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10">
                <div class="card-body" style="
                    margin-top:60px;
                    background: transparent;
                ">
                    <h1 class="fw-bold mb-3" style="font-size: 2.2rem; font-family: 'Mochiy Pop P One', sans-serif; color: #333;">
                        Inventory Management and Property Accountability
                    </h1>
                    <p class="lead" style="font-size: 1.1rem; color: #555;">
                        for Divine Word College of Legazpi
                    </p>
                    <p style="color: #666;">
                        Your all-in-one Property Accountability and Inventory Management System.<br>
                        Track, manage, and report with accuracy and ease.
                    </p>
                </div>
            </div>
        </div>

        <!-- 3D Feature Cards -->
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="card h-100" style="
                    border: none;
                    border-radius: 20px;
                    background: #ffffff;
                    padding: 20px;
                    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                " onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 35px rgba(0,0,0,0.2)'" onmouseout="this.style.transform=''; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.15)'">
                    <div class="card-body">
                        <img src="image/Spreadsheets-amico.png" alt="Inventory Overview" class="img-fluid mb-3" style="max-height: 120px;">
                        <h5 class="card-title fw-bold mb-2">Inventory Overview</h5>
                        <p class="card-text">View all assets, quantities, and categories in one place.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100" style="
                    border: none;
                    border-radius: 20px;
                    background: #ffffff;
                    padding: 20px;
                    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                " onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 35px rgba(0,0,0,0.2)'" onmouseout="this.style.transform=''; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.15)'">
                    <div class="card-body">
                        <img src="image/Spreadsheets-bro.png" alt="Smart Reports" class="img-fluid mb-3" style="max-height: 120px;">
                        <h5 class="card-title fw-bold mb-2">Smart Reports</h5>
                        <p class="card-text">Auto-generate reports for audits, requests, and tracking.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100" style="
                    border: none;
                    border-radius: 20px;
                    background: #ffffff;
                    padding: 20px;
                    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                " onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 35px rgba(0,0,0,0.2)'" onmouseout="this.style.transform=''; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.15)'">
                    <div class="card-body">
                        <img src="image/Search engines-amico.png" alt="User-Friendly Interface" class="img-fluid mb-3" style="max-height: 120px;">
                        <h5 class="card-title fw-bold mb-2">User-Friendly Interface</h5>
                        <p class="card-text">Designed for a seamless experience at all user levels.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>






  
    <!-- Bootstrap JS and Popper -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

  
</body>
</html>
