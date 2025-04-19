<style>
  .carousel-container {
    width: 100%;
    padding: 0;
    margin-left:251px;
    overflow: hidden; /* Ensure no overflow */
  }

  .carousel-item img {
    width: 100%;
    height:92vh;
  }

  .quick-links-card {
    background-color: #007bff; /* Optional: Change background color */
    color: white; /* Optional: Change text color */
    border: none; /* Remove border */
    right: 0;
    padding: 0;
    position: absolute;
    width:255px;
    height:92vh;
  }

  .card-header {
    background-color: #0056b3; /* Optional: Darker background for header */
  }

  .list-group-item a {
    color: black; /* Optional: Change link color */
    text-decoration: none;
    height:92vh;
  }

  
  .list-group-item a:hover {
    text-decoration: underline; /* Optional: Underline on hover */
  }
</style>
<div class="container-fluid">
  <div class="row no-gutters">
    <!-- Grid Column for the Carousel -->
    <div class="col-md-10 p-0">
      <div class="carousel-container">
        <!-- Carousel -->
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
          </div>
          <div class="carousel-inner">
            <div class="carousel-item active" style="background-color: rgba(179, 255, 217, 0.3) !important;">
            <img src="image/bg-content2.jpg" class="d-block w-100" alt="..." style="max-height:100vh;">
            </div>
           
        </div>
      </div>
    </div>

    <!-- Grid Column for Quick Links Card -->
 
  </div>
</div>
