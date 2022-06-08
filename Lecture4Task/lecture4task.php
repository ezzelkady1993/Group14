<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // CODE .... 

    $name       = $_POST['name'];
    $email      = $_POST['email'];
    $password   = $_POST['password'];
    $address    = $_POST['address'];
    $gender     = $_POST['gender'];
    $linkedurl  = $_POST['linkedurl'];
    $cv         = $_POST['cv'];

    // Array To Store Errors Messages . . . 
    $errors = []; 

    # validate name . . .
    if (empty($name)) {  
        $errors['name'] = 'Field is Required';
    }elseif (!ctype_alpha(str_replace(' ', '', $name))) {
        $errors['name'] = 'Name must be only letters';
    }

    # validate email . . .
    if (empty($email)) {
        $errors['email'] = 'Field is Required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid Email';
    }

    # Validate password . . . 
    if (empty($password)) {
        $errors['password'] = 'Field is Required';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Password must be at least 6 characters';
    }

    # Validate address . . . 
    if (empty($address)) {
        $errors['address'] = 'Field is Required';
    } elseif (strlen($address) != 10) {
        $errors['address'] = 'address must be 10 characters';
    }

    # Validate gender . . . 
    if (empty($gender)) {
        $errors['gender'] = 'Field is Required';
    }

    # Validate linkedurl . . . 
    if(empty($linkedurl)){
        $errors['linkedurl'] = 'Field is Required';
    } elseif(substr_compare($linkedurl,'https://www.linkedin.com/',0,25) != FALSE){
        $errors['linkedurl'] = 'not a linkedin link';
    }
    
    if (!empty($_FILES['cv']['name'])) {

        $tempName  = $_FILES['cv']['tmp_name'];
        $cvName    = $_FILES['cv']['name'];
        $cvType    = $_FILES['cv']['type'];

        $extensionArray = explode('/', $cvType);
        $extension =  strtolower( end($extensionArray));

        $allowedExtensions = ['pdf'];    

        if (in_array($extension, $allowedExtensions)) {

            $finalName = uniqid() . time() . '.' . $extension;

            $disPath = 'Lecture4Task/' . $finalName;

            if (move_uploaded_file($tempName, $disPath)) {
                echo 'File Uploaded Successfully';
            } else {
                $errors['cv'] = 'File Uploaded Failed';
            }
        } else {
            $errors['cv'] = 'File Type Not Allowed';
        }
    } else {
        $errors['cv'] = 'Please Select File';
    }


      
      # Check errors 

       if(count($errors) > 0){

           foreach ($errors as $key => $value) {
               # code...
               echo $key.' : '.$value.'<br>';
           }
       }else{
              echo 'Success';
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
        <h2>Register</h2>
        <!-- action.php -->
        <form method="post" action="<?php echo  htmlspecialchars($_SERVER['PHP_SELF']); ?>">

            <div class="form-group">
                <label for="exampleInputName">Name</label>
                <input type="text" class="form-control" name="name" id="exampleInputName" aria-describedby="" placeholder="Enter Name">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail">Email address</label>
                <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">Password</label>
                <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
            </div>

            <div class="form-group">
                <label for="exampleInputAddress">Address</label>
                <input type="text" class="form-control" name="address" id="exampleInputAddress" aria-describedby="" placeholder="Enter Address">
            </div>
            
            <div class="form-group">
                <input type="radio" id="male" name="gender" value="Male">
                <label for="male">Male</label><br>
                <input type="radio" id="female" name="gender" value="Female">
                <label for="female">Female</label><br>
            </div>

            <div class="form-group">
                <label for="exampleInputURL">LinkedIn URL</label>
                <input type="text" class="form-control"  name="linkedurl"  id="exampleInputURL" placeholder="LinkedIn URL">
            </div>

            <div class="form-group">
                <label for="exampleInputCV">CV</label>
                <input id="exampleInputCV" type="file" name="cv">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</body>

</html>