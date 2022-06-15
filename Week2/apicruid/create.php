<?php

require 'dbConnection.php';

# Clean Function to sanitize the data
function Clean($input)
{
    return stripslashes(strip_tags(trim($input)));
}



# Server Side Code . . . 
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $project     = Clean($_POST['project']);
    $article     = Clean($_POST['article']);
    $granularity = Clean($_POST['granularity']);
    //$timestamp   = Clean($_POST['timestamp']);
    $access      = Clean($_POST['access']);
    $agent       = Clean($_POST['agent']);
    $views       = Clean($_POST['views']);


    # Validate ...... 
    $errors = [];

    # validate project .... 
    if (empty($project)) {
        $errors['project'] = "Field Required";
    }

    # validate article .... 
    if (empty($article)) {
        $errors['article'] = "Field Required";
    }

    # validate granularity .... 
    if (empty($granularity)) {
        $errors['granularity'] = "Field Required";
    }

    # validate access .... 
    if (empty($access)) {
        $errors['access'] = "Field Required";
    }

    # validate agent .... 
    if (empty($agent)) {
        $errors['agent'] = "Field Required";
    }

    # validate views .... 
    if (empty($views)) {
        $errors['views'] = "Field Required";
    } elseif(! preg_match ("/^[0-9]*$/", $views)){
        $errors['views'] = 'views must be only numbers';
    }


    # Check ...... 
    if (count($errors) > 0) {
        // print errors .... 

        foreach ($errors as $key => $value) {
            # code...

            echo '* ' . $key . ' : ' . $value . '<br>';
        }
    } else {

        $time = time();
        // DB cODE . . . 
        $timestamp = date('Y/m/d H:i:s',$time);

        $sql = "insert into items (project,article,granularity,timestamp,access,agent,views) values ('$project','$article','$granularity','$timestamp','$access','$agent','$views')";
        $op =  mysqli_query($con, $sql);
        
        if ($op) {
            echo "Success , Your Data Added";
        } else {
            echo "Failed , " . mysqli_error($con);
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Insert Data</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <h2>Insert Data</h2>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

            <div class="form-group">
                <label for="exampleInputProject">Project</label>
                <input type="text" class="form-control" required id="exampleInputProject" aria-describedby="" name="project" placeholder="Enter Project">
            </div>

            <div class="form-group">
                <label for="exampleInputArticle">Article</label>
                <input type="text" class="form-control" required id="exampleInputArticle" aria-describedby="" name="article" placeholder="Enter Article">
            </div>

            <div class="form-group">
                <label for="exampleInputGranularity">Granularity</label>
                <input type="text" class="form-control" required id="exampleInputGranularity" aria-describedby="" name="granularity" placeholder="Enter Granularity">
            </div>

            <div class="form-group">
                <label for="exampleInputAccess">Access</label>
                <input type="text" class="form-control" required id="exampleInputAccess" aria-describedby="" name="access" placeholder="Enter Access">
            </div>

            <div class="form-group">
                <label for="exampleInputAgent">Agent</label>
                <input type="text" class="form-control" required id="exampleInputAgent" aria-describedby="" name="agent" placeholder="Enter Agent">
            </div>

            <div class="form-group">
                <label for="exampleInputViews">Views</label>
                <input type="text" class="form-control" required id="exampleInputViews" aria-describedby="" name="views" placeholder="Enter Views">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


</body>

</html>