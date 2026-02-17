<?php

function notify_discord_completion() {
    $webhookUrl = 'DISCORD_WEBHOOK'; // <- Change it
    
    $message = sprintf(
        "🎉 **CTF Completed!**\n```\nTime: %s UTC\nIP: %s\nUser-Agent: %s\n```",
        gmdate('Y-m-d H:i:s'),
        $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        substr($_SERVER['HTTP_USER_AGENT'] ?? 'unknown', 0, 100)
    );
    
    $payload = json_encode(['content' => $message]);
    
    $ch = curl_init($webhookUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3); // Don't slow down the user's redirect
    @curl_exec($ch); // @ suppresses errors so it doesn't break the page
    curl_close($ch);
}


// public_html/gateway/index.php
session_start();
header('X-Frame-Options: SAMEORIGIN');
$SECRET_KEY = '0f691d47543dcc93b500f2a50bab346e0cfe60ad4668b17ed89ea0f0a38f53b9';

// HMACs generated for the three flags (do not put plaintext flags here)
$EXPECTED_HMACS = [
  'f6882f1e0d517ad88d24274d41bb64a1df47a1a5b27d613253764375f2b92452',
  '90e797bcb1967dc9c46e127db75504fabd13bafc63168846e102316a0bc2df6e',
  '9921ceec8f1d411d747252eea794180a6563809461b5b07dda782b3bb12c8771'
];

// Rate-limit config
$MAX_ATTEMPTS = 8;
$BLOCK_SECONDS = 300;

if (!isset($_SESSION['attempts'])) $_SESSION['attempts'] = 0;
if (!isset($_SESSION['first_block_time'])) $_SESSION['first_block_time'] = 0;

$now = time();
$blocked = false;
if ($_SESSION['attempts'] >= $MAX_ATTEMPTS) {
    $blocked_until = $_SESSION['first_block_time'] + $BLOCK_SECONDS;
    if ($now < $blocked_until) $blocked = true;
    else {
        $_SESSION['attempts'] = 0;
        $_SESSION['first_block_time'] = 0;
    }
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$blocked) {
    $p1 = isset($_POST['f1']) ? trim($_POST['f1']) : '';
    $p2 = isset($_POST['f2']) ? trim($_POST['f2']) : '';
    $p3 = isset($_POST['f3']) ? trim($_POST['f3']) : '';

    if ($p1 === '' || $p2 === '' || $p3 === '') {
        $errors[] = "Please fill all three fields.";
    } else {
        $inputs = [$p1, $p2, $p3];
        $ok = true;
        foreach ($inputs as $i => $val) {
            $computed = hash_hmac('sha256', $val, $SECRET_KEY);
            if (!hash_equals($computed, $EXPECTED_HMACS[$i])) {
                $ok = false;
                break;
            }
        }
        if ($ok) {
            $_SESSION['ctf_unlocked'] = time();
            $_SESSION['attempts'] = 0;
            $_SESSION['first_block_time'] = 0;

            // Send Discord notification
            notify_discord_completion();

            header('Location: /secret/');
            exit();
        } else {
            $_SESSION['attempts'] += 1;
            if ($_SESSION['attempts'] === 1) $_SESSION['first_block_time'] = time();
            $errors[] = "Incorrect flags. Attempts left: " . max(0, $MAX_ATTEMPTS - $_SESSION['attempts']);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="robots" content="noindex">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Gateway - Enter Flags</title>
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
		background-image: url('../assets/img/gate-closed.jpg');
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
                <h1>You are at the final gate</h1>
                <p class="lead">Enter the three flags you collected (DNS TXT, header, and decoded challenge). This form validates them server-side.</p>

                <?php if ($blocked): 
					$until = $_SESSION['first_block_time'] + $BLOCK_SECONDS;
					$wait = $until - time();
				?>
				<div class="alert alert-danger">Too many attempts. Try again in <?=htmlspecialchars($wait)?> seconds.</div>
				<?php endif; ?>

				<?php if (!empty($errors)): foreach ($errors as $e): ?>
					<div class="alert alert-warning"><?=htmlspecialchars($e)?></div>
					<?php endforeach; endif; ?>

					<form method="post" class="mt-3">
						<div class="mb-3">
							<label class="form-label">Flag 1 (DNS TXT)</label>
							<input name="f1" class="form-control" autocomplete="off" />
						</div>
						<div class="mb-3">
							<label class="form-label">Flag 2 (Header)</label>
							<input name="f2" class="form-control" autocomplete="off" />
						</div>
						<div class="mb-3">
							<label class="form-label">Flag 3 (Decoded challenge)</label>
							<input name="f3" class="form-control" autocomplete="off" />
						</div>
						<button class="btn btn-primary" type="submit" <?= $blocked ? 'disabled' : '' ?>>Unlock</button>
					</form>
				
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