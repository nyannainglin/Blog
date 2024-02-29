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

<?php
 $stat = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
 $stat->execute();
 $result = $stat->fetch(PDO::FETCH_ASSOC);


//  comment insert query
  if(($_POST)) {
    $content = $_POST['comment'];
    $blogId = $_GET['id'];
    $statement = $pdo->prepare("INSERT INTO comments (content, author_id, post_id) VALUES (:comment, :auhor_id,:post_id)");


    $result = $statement->execute(
        array(
            ':comment' => $content,
            ':auhor_id' => $_SESSION['user_id'],
            ':post_id' => $blogId
        )
    );
    if($result) {
      header('location: blogdetail.php?id='.$blogId);
    }
  }

  // comment retrive query
  $stat = $pdo->prepare("SELECT * FROM comments WHERE post_id=".$_GET['id']);
  $stat->execute();
  $cmresult = $stat->fetchAll();
  $cmCount = count($cmresult);
  
  
  




?>
<div class="wrapper" >
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left:0;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-body">
                <img class="img-fluid pad d-block mx-auto" src="images/<?php echo $result['image'] ?>" alt="Photo">
                <p class="mt-3"><?php echo $result['content'] ?></p>
              </div>
              <!-- /.card-body -->

              <div class="card-footer card-comments">
                <div class="card-comment">
                  <div class="comment-text" style="margin-left: 0;">
                    <a href="index.php" class="btn btn-warning my-3">Back</a>
                    <h5><span style="padding-right: 6px;"><?php echo $cmCount ?></span>Comments 
                    </h5>
                       <?php
                         if($cmresult) {
                          foreach($cmresult as $cm){
                              //  author retrive 
                                // $author = $cm['author_id'];

                                
                          ?>
                          <?php
                            $authorId = $cm['author_id'];
                            $austat = $pdo->prepare("SELECT * FROM users WHERE id=$authorId");
                            $austat->execute();
                            $auresult = $austat->fetch(PDO::FETCH_ASSOC);
                          ?>
                          <span class="username">
                            <?php echo $auresult['name'] ?>
                          </span>
                          <span class="text-muted float-right">
                            <?php echo $cm['created_at'] ?></span>
                          </span>
                          <p><?php echo $cm['content'] ?></p>
                        
                          <?php
                          }
                         }
                       ?>
                  </div>
                  <!-- /.comment-text -->
                </div>
                <!-- /.card-comment -->
              </div>
              <!-- /.card-footer -->
              <div class="card-footer">
                <form action="" method="post">
                  <div class="img-push">
                    <input name="comment" type="text" class="form-control form-control-sm" placeholder="Press enter to post comment">
                  </div>
                </form>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer" style="margin-left: 0 !important;">
    <div class="float-right d-none d-sm-block">
      <a href="logout.php" class="btn btn-default">Logout</a>
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
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
