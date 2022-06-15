<?php

    require('dbConnection.php');

    function Clean($input)
    {
        return stripslashes(strip_tags(trim($input)));
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $str = file_get_contents(Clean($_POST['apiData']));
        $arrData = json_decode($str, true);

        
        //echo '<pre>' . print_r($arrData, true) . '</pre>';
        //print_r($arrData['items'][0]['project']);
        //echo count($arrData['items']);
        if($arrData != null){
            for($i=0 ; $i < count($arrData['items']) ; $i++){
                $project     = $arrData['items'][$i]['project'];
                $article     = $arrData['items'][$i]['article'];
                $granularity = $arrData['items'][$i]['granularity'];
                $timestamp   = date('Y/m/d H:i:s',$arrData['items'][$i]['timestamp']);
                $access      = $arrData['items'][$i]['access'];
                $agent       = $arrData['items'][$i]['agent'];
                $views       = $arrData['items'][$i]['views'];

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
                
                    $sql = "insert into items (project,article,granularity,timestamp,access,agent,views) values ('$project','$article','$granularity','$timestamp','$access','$agent','$views')";
                    $op =  mysqli_query($con, $sql);

                    if ($op) {
                        // echo "Success , Your Account Created";
                    } else {
                        echo "Failed , " . mysqli_error($con);
                    }
                }
            }
        }
    }

    $data = "select * from items";
    $resultData = mysqli_query($con, $data);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Read Records</title>

    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

    <!-- custom css -->
    <style>
        .m-r-1em {
            margin-right: 1em;
        }

        .m-b-1em {
            margin-bottom: 1em;
        }

        .m-l-1em {
            margin-left: 1em;
        }

        .mt0 {
            margin-top: 0;
        }
    </style>

</head>

<body>
    <div class="container">
        <h2>Search</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

            <div class="form-group">
                <label for="apiData">Api</label>
                <input type="text" class="form-control" name="apiData" placeholder="Enter Your Link">
            </div>

            <button type="search" class="btn btn-primary">Reveal</button>
        </form>
    </div>

    <!-- container -->
    <div class="container">


        <div class="page-header">
            <h1>Read Data </h1>
            <br>
    
        </div>

        <a href="">+ Blog Data</a>

        <table class='table table-hover table-responsive table-bordered'>
            <!-- creating our table heading -->
            <tr>
                <th>ID</th>
                <th>Project</th>
                <th>Article</th>
                <th>Granularity</th>
                <th>Timestamp</th>
                <th>Access</th>
                <th>Agent</th>
                <th>Views</th>
                <th>Action</th>
            </tr>
            
            <?php 
                while($raw = mysqli_fetch_assoc($resultData)){
            ?>
                <tr>
                    <td><?php  echo $raw['id'];  ?></td>
                    <td><?php  echo $raw['project'];  ?></td>
                    <td><?php  echo $raw['article'];  ?></td>
                    <td><?php  echo $raw['granularity'];  ?></td>
                    <td><?php  echo $raw['timestamp'];  ?></td>
                    <td><?php  echo $raw['access'];  ?></td>
                    <td><?php  echo $raw['agent'];  ?></td>
                    <td><?php  echo $raw['views'];  ?></td>
                    <td>
                        <a href='delete.php?id=<?php  echo $raw['id'];  ?>' class='btn btn-danger m-r-1em'>Delete</a>
                        <a href='edit.php?id=<?php  echo $raw['id'];  ?>' class='btn btn-primary m-r-1em'>Edit</a>
                    </td>
                </tr>
            <?php } ?>
            <!-- end table -->
        </table>

    </div>
    <!-- end .container -->


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <!-- Latest compiled and minified Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- confirm delete record will be here -->

</body>

</html>