
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        
        include 'base.php';
        
        $upFile = $_FILES["uploadedfile"];
        
        if (verifyFileUpload($upFile)) 
        {
            if ($upFile["error"] > 0) 
            {
                echo "Return Code: " . $upFile["error"] . "<br>";
            }
            else 
            {
                echo "Upload: "    .  $upFile["name"]         .    "<br />";
                echo "Type: "      .  $upFile["type"]         .    "<br />";
                echo "Size: "      . ($upFile["size"] / 1024) . " kB<br />";
                echo "Temp file: " .  $upFile["tmp_name"]     .    "<br />";
                
                move_uploaded_file($upFile["tmp_name"], "uploads/locations.csv");
                echo "Stored in: " . "uploads/locations.csv" . "<br /><br /><br />";
               
                jsonStore(geocodeArray(csvfile2array('uploads/locations.csv')), 'locations.json');
            
            echo "Success!";
            }
        }
        else
        {
            echo "Invalid file";
        }
                
        ?>
        <br />
        <a href="manage.php">Back to management</a>
    </body>
</html>
