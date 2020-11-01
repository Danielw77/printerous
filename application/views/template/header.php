<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Printerous Code Challenge - Daniel Wijaya</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/bootstrap.min.css">
    <script src="<?php echo base_url(); ?>application/assets/js/jquery-3.4.1.min.js"></script>
    <script src="<?php echo base_url(); ?>application/assets/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>application/assets/font-awesome-4.7.0/css/font-awesome.min.css">

    <!-- custom css -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>application/assets/css/style.css"> 
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>application/assets/css/Chart.min.css"> 
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>application/assets/css/Chart.css"> 
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>application/assets/DataTables/datatables.min.css"/>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>application/assets/sweetalert/dist/sweetalert2.min.css">

    <!-- custom js -->
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>application/assets/js/progressbar.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>application/assets/js/progressbar.min.js"></script> -->
    <script type="text/javascript" src="<?php echo base_url(); ?>application/assets/js/jQuery.fixTableHeader.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>application/assets/js/jQuery.fixTableHeader.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>application/assets/js/Chart.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>application/assets/js/Chart.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>application/assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>application/assets/DataTables/datatables.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>application/assets/sweetalert/dist/sweetalert2.min.js"></script>

</head>
<body>

 <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand text-white" style="font-size: 30px; margin-right: 5%;" href="<?php echo base_url() ?>home/index">
    <img src="<?php echo base_url(); ?>application/assets/img/printerous.png" width="150" height="30" class="d-inline-block align-top pt-1 ml-2" alt="">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link text-white" href="<?php echo base_url() ?>home/index">Home <span class="sr-only">(current)</span></a>
      </li>
      <?php if ($isLoggedIn) { ?>

          <?php if ($isAdmin) { ?>
             <li class="nav-item dropdown">
            <div class="dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Admin Page
                </a>
              <div class="dropdown-menu " aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="<?php echo base_url() ?>admin/index"><span><i class="fa fa-home fa-1x text-dark"></i></span>&nbsp;&nbsp;Dashboard</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo base_url() ?>admin/accountmanagement"><span><i class="fa fa-user fa-1x text-dark"></i></span>&nbsp;&nbsp;Account Management<span class="sr-only"></span></a>
                <a class="dropdown-item" href="<?php echo base_url() ?>organization"><span><i class="fa fa-users fa-1x text-dark"></i></span>&nbsp;&nbsp;Organization Management<span class="sr-only"></span></a>
              </div>
            </div>
            </li>
          <?php } else { ?>
            <li class="nav-item">
              <a class="nav-link text-white" href="<?php echo base_url() ?>organization">Organization</a>
            </li>
          <?php } ?>
      <?php } ?>
      <li class="nav-item">
         <a class="nav-link text-white" href="<?php echo base_url() ?>home/about">About</a>
      </li>
     <!--  <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Contact
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li> -->
    </ul>

     <?php if (!$isLoggedIn) { ?>
        <a class="nav-link text-white" href="<?php echo base_url() ?>login/index">Login / Register <span class="sr-only">(current)</span></a>
      <?php } else { ?>
        <ul class="navbar-nav ml-auto">
         <li class="nav-item dropdown">
          <div class="dropdown dropleft float-right">
              <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo $name ?>
              </a>
            <div class="dropdown-menu " aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="<?php echo base_url() ?>home/logout">Logout<span class="sr-only"></span></a>
            </div>
          </div>
          </li>
        </ul>
       <?php } ?>  
  </div>
</nav>