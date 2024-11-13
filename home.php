<?php
session_start();
include("db.php");

if($_SERVER["REQUEST_METHOD"] == "POST"&& isset($_POST['content'])) {
    $username = $_SESSION['username'];
    $content = $_POST['content'];

    $folderDir="images/";
    $imagepath= null;
    $upStat = true;

    if(isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK){
        $exactFileDir = $folderDir . basename($_FILES['image']['name']);
    
        if($_FILES['image']['size']>200000000000){
            $message="File is too Large";
            $upStat = false;
        }

        if($upStat){
            if(move_uploaded_file($_FILES['image']['tmp_name'],$exactFileDir)){
                $imagepath=$exactFileDir;
            }else{
                $message = 'Image uploadd failed';
                $upStat = false;
            }
        }
    }

    if($upStat){
        if($imagepath){
            $sql = "INSERT INTO posts (username,content,image_path) VALUES ('$username','$content','$imagepath')";
        }else{
            $sql = "INSERT INTO posts (username,content) VALUES ('$username','$content')";
        }

        if ($conn->query($sql)===TRUE) {
            $message = "Post made succcesfully";
        } else {
            $message = "Posting failed";
        } 
    }
}

if($_SERVER["REQUEST_METHOD"] =="POST" && isset($_POST['delete_post_id'])){
    $post_id= $_POST['delete_post_id'];

    $sql="DELETE FROM posts WHERE id='$post_id'";

    if($conn->query($sql)===TRUE){
        $message = "Delete Successful";
    }
}

$postsql="SELECT * FROM posts";
$postresults=$conn->query($postsql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POSTS</title>
</head>
<body>
    <h1>POSTS</h1>
    <?php if(isset($message)): ?>
       <p1> <?php echo $message ?></p1>
    <?php endif; ?>

        <form method="post" action="home.php" enctype="multipart/form-data">
            Post Content: <input type="text" name="content" required><br>
            Upload Image: <input type="file" name="image" accept=".jpg"><br>
            <input type="submit" value="POST">
        </form>
        <form action="logout.php">
            <input type="submit" value="LOGOUT">
        </form>

    <?php  while($post=$postresults->fetch_assoc()):?>
        <p>
        
            <b><?php echo $post['username'] ?></b><br><?php echo $post['content'] ?><br>
                <?php  if(!empty($post['image_path'])):    ?>
                    <img src="<?php echo $post['image_path']?>" alt="Post Image" style="max-width:300px">
                <?php endif; ?>
            <form method="post" action="home.php" style="display:inline;">
                <input type="hidden" name="delete_post_id" value="<?php echo $post['id']; ?>">
                <input type="submit" value="DELETE">
            </form>
        
        </p>
    <?php    endwhile;  ?>


</body>
</html>