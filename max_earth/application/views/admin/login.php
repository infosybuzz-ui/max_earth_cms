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
            padding-bottom: 20px;
            margin-bottom: 30px;
            font-size: 21px;
        }

        .txt-warning {
            color: var(--theme-color);
        }

        .min-height {
            min-height: 70rem;
        }

        .login-area {
            background-color: #f0f0f0;
        }

        .alert-warning {
            --bs-alert-color: #fff;
            --bs-alert-bg: var(--theme-color);
        }
		 
.header-top {
  background: var(--color-dark);
  padding: 14px 0 16px 0;
  position: relative;
  z-index: 1;
}

.header-top::before {
  content: "";
  position: absolute;
  left: 0;
  top: 0;
  bottom: 0;
  width: 10%;
  background: var(--theme-color);
  z-index: -1;
}

.header-top::after {
  content: "";
  position: absolute;
  right: 20px;
  top: 0;
  bottom: 0;
  width: 30%;
  background: var(--theme-color);
  border-left: 10px solid var(--color-white);
  border-right: 10px solid var(--color-white);
  z-index: -1;
}

.header-top-wrapper {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.header-top-contact ul {
  display: flex;
  align-items: center;
  gap: 25px;
}

.header-top-contact a {
  color: var(--color-white);
}

.header-top-contact a i {
  color: var(--theme-color);
}

.header-top-right {
  display: flex;
  align-items: center;
  gap: 15px;
}

.header-top-link a {
  color: var(--color-white);
  margin-right: 12px;
}

.header-top-link a:hover {
  color: var(--theme-color);
}

.header-top-social span {
  color: var(--color-white);
}

.header-top-social a {
  color: var(--color-white);
  font-size: 16px;
  text-align: center;
  margin-left: 14px;
  transition: var(--transition);
}

.header-top-social a:hover {
  color: var(--color-dark);
}


@media all and (max-width: 1199px) {

  .header-top-contact ul {
    gap: 10px;
  }

  .header-top-social a {
    width: 34px;
    height: 34px;
    line-height: 37px;
    margin-left: 0;
  }

  .header-top-left {
    margin-right: 5px;
  }
}

@media all and (max-width: 992px) {
  .header-top {
    display: none;
  }
}

    </style>
</head>

<body>

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
    </header>

    <!-- Main Login Area -->
    <main class="main">
        <section class="login-area py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-5">
                        <div class="login-form p-4 shadow rounded bg-white">
                            <div class="login-header text-center mb-4">
                                <img src="<?php echo WEBSITE_ASSETS_URL?>img/logo/logo.png" alt="Logo" class="img-fluid mb-3" style="max-height: 60px;">
                                <p class="mb-0">Login with your Minox account</p>
                            </div>

                            <!-- Alert Box -->
                            <div id="alertBox"></div>

                            <!-- Login Form -->
                            <?php 
								$attributes = array('class' => 'm-t', 'id' => 'login-form', 'autocomplete' => 'off');
								echo form_open('javascript:;', $attributes);
							?>
                                <div class="form-group mb-3">
                                    <label for="form-email" class="form-label">Username</label>
                                    <input id="form-email" type="email" placeholder="Your Username" class="form-control" name="username"/>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="form-password" class="form-label">Password</label>
                                    <input id="form-password" type="password" placeholder="Your Password" class="form-control" name="password"/>
                                </div>
                                <div class="d-grid">
                                    <button type="button" class="theme-btn" id="thisSubmit">
                                        <i class="fa-solid fa-right-to-bracket"></i> Login
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

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
  

    <!-- js -->
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

<link href="<?php echo ADMIN_ASSETS_URL?>css/sweet-alert.css" rel="stylesheet">
<script src="<?php echo ADMIN_ASSETS_URL?>js/sweet-alert.min.js"></script>
<link href="<?php echo ADMIN_ASSETS_URL?>css/plugins/toastr/toastr.min.css" rel="stylesheet">
<script src="<?php echo ADMIN_ASSETS_URL?>js/plugins/toastr/toastr.min.js"></script>
<script>
jQuery(document).ready(function() {
	var flashMessage = "<?php echo $flashMessage?>";
	var flashType = "<?php echo $flashType?>";
	if($.trim(flashType) === 'success') {
		showToast('success',flashMessage);
	} else if($.trim(flashType) === 'error') {
		showToast('error',flashMessage);
	}	
	
	$(document).on('keyup','#form-email,#form-password',function(e){
		var charCode = (e.which) ? e.which : e.keyCode;
		if(charCode == 13) {
			var btn = $('#thisSubmit');
			loginSubmit(btn);
		}
	});
	
	$(document).on('click','#thisSubmit',function(e){
		var btn = $(this);
		e.preventDefault();
		loginSubmit(btn);
	});   
});
	
function loginSubmit(btn)
{
	if($.trim($('input[name="username"]').val()) === '' && $.trim($('input[name="password"]').val()) === '') {
		showToast('error','Please enter both fields');
		return false;
	} else if($.trim($('input[name="username"]').val()) === '') {
		showToast('error','Please enter username');
		return false;
	} else if($.trim($('input[name="password"]').val()) === '') {
		showToast('error','Please enter password');
		return false;
	} else  {
		btn.text('Authenticating...').attr('disabled',true);
		$.ajax({
			type : 'POST',
			url : '<?php echo ADMIN_BASE_URL?>'+'login',
			data : $('#login-form').serialize(),
			dataType: 'JSON',
			error : function(){
				btn.val('Login').attr('disabled',false);
				showToast('error','An internal error has occured.');
			},
			success : function(response){
					if(response.status) {
						btn.text('Redirecting...');
						var href = window.location.href;
						if(href.indexOf('return_url') > -1) {
							href = href.split('=');
							window.location.href = decodeURIComponent(href[1]);
						} else {
							location.replace(response.redirectTo);
						}
					} else {
						btn.text('Login').attr('disabled',false);
						showToast('error','Please check your Username/Password.');					
					}	
			}
		});
	}
}

function showToast(type,message)
{
	toastr.options = {
		closeButton: true,
		progressBar: true,
		showMethod: 'slideDown',
		timeOut: 2000
	};
	if($.trim(type) === 'success') {
		toastr.success(message);
	} else {
		toastr.error(message);
	}
}
	
    </script>
</body>

</html>
