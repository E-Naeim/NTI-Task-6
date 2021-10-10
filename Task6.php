<?php

require './help files/validation.php';
require './help files/dbConnection.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    /* Get user info */
    $title     =  $_POST['Title']; 
    $content =  $_POST['Content'];

    /* Validate user info */
    validate($title, 'title');
    validate($content, 'content');


    /* Validate uploaded file */
    if(!empty($_FILES['Image']['name'])){
        $file_tmp = $_FILES['Image']['tmp_name']; // temporary path
        $file_name = $_FILES['Image']['name']; // name
        $file_type = $_FILES['Image']['type']; // ex: img/png

        $allowed = ['png', 'jpeg', 'jpg']; // Allowed Extension
        $fileExtension = explode('/', $file_type); // extract the extension type from the uploaded file

            // Check if uploaded extension is allowed
            if(in_array($fileExtension[1],$allowed)){
                global $finalName;
                $finalName = 'random'.rand(1,50).'time'.time().'.'.$fileExtension[1]; // to not repeat name
                $finalPath = './uploaded/'.$finalName;
                move_uploaded_file($file_tmp, $finalPath); // (temporary path , final path)
            }
            else{
                echo 'Not a valid Image extension, only JPEG, JPG and PNG are accepted!'.'<br>';
            }
      }else{
          echo 'Image is required!'.'<br>';
      }


    /* db Code */
        $sql = "INSERT INTO `task6`(`Title`, `Content`, `Image`) VALUES ('$title','$content','$finalName')";
        $operation  =  mysqli_query($connection,$sql);

        if($operation){
        echo 'Data Inserted';
        }else{
            echo 'Error Try Again!';
        }

        # close connection ... 
        mysqli_close($connection);

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
  <div class="container">

    <form action="<?php echo $_SERVER['PHP_SELF'];?>"  method="post"  enctype ="multipart/form-data">

     <div class="form-group">
        <label for="Title">Title</label>
        <input type="text" name = "Title" id='Title' class="form-control" placeholder="Enter title">
     </div>


     <div class="form-group">
        <label for = "Content">Content</label>
        <input type="text" name = "Content" id='Content' class="form-control" placeholder="Enter any content">
     </div>


     <div class="form-group">
        <label for='Image'>Image</label>
        <input type="file" name = "Image" id='Image' class="form-control" placeholder="Upload an Image">
     </div>


     <button type="submit" class="btn btn-primary">Submit</button>

    </form>
  </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>