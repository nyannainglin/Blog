<?php
    require "../config/config.php";
    require('header.php') 

?>
<?php
$stat = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
$stat->execute();
$result = $stat->fetch(PDO::FETCH_ASSOC);
       
if(!empty($_POST)) {

    $title = $_POST['title'];
    $content = $_POST['content'];
    

    if(($_FILES['image']['name']) != null) {
        $file = '../images/'.$_FILES['image']['name'];
        $imgType = explode('.', $file)[3];

        if($imgType != 'jpg' && $imgType != 'jpeg') {
            echo "<script>alert('Image must be jpg & jpeg & png')</script>";
        }else {
            move_uploaded_file($_FILES['image']['tmp_name'], $file);
            $image = $_FILES['image']['name'];

            $stat = $pdo->prepare("UPDATE posts SET title = '$title', content = '$content', image = '$image' WHERE id=".$_GET['id']);
            $result = $stat->execute();   
        }

    } else {
        $stat = $pdo->prepare("UPDATE posts SET title = '$title', content = '$content' WHERE id=".$_GET['id']);
        $result = $stat->execute();
    }
    
    if($result) {
        echo "<script>alert('New post updated!'); location.href='index.php';</script>";
    }
}
?>




<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group mb-3">
        <label for="">Title</label>
        <input type="text" class="form-control" name="title" value="<?php echo $result['title'] ?>">
    </div>
    <div class="form-group mb-3">
        <label for="">Content</label>
        <textarea name="content" id="" cols="30" rows="10" class="form-control"><?php echo $result['content'] ?></textarea>
    </div>
    <div class="form-group mb-3">
        <label for="">Image</label>
        <img src="../images/<?php echo $result['image'] ?>" alt="" width="120" height="120">
        <input type="file" name="image" id="" class="form-control">
    </div>
    <div class="form-group mb-3">
        <input type="submit" class="btn btn-success" value="Add">
        <a href="index.php" class="btn btn-warning">Back</a>
    </div>
</form>

<?php require('footer.php') ?>