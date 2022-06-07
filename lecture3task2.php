<?php 


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // CODE .... 

    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $linkedurl = $_POST['linkedurl'];
   
    // Array To Store Errors Messages . . . 
    $errors = []; 

    # validate name . . .
    if(empty($name)){    // == if(empty($name) == true)
        $errors['name'] = 'Field is Required';
    } 

    if(strlen($name) < 3 || strlen($name) > 20){
        $errors['name'] = 'String length less than 3 or greater than 20';
    }

    if(preg_match("/^[a-zA-Z]/", $name) != 1){
        $errors['name'] = 'Name has a numeric value';
    }

    # validate email . . .
    if(empty($email)){
        $errors['email'] = 'Field is Required';
    }

    # Validate linkedurl . . . 
    if(empty($linkedurl)){
        $errors['linkedurl'] = 'Field is Required';
    }

    if(substr_compare($linkedurl,'https://www.linkedin.com/',0,25) != FALSE){
        $errors['linkedurl'] = 'not a linkedin link';
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
        <form  method="post"  action="<?php echo $_SERVER['PHP_SELF'];?>">

            <div class="form-group">
                <label for="exampleInputName">Name</label>
                <input type="text" class="form-control"   name="name"  id="exampleInputName" aria-describedby="" placeholder="Enter Name">
            </div>


            <div class="form-group">
                <label for="exampleInputEmail">Email address</label>
                <input type="email" class="form-control" name="email"  id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
            </div>

            <div class="form-group">
                <label for="exampleInputURL">LinkedIn URL</label>
                <input type="text" class="form-control"  name="linkedurl"  id="exampleInputURL" placeholder="LinkedIn URL">
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</body>

</html>