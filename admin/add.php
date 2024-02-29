<?php
    require "../config/config.php";
    require('header.php') 

?>
<?php
    if(!empty($_POST)) {

        $file = '../images/'.$_FILES['image']['name'];
        $imgType = explode('.', $file)[3];
        

        

        if($imgType != 'jpg' && $imgType != 'jpeg' && $imgType != 'png') {
            echo "<script>alert('Image must be jpg & jpeg & png')</script>";
        }else {
            move_uploaded_file($_FILES['image']['tmp_name'], $file);

            $title = $_POST['title'];
            $content = $_POST['content'];
            $image = $_FILES['image']['name'];

            $statement = $pdo->prepare("INSERT INTO posts (title, content, image, author_id) VALUES (:title, :content, :image, :author_id)");

            $result = $statement->execute(
                array(
                    ':title' => $title,
                    ':content' => $content,
                    ':image' => $image,
                    ':author_id' => $_SESSION['user_id']
                )
            );
            
            if($result) {
                echo "<script>alert('New post added!');location.href='index.php';</script>";
            }
        }
    }
?>




<form action="add.php" method="post" enctype="multipart/form-data">
    <div class="form-group mb-3">
        <label for="">Title</label>
        <input type="text" class="form-control" name="title" required>
    </div>
    <div class="form-group mb-3">
        <label for="">Content</label>
        <textarea name="content" id="" cols="30" rows="10" class="form-control" required></textarea>
    </div>
    <div class="form-group mb-3">
        <label for="">Image</label>
        <input type="file" name="image" id="" class="form-control">
    </div>
    <div class="form-group mb-3">
        <input type="submit" class="btn btn-success" value="Add">
        <a href="index.php" class="btn btn-warning">Back</a>
    </div>
</form>

<?php require('footer.php') ?>