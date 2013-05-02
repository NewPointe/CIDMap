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
                ?>
        <form enctype="multipart/form-data" <?php echo 'action="csvuploader.php?passkey=' . $passkey . '"' ?> method="POST">
            <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
            Choose a file to upload: <input name="uploadedfile" type="file" /><br />
            <input type="submit" value="Upload File" />
        </form>
        <?php
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
