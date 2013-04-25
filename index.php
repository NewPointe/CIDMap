<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>CID Map</title>
        <link rel="stylesheet" type="text/css" href="css/index.css">
        <script type="text/javascript">
        <?php
        
        $locs = file_get_contents("locations.json");
        
        echo "projectlocations = ". $locs . ";\n";
        
        ?>
        </script>
        <script type="text/javascript" src="js/index.js"></script>
    </head>
    <body onload="loadMapApi();">
        <div id="map_canvas" style="width:100%; height:100%"></div>
        <div id="logo"><img src="img/biglogo.png" width="300" /></div>
        <div id="cidlogo"><img src="img/CID.png" width="300" /></div>
    </body>
</html>
