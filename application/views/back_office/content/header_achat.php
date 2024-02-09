<!DOCTYPE html>
<!--
Template Name: NobleUI - HTML Bootstrap 5 Admin Dashboard Template
Author: NobleUI
Website: https://www.nobleui.com
Portfolio: https://themeforest.net/user/nobleui/portfolio
Contact: nobleui123@gmail.com
Purchase: https://1.envato.market/nobleui_admin
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
	<meta name="author" content="NobleUI">
	<meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<title>GESCOM | 1.0</title>

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
</head>
<body>
	<div class="main-wrapper">

		<!-- partial:../../partials/_sidebar.html -->
		<nav class="sidebar">
      <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
          GES<span>COM</span>
        </a>
        <div class="sidebar-toggler not-active">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
      <div class="sidebar-body">
        <ul class="nav">
          <li class="nav-item nav-category">Main</li>
          <li class="nav-item">
            <a href="dashboard.html" class="nav-link">
              <i class="link-icon" data-feather="box"></i>
              <span class="link-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item nav-category"> MON DEPARTEMENT </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#" role="button" aria-expanded="false" aria-controls="emails">
              <i class="link-icon" data-feather="key"></i>
              <span class="link-title">KPI</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/apps/chat.html" class="nav-link">
              <i class="link-icon" data-feather="users"></i>
              <span class="link-title">Employes</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/apps/calendar.html" class="nav-link">
              <i class="link-icon" data-feather="calendar"></i>
              <span class="link-title">Agenda</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI" role="button" aria-expanded="false" aria-controls="advancedUI">
              <i class="link-icon" data-feather="anchor"></i>
              <span class="link-title"> Service Achat </span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="advancedUI">
              <ul class="nav sub-menu">
                <li class="nav-item">
                  <a href="#" class="nav-link">Ensemble besoins</a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">Besoins globaux</a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">Proforma</a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">Bon de Commande</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item nav-category">BESOIN ACHAT</li>
          <li class="nav-item">
            <a data-bs-toggle="modal" data-bs-target="#addAchat" class="nav-link">
              <i class="link-icon" data-feather="tag"></i>
              <span class="link-title">Faire une demande d'achat</span>
            </a>

          </li>
          <li class="nav-item">
            <a href="dashboard.html" class="nav-link">
              <i class="link-icon" data-feather="map"></i>
              <span class="link-title">Liste des demandes</span>
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- MODAL DE VERIFICATION -->
    <div class="modal fade" id="addAchat" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle"> Voulez vous vraiment creer une nouvelle demande ? </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
          </div>
          <form action="<?php echo site_url("index.php/back_office/BesoinController/createBesoinCtrl") ?>" method="POST">
            <div style="padding: 3% 3% 3% 3%">
              <button type="submit" class="btn btn-primary" style="margin-left:45%"> Oui </button>
            </div>   
          </form>
        </div>
      </div>
    </div>
  
        <!-- partial -->
        <div class="page-wrapper">
          <nav class="navbar">
            <a href="#" class="sidebar-toggler">
              <i data-feather="menu"></i>
            </a>
            <div class="navbar-content">
              <form class="search-form">
                <div class="input-group">
                  <div class="input-group-text">
                    <i data-feather="search"></i>
                  </div>
                  <input type="text" class="form-control" id="navbarForm" placeholder="Search here...">
                </div>
              </form>
              <ul class="navbar-nav">
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="flag-icon flag-icon-us mt-1" title="us"></i> <span class="ms-1 me-1 d-none d-md-inline-block">Departement <?php echo $user_session['nomdepartement'] ?> </span>
                  </a>
                </li>

                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="wd-30 ht-30 rounded-circle" src="<?php echo base_url() ?>/assets/back_office/images/face5.jpg" alt="profile">
                  </a>
                  <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                    <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                      <div class="mb-3">
                        <img class="wd-80 ht-80 rounded-circle" src="<?php echo base_url() ?>/assets/back_office/images/face5.jpg" alt="">
                      </div>
                      <div class="text-center">
                        <p class="tx-16 fw-bolder"><?php echo $user_session['nom'] . ' ' . $user_session['prenom'] ?></p>
                        <p class="tx-12 text-muted"><?php echo $user_session['nomposte'] ?></p>
                      </div>
                    </div>
                    <ul class="list-unstyled p-1">
                      <li class="dropdown-item py-2">
                        <a href="pages/general/profile.html" class="text-body ms-0">
                          <i class="me-2 icon-md" data-feather="user"></i>
                          <span>Profile</span>
                        </a>
                      </li>
                      <li class="dropdown-item py-2">
                        <a href="<?php echo site_url("index.php/back_office/LoginController/logout") ?>" class="text-body ms-0">
                          <i class="me-2 icon-md" data-feather="log-out"></i>
                          <span>Log Out</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
              </ul>
            </div>
          </nav>