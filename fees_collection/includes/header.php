<?php
define("BASEPATH", "../");
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SRMVCAS - ERP</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="stylesheet" type="text/css" href="<?php echo BASEPATH; ?>assets/dist/css/styles.css"/>

  <link rel="shortcut icon" href="<?php echo BASEPATH; ?>assets/images/emblem_ramakrishna_order.png">

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo BASEPATH; ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo BASEPATH; ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo BASEPATH; ?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo BASEPATH; ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- DataTables Buttons-->
  <!-- <link rel="stylesheet" href="<?php echo BASEPATH; ?>assets/bower_components/datatables.button/jquery.dataTables.min.css"> -->
  <link rel="stylesheet" href="<?php echo BASEPATH; ?>assets/bower_components/datatables.button/buttons.dataTables.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo BASEPATH; ?>assets/bower_components/select2/dist/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo BASEPATH; ?>assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo BASEPATH; ?>assets/dist/css/skins/_all-skins.min.css">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <!-- sweet-alert -->
  <link rel="stylesheet" href="<?php echo BASEPATH; ?>assets/plugins/sweet-alert/css/sweet-alert.min.css" />
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo BASEPATH; ?>assets/plugins/toastr/toastr.min.css" />

  <style>
    #toast-container > div {
      margin-top: 41px;
      margin-right: 2px;
       opacity: 1;
      -ms-filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=100);
      filter: alpha(opacity=100);
    }

    .table.table-bordered > thead > tr > th{
        color: #ffffff;
        font-size: 14px;
        font-weight: 400;
        background-color: #3c8dbc !important;
    }
    .table.table-bordered > tbody > tr > td{
        font-size: 14px;
    }

    table.table-border{
        border:1px solid #2C3B41;
    }
    table.table-border > thead > tr > th{
        border:1px solid #2C3B41;
        color: #ffffff;
        font-size: 14px;
        font-weight: 500;
        background-color: #3c8dbc;
    }
    table.table-border > tbody > tr > td{
        border:1px solid #2C3B41;
        font-size: 14px;
    }
    table.table-border > tfoot > tr > td{
        border:1px solid #2C3B41;
        font-size: 14px;
        font-weight: bold;
    }

    .example-modal .modal {
        position: relative;
        top: auto;
        bottom: auto;
        right: auto;
        left: auto;
        display: block;
        z-index: 1;
    }
    .example-modal .modal {
        background: transparent !important;
    }
  </style>

</head>

<body class="hold-transition skin-blue fixed sidebar-mini">
  <div class="wrapper">
    <header class="main-header">
      <a href="index.php" class="logo">
		    <span class="logo-mini"><img src="<?php echo BASEPATH; ?>assets/images/emblem_ramakrishna_order.png" width="50" height="50" /></span>
        <span class="logo-lg">SRMVCAS</span>
      </a>
      <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
          &nbsp;&nbsp;&nbsp;&nbsp;Sri Ramakrishna Mission Vidyalaya College of Arts and Science
        </a>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown messages-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-envelope-o"></i>
                <span class="label label-success">4</span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">You have 4 messages</li>
                <li>
                  <ul class="menu">
                    <li>
                      <a href="#">
                        <div class="pull-left">
                          <img src="<?php echo BASEPATH; ?>assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                        </div>
                        <h4>
                          Support Team
                          <small><i class="fa fa-clock-o"></i> 5 mins</small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="footer"><a href="#">See All Messages</a></li>
              </ul>
            </li>
            <li class="dropdown notifications-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
                <span class="label label-warning">10</span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">You have 10 notifications</li>
                <li>
                  <ul class="menu">
                    <li>
                      <a href="#">
                        <i class="fa fa-users text-aqua"></i> 5 new members joined today
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="footer"><a href="#">View all</a></li>
              </ul>
            </li>
            <li class="dropdown tasks-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-flag-o"></i>
                <span class="label label-danger">9</span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">You have 9 tasks</li>
                <li>
                  <ul class="menu">
                    <li>
                      <a href="#">
                        <h3>
                          Design some buttons
                          <small class="pull-right">20%</small>
                        </h3>
                        <div class="progress xs">
                          <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                            <span class="sr-only">20% Complete</span>
                          </div>
                        </div>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="footer">
                  <a href="#">View all tasks</a>
                </li>
              </ul>
            </li>
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?php echo BASEPATH; ?>assets/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                <span class="hidden-xs"><?php echo $_SESSION["uname"]; ?></span>
              </a>
              <ul class="dropdown-menu">
                <li class="user-header">
                  <img src="<?php echo BASEPATH; ?>assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                  <p>
                    <?php echo $_SESSION["uname"]; ?> - Web Developer
                    <!-- <small>Member since Nov. 2012</small> -->
                  </p>
                </li>
                <li class="user-footer">
                  <!-- <div class="pull-left">
                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                  </div> -->
                  <div class="pull-right">
                    <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>