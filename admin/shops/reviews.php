
<?php
error_reporting(0);
 
$msg = "";
 
// If upload button is clicked ...
if (isset($_POST['upload'])) {
    die(print_r($_FILES));
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = date("Ymd");
    mkdir ($folder, 0755);
    $folder2 = "./" . $folder . "/" . $filename;
 
    $db = mysqli_connect("localhost", "root", "", "uts_db");
 
    // Get all the submitted data from the form
    $sql = "INSERT INTO image (filename) VALUES ('$filename')";
 
    // Execute query
    mysqli_query($db, $sql);
 
    // Now let's move the uploaded image into the folder: image
    if (move_uploaded_file($tempname, $folder2)) {
        echo "<h3>  Image uploaded successfully!</h3>";
    } else {
        echo "<h3>  Failed to upload image!</h3>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Image Upload</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        #content {
            width: 50%;
            justify-content: center;
            align-items: center;
            margin: 20px auto;
            border: 1px solid #cbcbcb;
        }

        form {
            width: 50%;
            margin: 20px auto;
        }

        #display-image {
            width: 100%;
            justify-content: center;
            padding: 5px;
            margin: 15px;
        }

        img {
            margin: 5px;
            width: 350px;
            height: 250px;
        }
    </style>
</head>

<body>
    <div id="content">
        <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group row">
                            <label for="driver_Phone" class="col-sm-2 col-form-label">Phone</label>
                            <div class="col-sm-10">
                                <input type="tel" oninput="numberOnly(this.id);" pattern=".{10}" class="form-control"
                                    id="driver_Phone" name="driver_Phone" placeholder="10-Digits Phone Number (Optional)">
                            </div>
                        </div>
            <div class="form-group">
                <input class="form-control" type="file" name="uploadfile" value="" />
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit" name="upload">UPLOAD</button>
            </div>
        </form>
    </div>
    <div id="display-image">
        <?php
        $query = " select * from image ";
        $result = mysqli_query($db, $query);

        while ($data = mysqli_fetch_assoc($result)) {
            ?>
            <img src="<?php echo "./" . $folder . "/" . $data['filename']; ?>">

            <?php
        }
        ?>
    </div>
</body>

</html>