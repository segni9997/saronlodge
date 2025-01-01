<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hotel Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Hotel Management</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#services">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#about-us">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#booking">Book Now</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="login.php" blank >Login</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <header class="hero bg-primary text-white text-center py-5">
    <div class="container">
      <h1 class="display-4">Welcome to Our Hotel</h1>
      <p class="lead">Experience luxury and comfort with our world-class services</p>
    </div>
  </header>

  <!-- Services Section -->
  <section id="services" class="py-5 bg-light">
    <div class="container text-center">
      <h2>Our Services</h2>
      <div class="row">
        <div class="col-md-4">
          <div class="card mb-4">
            <img src="https://via.placeholder.com/300" class="card-img-top" alt="Room Service">
            <div class="card-body">
              <h5 class="card-title">Room Service</h5>
              <p class="card-text">24/7 room service with delicious meals and snacks</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4">
            <img src="https://via.placeholder.com/300" class="card-img-top" alt="Spa and Wellness">
            <div class="card-body">
              <h5 class="card-title">Spa and Wellness</h5>
              <p class="card-text">Relax and rejuvenate with our exclusive spa treatments</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4">
            <img src="https://via.placeholder.com/300" class="card-img-top" alt="Swimming Pool">
            <div class="card-body">
              <h5 class="card-title">Swimming Pool</h5>
              <p class="card-text">Enjoy a refreshing swim in our luxurious pool</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- About Us Section -->
  <section id="about-us" class="py-5">
    <div class="container text-center">
      <h2>About Us</h2>
      <p>We are a luxury hotel dedicated to providing the best services to our guests. Our hotel features modern amenities, spacious rooms, and a dedicated team to ensure your stay is comfortable and enjoyable.</p>
    </div>
  </section>

  <!-- Booking Section -->
  <section id="booking" class="py-5 bg-light">
    <div class="container">
      <h2 class="text-center">Book Your Stay</h2>
      <form action="#" method="get">
        <div class="row">
          <div class="col-md-4">
            <div class="mb-3">
              <label for="check-in" class="form-label">Check-in Date</label>
              <input type="date" class="form-control" id="check-in" name="check-in" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label for="check-out" class="form-label">Check-out Date</label>
              <input type="date" class="form-control" id="check-out" name="check-out" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label for="rooms" class="form-label">Rooms</label>
              <select class="form-select" id="rooms" name="rooms" required>
                <option value="1">1 Room</option>
                <option value="2">2 Rooms</option>
                <option value="3">3 Rooms</option>
                <option value="4">4 Rooms</option>
              </select>
            </div>
          </div>
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-primary">Search Rooms</button>
        </div>
      </form>
    </div>
  </section>



</body>
</html>
