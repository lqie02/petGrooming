<?php
session_start();
include('../connection/connection.php');
if(isset($_SESSION["customerID"]))
{
	$id= $_SESSION["customerID"];
}
else{
	header('Location: ../index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Abby Shop</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

	<link rel="shortcut icon" type="image/png" href="../image/pets.png">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../css/style.css" rel="stylesheet">
</head>

<body>
<?php include('headerCart.php');?>

  <section id="hero" class="d-flex flex-column justify-content-center align-items-center">
    <div class="container text-center text-md-left" data-aos="fade-up">
      <h1>Welcome to <span>Abby Pet Shop</span></h1>
      <h2>A pet shop which provided pet grooming services and pet products</h2>
      <a href="#what-we-do" class="btn-get-started">Get Started</a>
    </div>
  </section>

  <main id="main">

    <section id="what-we-do" class="what-we-do">
      <div class="container">

        <div class="section-title">
          <h2>What We Provided</h2>
          <p>Our shop provided pet grooming service and also we have sell the product of pet.</p>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
            <div class="icon-box">
              <div class="icon"><i class="fa fa-paw"></i></div>
              <h4><a href="dog_grooming.php">Pet Grooming Service</a></h4>
              <p>We have provided cat and dog grooming services</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
            <div class="icon-box">
              <div class="icon"><i class="bx bx-file"></i></div>
              <h4><a href="dog_product.php">Pet Product</a></h4>
              <p>We have provided the product of the cat and dog</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="about" class="about">
      <div class="container">

        <div class="row">
          <div class="col-lg-4">
            <img src="../image/OIP.jpeg" class="img-fluid" alt="">
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0">
			  <br><br>
            <h3>About Us</h3>
            <p>
              We are the online pet shop that provided the pet grooming services for customer to make appointment and also have sell some products about cats and dogs.
            </p>
            <ul>
              <li><i class="bx bx-check-double"></i>Good service attitude.</li>
              <li><i class="bx bx-check-double"></i>Meet customer needs.</li>
            </ul>

          </div>
        </div>

      </div>
    </section>

    <section id="contact" class="contact section-bg">
      <div class="container">


        <div class="row mt-5 justify-content-center">        
		<div class="section-title">
          <h2>Contact Us</h2>
        </div>
          <div class="col-lg-10">
            <div class="info-wrap">
              <div class="row">
                <div class="col-sm-12 col-md-4 info">
                  <i class="bi bi-geo-alt"></i>
                  <h4>Location:</h4>
                  <p>19, Lorong Bukit Beruang Utama 1, Taman Bukit Beruang, 75450 Melaka</p>
                </div>

                <div class="col-sm-12 col-md-4 info mt-4 mt-md-0">
                  <a href="mailto:tanleqie@gmail.com"><i class="bi bi-envelope"></i></a>
                  <h4>Email:</h4>
                  <p>tanleqie@gmail.com</p>
                </div>

                <div class="col-sm-12 col-md-4 info mt-4 mt-md-0">
                  <i class="bi bi-phone"></i>
                  <h4>Call:</h4>
                  <p>+019 5050053</p>
                </div>
              </div>
              <div class="text-center">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7973.462860092325!2d102.276067!3d2.253978!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d1e55e72aa3e9f%3A0x27d1beab5de9f00e!2s19%2C%20Lorong%20Bukit%20Beruang%20Utama%201%2C%20Taman%20Bukit%20Beruang%20Indah%2C%2075450%20Melaka!5e0!3m2!1sen!2smy!4v1687789328571!5m2!1sen!2smy" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
              </div>
            </div>

          </div>
        </div>
       </div>
    </section>
  </main>


  <footer id="footer">
    <div class="container d-md-flex py-4">

      <div class="me-md-auto text-center text-md-start">
        <div class="copyright">
          &copy; Copyright <strong><span>Abby Shop</span></strong>. All Rights Reserved
        </div>

      </div>
      <div class="social-links text-center text-md-right pt-3 pt-md-0">
        <a href="https://twitter.com/lauren20000402" class="twitter"><i class="bx bxl-twitter"></i></a>
        <a href="https://www.facebook.com/tan.leqi.31/" class="facebook"><i class="bx bxl-facebook"></i></a>
        <a href="https://www.instagram.com/leqi.42/" class="instagram"><i class="bx bxl-instagram"></i></a>
      </div>
    </div>
  </footer>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


  <script src="../vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../vendor/waypoints/noframework.waypoints.js"></script>
  <script src="../vendor/php-email-form/validate.js"></script>


  <script src="../js/main.js"></script>

</body>

</html>