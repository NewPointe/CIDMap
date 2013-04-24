<?php

if($_POST["action"] != ""){
    

function jsonStore($json, $file){
    return file_put_contents($file, json_encode($json));
}

function jsonRetrieve($file){
    return json_decode(file_get_contents($file));
}
                    
    $locations = jsonRetrieve('locations.json');
    
    switch ($_POST["action"]) {
        case "add":
            
            jsonStore(array_merge($locations, [[$_POST["place"], 0, 0, $_POST["address"], $_POST["work"]]]), 'locations.json');
            
            break;
        case "delete":
            array_splice($locations, $_POST["id"] - 1, 1);
            jsonStore($locations, 'locations.json');
            
            break;
    }
}
if($_POST["action"] === "add" || $_POST["action"] === "delete"){
   header( 'Location: manage.php') ;
}
                    
                    $tablecontent = "";
                    
                    $locs = json_decode(file_get_contents("locations.json"));
                    $locnum = 0;
                    foreach ($locs as $loc){
                    $locnum++;
                        $tablecontent.= '<tr> <td>' . $locnum . '</td><td>' . $loc[0] .
                            '</td><td>' . $loc[1] . '</td><td>' . $loc[2] .
                            '</td><td>' . $loc[3] . '</td><td>' . $loc[4] .
                            '</td><td><br /><a href="#" onclick="' .
                            "del(" . $locnum . ');">Remove</a></td></tr>';
                    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Manage CID Data Points</title>
        <link rel="stylesheet" type="text/css" href="css/manage.css">
        <script type="text/javascript" src="js/manage.js"></script>
        <script type="text/javascript">
        
    </script>
    </head>
    <body onload="">
        <div id="main">
            <table id="rounded-corner">
                <thead>
                    <tr>
                        <th scope="col" class="rounded-left">#</th>
                        <th scope="col">Place</th>
                        <th scope="col">Lat</th>
                        <th scope="col">Lng</th>
                        <th scope="col">Address</th>
                        <th scope="col">Work</th>
                        <th scope="col" class="rounded-right"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    echo $tablecontent;
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="rounded-foot-left">#
                        </td>
                        <td>
                            <input type="text" class="fullwidth" id="place"/>
                        </td>
                        <td>--
                        </td>
                        <td>--
                        </td>
                        <td>
                            <input type="text" class="fullwidth" id="address"/>
                        </td>
                        <td>
                            <input type="text" class="fullwidth" id="work"/>
                        </td>
                        <td class="rounded-foot-right">
                            <a id="add" href="#" onclick="add();">Add</a>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div id="settings">
            <a id="settingsHead" href="#">Options:</a>
            <div id="settingscontent">
                <ul>
                    <li><a href="#">Upload .csv</a></li>
                    <li><a href="#">Download .csv</a></li>
                    <li><a href="#">Update geocodes</a></li>
                </ul>
            </div>
        </div>
    </body>
</html>
