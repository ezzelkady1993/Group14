<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // CODE .... 

    $title       = $_POST['title'];
    $content     = $_POST['content'];
    $image       = $_POST['image'];

    // Array To Store Errors Messages . . . 
    $errors = []; 

    # validate title . . .
    if (empty($title)) {  
        $errors['title'] = 'Field is Required';
    }elseif (!ctype_alpha(str_replace(' ', '', $title))) {
        $errors['title'] = 'title must be only letters';
    }


    # Validate content . . . 
    if (empty($content)) {
        $errors['content'] = 'Field is Required';
    } elseif (strlen($content) <= 50) {
        $errors['content'] = 'content must be greater than 50 characters';
    }

    
    if (!empty($_FILES['image']['name'])) {

        $tempName  = $_FILES['image']['tmp_name'];
        $imageName    = $_FILES['image']['name'];
        $imageType    = $_FILES['image']['type'];

        $extensionArray = explode('/', $imageType);
        $extension =  strtolower( end($extensionArray));

        $allowedExtensions = ['png', 'jpg', 'jpeg', 'webp'];    

        if (in_array($extension, $allowedExtensions)) {

            $finalName = uniqid() . time() . '.' . $extension;

            $disPath = 'uploads/' . $finalName;

            if (move_uploaded_file($tempName, $disPath)) {
                echo 'File Uploaded Successfully';
            } else {
                $errors['image'] = 'File Uploaded Failed';
            }
        } else {
            $errors['image'] = 'File Type Not Allowed';
        }
    } else {
        $errors['image'] = 'Please Select File';
    }


      
      # Check errors 

       if(count($errors) > 0){

           foreach ($errors as $key => $value) {
               # code...
               echo $key.' : '.$value.'<br>';
           }
       }else{
            $_SESSION['blogData'] = [
                'title' => $title,
                'content' => $content,
                'image' => $image
        ];

        $file = fopen('info.txt', 'a') or die('Unable to open file!');

        $text = time().rand(1,30)."||".$title . "||" . $content . "||" . $image . "\n";

        fwrite($file, $text);

        fclose($file);


        echo 'Your Data Saved .';
       }
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <h2>Blog </h2>
        <!-- action.php -->
        <form method="post" action="<?php echo  htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">

            <div class="form-group">
                <label for="exampleInputTitle">Title</label>
                <input type="text" class="form-control" name="title" id="exampleInputTitle" aria-describedby="" placeholder="Enter Title">
            </div>

            <div class="form-group">
                <label for="exampleInputContent">Content</label>
                <input type="text" class="form-control" name="content" id="exampleInputContent" placeholder="Enter Content">
            </div>

            <div class="form-group">
                <label for="exampleInputImage">Image</label>
                <input id="exampleInputImage" type="file" name="image">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</body>

</html>