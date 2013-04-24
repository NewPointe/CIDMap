<?php

function jsonStore($json, $file){
    return file_put_contents($file, json_encode($json));
}

function jsonRetrieve($file){
    return json_decode(file_get_contents($file));
}


?>
