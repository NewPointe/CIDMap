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
        echo 'Done!';
        ?>
        <br />
        <a <?php echo 'href="manage.php?passkey=' . $_GET['passkey'] . '"' ?>>Back to management</a>
    </body>
</html>
