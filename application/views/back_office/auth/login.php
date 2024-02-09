<!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <!-- End fonts -->

	<!-- core:css -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/back_office/vendors/core/core.css">
	<!-- endinject -->

	<!-- Plugin css for this page -->
	<!-- End plugin css for this page -->

	<!-- inject:css -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/back_office/fonts/feather-font/css/iconfont.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/back_office/vendors/flag-icon-css/css/flag-icon.min.css">
	<!-- endinject -->

  <!-- Layout styles -->  
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/back_office/css/demo1/style.css">
  <!-- End layout styles -->

  <link rel="shortcut icon" href="<?php echo base_url() ?>assets/back_office/images/favicon.png" />

<div class="main-wrapper">
    <div class="page-wrapper full-page">
        <div class="page-content d-flex align-items-center justify-content-center">
            <div class="row w-100 mx-0 auth-page">
                <div class="col-md-8 col-xl-6 mx-auto">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-4 pe-md-0">
                               <img src="<?php echo base_url() ?>assets/back_office/images/1.jpg" alt="">
                            </div>
                            <div class="col-md-8 ps-md-0">
                                <div class="auth-form-wrapper px-4 py-5">
                                <a href="#" class="noble-ui-logo d-block mb-2">GES<span>COM</span></a>
                                <h5 class="text-muted fw-normal mb-4">Welcome back to work!</h5>
                                <form class="forms-sample" action="LoginController/login" method="POST">
                                    <div class="mb-3">
                                    <label for="userEmail" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="userEmail" placeholder="Email" name="email">
                                    </div>
                                    <div class="mb-3">
                                    <label for="userPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="userPassword" autocomplete="current-password" placeholder="Password" name="pass">
                                    </div>
                                    <div>
                                    <button type="submit" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                                        Login
                                    </button>
                                    </div>
                                    <a href="register.html" class="d-block mt-3 text-muted">Not a user? Sign up</a>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

	<!-- core:js -->
	<script src="<?php echo base_url() ?>assets/back_office/vendors/core/core.js"></script>
	<!-- endinject -->

	<!-- Plugin js for this page -->
	<!-- End plugin js for this page -->

	<!-- inject:js -->
	<script src="<?php echo base_url() ?>assets/back_office/vendors/feather-icons/feather.min.js"></script>
	<script src="<?php echo base_url() ?>assets/back_office/js/template.js"></script>
	<!-- endinject -->
	<!-- Custom js for this page -->
	<!-- End custom js for this page -->