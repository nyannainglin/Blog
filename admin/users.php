<!-- header section -->
<?php
  session_start();
  require '../config/config.php';
  

  if(empty($_SESSION['user_id']) && empty($_SESSION['singged_in'])) {

    header('location: login.php');
  }
?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Article Blog Web Application</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline" method="post">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search" name="search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['user_name'] ?></a>
        </div>
      </div>

      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="index.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Blogs
              </p>
            </a>
            <a href="users.php" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Users
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-12">


          <div class="card">
              <div class="card-header">
                <h3 class="card-title">Blogs Table</h3>
              </div>
              <!-- main content -->
              <?php

                  $stat = $pdo->prepare("SELECT * FROM users WHERE id  ");
                  $stat->execute();
                  $result = $stat->fetchAll();
                
              ?>
              <!-- main content end -->
              <!-- /.card-header -->
              <div class="card-body">
                <div class="mb-2">
                  <a href="add.php" class="btn btn-success">Create New</a>
                </div>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Role</th>
                      <th style="width: 40px">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                        
                    <?php
                      if($result) {
                        $i = 1;
                        foreach($result as $value) { 
                      ?>
                      <tr>
                      <td><?php echo $i ?></td>
                        <td><?php echo $value['name'] ?></td>
                        <td><?php echo $value['email'] ?></</td>
                        <td>Admin</td>
                        <td class="btn-group">
                          <div class="container">
                            <a href="edit.php?id=<?php echo $value['id'] ?>" class="btn btn-warning">Edit</a>
                          </div>
                          <div class="container">
                            <a onclick="return confirm('Are you sure?')" href="delete.php?id=<?php echo $value['id'] ?>" 
                            class="btn btn-danger">Delete</a>
                          </div>
                        </td>
                      </tr>
                      
                      <?php
                      $i++;
                        }
                      }
                    ?>
                  </tbody>
                </table>
                <?php
                if(!empty($_GET['pagno'])) {
                  $pagno = $_GET['pagno'];
                }else {
                  $pagno = 1;
                }
                $numOfrecs = 3;
                $offset = ($pagno - 1) * $numOfrecs;

                if(empty($_POST['search'])) {
                  $stat = $pdo->prepare("SELECT * FROM users ORDER BY id DESC");
                  $stat->execute();
                  $rowResult = $stat->fetchAll();
                  $total_pages = ceil(count($rowResult) / $numOfrecs);

                  $stat = $pdo->prepare("SELECT * FROM users ORDER BY id DESC LIMIT $offset, $numOfrecs");
                  $stat->execute();
                  $result = $stat->fetchAll();
                }else {
                  $searchKey = $_POST['search'];
                  $stat = $pdo->prepare("SELECT * FROM users WHERE role LIKE '%$searchKey% 'ORDER BY id DESC");
                  $stat->execute();
                  $rowResult = $stat->fetchAll();
                  $total_pages = ceil(count($rowResult) / $numOfrecs);

                  $stat = $pdo->prepare("SELECT * FROM users WHERE role LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset, $numOfrecs");
                  $stat->execute();
                  $result = $stat->fetchAll();
                }
              ?>
                <nav aria-label="Page navigation example" style="margin-top: 16px;float: right;">
                  <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                    <li class="page-item <?php if($pagno<=1) echo 'disabled'; ?>">
                      <a class="page-link" href="<?php if($pagno<=1) echo '#'; else echo '?pagno='.($pagno-1); ?>">
                        Previous</a></li>
                    <li class="page-item disabled"><a class="page-link" href="#"><?php echo $pagno ?></a></li>
                    <li class="page-item <?php if($pagno>=$total_pages) echo 'disabled'; ?>">
                    <a class="page-link" href="<?php if($pagno>=$total_pages) echo '#'; else echo '?pagno='.($pagno+1); ?>">
                      Next</a></li>
                    <li class="page-item"><a class="page-link" href="<?php echo '?pagno='.$total_pages ?>">Last</a></li>
                  </ul>
                </nav>
              </div>
              <!-- /.card-body -->
            </div>
            

  
  <?php include('footer.php') ?>


