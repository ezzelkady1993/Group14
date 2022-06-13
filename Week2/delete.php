<?php 
    require 'dbConnection.php';

    $id  = $_GET['id'];
    
    $sqlImage   = "select image from blogs where id = $id";
    $imgResult  = mysqli_query($con, $sqlImage);
    
    while($row = mysqli_fetch_assoc($imgResult)){
        
        $image = $row['image'];
        $sql = "delete from blogs where id = $id"; 
        $op = mysqli_query($con, $sql);
        unlink('uploads/'.$image);
        
        if($op){
            $message =  "Record Deleted";
        }else{
            $message =  'Error Try Again' . mysqli_error($con);
        }
    }

    $sql  = "delete from blogs where id = $id"; 
    $op   = mysqli_query($con, $sql);

    if($op){
        $message =  "Record Deleted";
    }else{
        $message =  'Error Try Again' . mysqli_error($con);
    }


    # Set Message Session 
    $_SESSION['message'] = $message;

    header("Location: index.php");


    
?>