 <!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Title -->
    <title>Welcome To Max Earth Resources!</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo WEBSITE_ASSETS_URL?>img/logo/favicon.png">

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo WEBSITE_ASSETS_URL?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo WEBSITE_ASSETS_URL?>css/all-fontawesome.min.css">
    <link rel="stylesheet" href="<?php echo WEBSITE_ASSETS_URL?>css/flaticon.css">
    <link rel="stylesheet" href="<?php echo WEBSITE_ASSETS_URL?>css/animate.min.css">
    <link rel="stylesheet" href="<?php echo WEBSITE_ASSETS_URL?>css/magnific-popup.min.css">
    <link rel="stylesheet" href="<?php echo WEBSITE_ASSETS_URL?>css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo WEBSITE_ASSETS_URL?>css/style.css">

    <style>
        .footer-content-box p {
            color: var(--color-white);
            padding-right: 18px;
            margin-bottom: 20px;
        }

        .footer-content-title {
            color: var(--color-white);
            position: relative;
            padding-bottom: 20px;
            margin-bottom: 30px;
            font-size: 21px;
            z-index: 1;
        }

        .txt-warning {
            color: var(--theme-color);
        }

        .min-height {
            min-height: 70rem;
        }
    </style>
</head>

<body>

    <!-- Preloader -->
    <div class="preloader">
        <div class="loader-ripple">
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- Preloader End -->

    <!-- Header Area -->
    <header class="header">

        <!-- Top Header -->
        <div class="header-top">
            <div class="container">
                <div class="header-top-wrapper">
                    <div class="header-top-left">
                        <div class="header-top-contact">
                            <ul>
                                <li>
                                    <a href="#">
                                        <i class="far fa-location-dot"></i>
                                        Wellington Business Park-1 Andheri East, Mumbai-400059
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="far fa-envelopes"></i>
                                        <span>support@maxearth.com</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="tel:+21236547898">
                                        <i class="far fa-phone-volume"></i>
                                        +91 9202811733
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="header-top-right">
                        <div class="header-top-social">
                            <span>Follow Us: </span>
                            <a href="https://facebook.com"><i class="fab fa-facebook"></i></a>
                            <a href="https://x.com"><i class="fab fa-x-twitter"></i></a>
                            <a href="https://instagram.com"><i class="fab fa-instagram"></i></a>
                            <a href="https://linkedin.com"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="main-navigation">
            <nav class="navbar navbar-expand-lg">
                <div class="container position-relative">
                    <a class="navbar-brand" href="index.html">
                        <img src="<?php echo WEBSITE_ASSETS_URL?>img/logo/logo.png" alt="logo">
                    </a>

                    <div class="mobile-menu-right"> 
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#main_nav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-mobile-icon">
                                <i class="far fa-bars"></i>
                            </span>
                        </button>
                    </div>

                    <div class="collapse navbar-collapse" id="main_nav">
                        <ul class="navbar-nav">
                            <li class="nav-item"><a class="nav-link <?php echo @$pageName == 'home' ? 'active' : ''?>" href="<?php echo WEBSITE_BASE_URL?>">Home</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo @$pageName == 'about' ? 'active' : ''?>" href="<?php echo WEBSITE_BASE_URL.'about'?>">About</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo @$pageName == 'verticals' ? 'active' : ''?>" href="<?php echo WEBSITE_BASE_URL.'verticals'?>">Verticals</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo @$pageName == 'projects' ? 'active' : ''?>" href="<?php echo WEBSITE_BASE_URL.'projects'?>">Projects</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo @$pageName == 'investors' ? 'active' : ''?>" href="<?php echo WEBSITE_BASE_URL.'investors'?>">Investors</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo @$pageName == 'latest_news' ? 'active' : ''?>" href="<?php echo WEBSITE_BASE_URL.'latest-news'?>">News</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo @$pageName == 'contact_us' ? 'active' : ''?>" href="<?php echo WEBSITE_BASE_URL.'contact-us'?>">Contact</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?php echo ADMIN_BASE_URL.'login'?>">Administration</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <!-- Navigation End -->
    </header>
    <!-- Header Area End -->
	
	<?php $this->load->view($view) ?>

    <!-- footer area -->
    <section>
  <footer class="footer-area">
    <div class="footer-content py-5">
      <div class="container">
        <div class="row">
          <!-- About Us -->
          <div class="col-md-6 col-lg-4">
            <div class="footer-content-box about-us">
              <a href="#" class="footer-logo d-inline-block mb-3">
                <img src="<?php echo WEBSITE_ASSETS_URL?>img/logo/logo-light.png" alt="MaxEarth Logo" />
              </a>
              <p class="mb-3">
                We are many variations of passages available but the majority have suffered alteration in some form by injected humour words believable.
              </p>
              <ul class="list-unstyled footer-contact">
                <li>
                  <a href="tel:+919202811733"><i class="fa-solid fa-phone me-2"></i>+91 9202811733</a>
                </li>
                <li>
                  <a href="mailto:info@maxearth.com"><i class="fa-solid fa-location-dot me-2"></i>103/104 Wellington Business Park-1 Marol, Andheri East, Mumbai-400059.</a>
                </li>
                <li>
                  <a href="mailto:info@maxearth.com"><i class="fa-solid fa-envelope me-2"></i>info@maxearth.com</a>
                </li>
              </ul>
            </div>
          </div>

          <!-- Quick Links -->
          <div class="col-md-6 col-lg-2">
            <div class="footer-content-box list">
              <h4 class="footer-content-title">Quick Links</h4>
              <ul class="footer-list list-unstyled">
                <li><a href="<?php echo WEBSITE_BASE_URL.'about'?>"><i class="fas fa-caret-right me-2"></i>About Us</a></li>
                <li><a href="<?php echo WEBSITE_BASE_URL.'verticals'?>"><i class="fas fa-caret-right me-2"></i>Verticals</a></li>
                <li><a href="<?php echo WEBSITE_BASE_URL.'projects'?>"><i class="fas fa-caret-right me-2"></i>Projects</a></li>
              </ul>
            </div>
          </div>

          <!-- Our Services (Hidden Title) -->
          <div class="col-md-6 col-lg-2">
            <div class="footer-content-box list">
              <h4 class="footer-content-title" style="visibility: hidden;">Our Services</h4>
              <ul class="footer-list list-unstyled">
                <li><a href="<?php echo WEBSITE_BASE_URL.'investors'?>"><i class="fas fa-caret-right me-2"></i>Investors</a></li>
                <li><a href="<?php echo WEBSITE_BASE_URL.'latestNews'?>"><i class="fas fa-caret-right me-2"></i>latestNews</a></li>
                <li><a href="<?php echo WEBSITE_BASE_URL.'contactus'?>"><i class="fas fa-caret-right me-2"></i>Contact Us</a></li>
              </ul>
            </div>
          </div>

          <!-- Newsletter -->
          <div class="col-md-6 col-lg-3">
            <div class="footer-content-box list">
              <h4 class="footer-content-title">Join Our Newsletter</h4>
              <div class="footer-newsletter">
                <p>Stay updated with our latest news and offers.</p>
                <form class="subscribe-form">
                  <input type="email" class="form-control mb-2" placeholder="Your Email" required />
                  <button class="theme-btn w-100" type="submit">
                    Subscribe Now <i class="fa-solid fa-paper-plane ms-2"></i>
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Copyright -->
    <div class="copyright">
      <div class="container">
        <div class="row">
          <div class="col-md-6 align-self-center">
            <p class="copyright-text">
              &copy; 2025 Max Earth Resources Ltd. All Rights Reserved..<br />
              Powered by <a href="#">Neorotech Solutions Pvt Ltd.</a>
            </p>
          </div>
          <div class="col-md-6 align-self-center">
            <ul class="footer-social">
              <li><a href="https://facebook.com" target="_blank"><i class="fa-brands fa-facebook-f"></i></a></li>
              <li><a href="https://twitter.com" target="_blank"><i class="fa-brands fa-twitter"></i></a></li>
              <li><a href="https://www.youtube.com/" target="_blank"><i class="fa-brands fa-youtube"></i></a></li>
              <li><a href="https://www.linkedin.com/" target="_blank"><i class="fa-brands fa-linkedin"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scroll to Top Button -->
  <a href="#" id="scroll-top" class="scroll-top" aria-label="Scroll to top">
    <i class="fa-solid fa-arrow-up"></i>
  </a>
</section>
    <!-- footer area end -->




    <!-- scroll-top -->
    <a href="#" id="scroll-top"><i class="far fa-arrow-up-from-arc"></i></a>
    <!-- scroll-top end -->


    <!-- js -->
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="<?php echo WEBSITE_ASSETS_URL?>js/jquery-3.6.0.min.js"></script>
    <script src="<?php echo WEBSITE_ASSETS_URL?>js/modernizr.min.js"></script>
    <script src="<?php echo WEBSITE_ASSETS_URL?>js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo WEBSITE_ASSETS_URL?>js/imagesloaded.pkgd.min.js"></script>
    <script src="<?php echo WEBSITE_ASSETS_URL?>js/jquery.magnific-popup.min.js"></script>
    <script src="<?php echo WEBSITE_ASSETS_URL?>js/isotope.pkgd.min.js"></script>
    <script src="<?php echo WEBSITE_ASSETS_URL?>js/jquery.appear.min.js"></script>
    <script src="<?php echo WEBSITE_ASSETS_URL?>js/jquery.easing.min.js"></script>
    <script src="<?php echo WEBSITE_ASSETS_URL?>js/owl.carousel.min.js"></script>
    <script src="<?php echo WEBSITE_ASSETS_URL?>js/counter-up.js"></script>
    <script src="<?php echo WEBSITE_ASSETS_URL?>js/wow.min.js"></script>
    <script src="<?php echo WEBSITE_ASSETS_URL?>js/main.js"></script>

</body>

</html>