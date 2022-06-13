<?php

require 'dbConnection.php';

$id = $_GET['id'];
$sql = "select id,title,content,image from blogs where id = $id";
$resultObj = mysqli_query($con, $sql);
$data = mysqli_fetch_assoc($resultObj);

$sqlImage = "select image from blogs where id = $id";
$imgResult = mysqli_query($con, $sqlImage);

while($row = mysqli_fetch_assoc($imgResult)){   
    $savedimage = $row['image'];
}



# Clean Function to sanitize the data
function Clean($input)
{
    return stripslashes(strip_tags(trim($input)));
}



# Server Side Code . . . 
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $title     = Clean($_POST['title']);
    $content   = Clean($_POST['content']);
    


    # Validate ...... 
    $errors = [];

    # validate title .... 
    if (empty($title)) {
        $errors['title'] = "Field Required";
    } elseif (!ctype_alpha(str_replace(' ', '', $title))) {
        $errors['title'] = 'title must be only letters';
    }


    # validate content 
    if (empty($content)) {
        $errors['content'] = "Field Required";
    } elseif (strlen($content) < 50) {
        $errors['content'] = "Length Must be >= 50 chars";
    }


    # Validate Image . . . 
    if (empty($_FILES['image']['name'])) {
        $errors['image'] = "Field Required";
    } else {

        # Validate Extension . . . 
        $imageType = $_FILES['image']['type'];
        $extensionArray = explode('/', $imageType);
        $extension =  strtolower(end($extensionArray));

        $allowedExtensions = ['png', 'jpg', 'jpeg', 'webp'];    // PNG 

        if (!in_array($extension, $allowedExtensions)) {

            $errors['image'] = "File Type Not Allowed";
        }
    }

      
      # Check errors 

    if(count($errors) > 0){

        foreach ($errors as $key => $value) {
            # code...
            echo $key.' : '.$value.'<br>';
        }
    }else{
        
        $finalName = uniqid() . time() . '.' . $extension;
        $disPath = 'uploads/' . $finalName;
        
        $tempName  = $_FILES['image']['tmp_name'];

        if (move_uploaded_file($tempName, $disPath)) {
            $sql = "update blogs set title='$title' content='$content',image='$finalName'";
            $op =  mysqli_query($con, $sql);

            if ($op) {
                unlink('uploads/'.$savedimage);
                echo "Success , Your Data Created";
            } else {
                echo "Failed , " . mysqli_error($con);
            }
            echo 'Your Data Saved .';
       }
}
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Blog</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <h2>Insert Data :</h2>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']).'?id='.$data['id']; ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="exampleInputTitle">Title</label>
                <input type="text" class="form-control" required id="exampleInputTitle" aria-describedby="" name="title" placeholder="Enter Title" value = "<?php echo $data['title'];?>">
            </div>

            <div class="form-group">
                <label for="exampleInputContent">Content</label>
                <input type="text" class="form-control" required id="exampleInputContent" name="content" placeholder="Enter content" value = "<?php echo $data['content'];?>">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">Image</label>
                <input type="file" name="image" value = "uploads/<?php echo $data['image'];?>">
                <img src="./uploads/<?php  echo $data['image']; ?>" height="80px" width="80px">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


</body>

</html>