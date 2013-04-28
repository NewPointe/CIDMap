<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        
        include 'base.php';
        
        array2csvfile(jsonRetrieve("locations.json"), "uploads/locations.csv");
        jsonStore(geocodeArray(csvfile2array('uploads/locations.csv')), 'locations.json');
  
        ?>
        <br />
        <a href="manage.php">Back to management</a>
    </body>
</html>
