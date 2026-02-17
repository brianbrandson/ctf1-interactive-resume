<?php
session_start();
$VALID_FOR = 60*60; // 1 hour validity after unlock
if (!isset($_SESSION['ctf_unlocked']) || (time() - $_SESSION['ctf_unlocked']) > $VALID_FOR) {
    http_response_code(403);
    echo "<!doctype html><meta charset='utf-8'><title>Forbidden</title><link rel='stylesheet' href='/assets/bootstrap.min.css'><div class='container py-5'><h1>Access denied</h1><p>You must get a key of the gate at <a href='/gateway/'>/gateway</a> first.</p></div>";
    exit();
}
// Optionally set header flag for final
header('X-Final-Flag: FLAG{s3cret5-hunt3r}');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="robots" content="noindex">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Secret — Reward</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="../assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: SnapFolio
  * Template URL: https://bootstrapmade.com/snapfolio-bootstrap-portfolio-template/
  * Updated: Jul 21 2025 with Bootstrap v5.3.7
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <style>
	body {
		background-image: url('../assets/img/gate-opened.jpg');
		background-size: cover;
		background-repeat: no-repeat;
		background-attachment: fixed;
		background-position: top;
	}

	/* Optional overlay for readability */
	body::before {
		content: "";
		position: fixed;
		top: 0; left: 0;
		width: 100%; height: 100%;
		background: rgba(0, 0, 0, 0.30);  /* darker overlay */
		z-index: -1;
	}
	/* Center hero text and buttons only on the Tech Fair page */
	#index-page #hero .hero-text,
	body.index-page #hero .hero-text {
		text-align: center;
	}

	#index-page #hero .hero-actions,
	body.index-page #hero .hero-actions {
		justify-content: center;
	}

	/* Optional: center the entire column horizontally */
	body.index-page #hero .row.align-items-center {
		justify-content: center;
	}
	
	/* Remove left margin on page */
	body.index-page main.main {
		margin-left: 0 !important;
}
  </style>
</head>

<body class="index-page">

  <header id="header" class="header dark-background d-flex flex-column justify-content-center">
    <i class="header-toggle d-xl-none bi bi-list"></i>

  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section" style="background: transparent !important;">

      <div class="hero-content">

        <div class="container">
          <div class="row align-items-center">

            <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
              <div class="hero-text">
                <h1>🎉You unlocked the gate</h1>
                <p class="lead">Here is your final flag: <code class="bg-dark text-white px-2 py-1 rounded">FLAG{s3cret5-hunt3r}</code></p>

                <div class="hero-actions">
				   <a href="#" _target="blank" rel="noopener noreferrer" class="btn btn-primary">Open Résumé</a>
				   <a href="mailto:brianbrandson@proton.me" class="btn btn-outline"><i class="bi bi-chat-dots"></i> Tell me how it went</a>
                </div>
				
              </div>
            </div>

          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->
  </main>
  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/vendor/typed.js/typed.umd.js"></script>
  <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="../assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>

</html>
