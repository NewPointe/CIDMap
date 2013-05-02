<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include 'base.php';

        $passkey = md5('thepasskey');

        if (isset($_GET['passkey'])) {
            if ($_GET['passkey'] == $passkey) {

                $upFile = $_FILES["uploadedfile"];

                if (verifyFileUpload($upFile)) {
                    if ($upFile["error"] > 0) {
                        echo "Return Code: " . $upFile["error"] . "<br>";
                    } else {
                        echo "Upload: " . $upFile["name"] . "<br />";
                        echo "Type: " . $upFile["type"] . "<br />";
                        echo "Size: " . ($upFile["size"] / 1024) . " kB<br />";
                        echo "Temp file: " . $upFile["tmp_name"] . "<br />";

                        move_uploaded_file($upFile["tmp_name"], "uploads/locations.csv");
                        echo "Stored in: " . "uploads/locations.csv" . "<br /><br /><br />";

                        jsonStore(geocodeArray(csvfile2array('uploads/locations.csv')), 'locations.json');

                        echo "Success!";
                    }
                } else {
                    echo "Invalid file";
                }
            } else {
                ?>
                <form method="get" onsubmit="getById('passkey').value = md5(getById('passkey').value);">
                    Pass: <input id="passkey" type="password" name="passkey" /><br />
                    <input type='submit' />
                </form>
                <?php
            }
        } else { //IF THE FORM WAS NOT SUBMITTED
//SHOW FORM
            ?>
            <form method="get" onsubmit="getById('passkey').value = md5(getById('passkey').value);">
                Pass: <input id="passkey" type="password" name="passkey" /><br />
                <input type='submit' />
            </form>
            <?php
        }
        ?>

        <br />
        <a <?php echo 'href="manage.php?passkey=' . $_GET['passkey'] . '"' ?>>Back to management</a>
    </body>
</html>
