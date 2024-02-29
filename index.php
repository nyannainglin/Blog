<?php
  session_start();
  require 'config/config.php';
  

  if(empty($_SESSION['user_id']) && empty($_SESSION['singged_in'])) {
    
    header('location: login.php');
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Widgets</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper" >
    <?php
      $stat = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
      $stat->execute();
      $result = $stat->fetchAll();
    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="margin-left:0;">
      <section class="content-header">
        <div class="container-fluid">
          <h1 class="my-3">Blogs</h1>
          <div class="row">
          <?php
                      if($result) {
                        $i = 1;
                        foreach($result as $value) {
                      ?>
                      <div class="col-md-4">
                        <div class="card card-widget">
                          <div class="card-header">
                            <h4 class="text-center"><?php echo $value['title'] ?></h4>
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body">
                            <a href="blogdetail.php?id=<?php echo $value['id'] ?>">
                            <img class="img-fluid pad d-block mx-auto" src="images/<?php echo $value['image'] ?>" alt="" style="height: 200px;width:auto" ></a>
                          <!-- /.card-body -->
                          </div>
                        </div>
                      </div>
                      <?php
                        }
                      }
                    ?>

           <div class="col-md-4">
              
            </div>
            <!-- /.card -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer" style="margin-left: 0 !important;border:none;">
      <div class="float-right d-none d-sm-block">
        <a href="logout.php" class="btn btn-default">Logout</a>
      </div>
      <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>
  <!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
