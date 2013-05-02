<?php

$debug = false;
if ($debug)
    echo "Debug enabled <br />";

function dlog($msg) {
    if ($GLOBALS['debug'])
        echo $msg . '<br />';
}

function jsonStore($json, $file) {
    return file_put_contents($file, json_encode($json));
}

function jsonRetrieve($file) {
    return json_decode(file_get_contents($file));
}

function csvfile2array($csvfile) {
    $finalarray = array();
    dlog('[csvfile2array]: opening read buffer on "' . $csvfile . '"');
    $inputBuffer = fopen($csvfile, "r");
    dlog('[csvfile2array]: read buffer openned');
    while (!feof($inputBuffer)) {
        $tmp = fgetcsv($inputBuffer);
        dlog('[csvfile2array]: read ' . json_encode($tmp) . ' from buffer');
        $finalarray[] = $tmp;
    }

    dlog('[csvfile2array]: reached {end of file}');

    return $finalarray;
}

function array2csvfile($json, $csvfile) {
    dlog('[array2csvfile]: opening write buffer on "' . $csvfile . '"');
    $outputBuffer = fopen($csvfile, 'w');
    dlog('[array2csvfile]: write buffer openned');
    foreach ($json as $val) {
        dlog('[array2csvfile]: writing csv line for ' . $val);
        fputcsv($outputBuffer, $val);
    }
    fclose($outputBuffer);
    dlog('[array2csvfile]: write buffer closed');
}

class geocoder {

    static private $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=";

    static public function getLocation($address) {
        dlog('[geocoder]: getting location for "' . $address . '"');

        $url = self::$url . urlencode($address);

        $resp_json = file_get_contents($url);

        dlog('[geocoder]: recieved ' . $resp_json);

        $resp = json_decode($resp_json, true);

        dlog('[geocoder]: status is "' . $resp['status'] . '"');

        if ($resp['status'] === 'OK') {
            return $resp['results'][0]['geometry']['location'];
        } else {
            return false;
        }
    }

}

function geocodeArray($locArr) {
    dlog('[geocodeArray]: attempting to geocode ' . json_encode($locArr));
    for ($i = 0; $i < count($locArr); $i++) {
        if ($locArr[$i][0] === null || $locArr[$i][0] === false) {
            dlog('[geocodeArray]: removing #' . ($i + 1) . ', it is nothing');
            array_splice($locArr, $i, 1);
        } else {
            dlog('[geocodeArray]: currently geocodeing ' . json_encode($locArr[$i]));
            switch (count($locArr[$i])) {
                case 3:
                    $tmp = [$locArr[$i][0], 0, 0, $locArr[$i][1], $locArr[$i][2]];
                    $locArr[$i] = $tmp;

                    $address = urlencode($locArr[$i][3]);
                    $loc = geocoder::getLocation($address);
                    $locArr[$i][1] = $loc["lat"];
                    $locArr[$i][2] = $loc["lng"];

                    break;
                case 5:
                    $address = urlencode($locArr[$i][3]);
                    $loc = geocoder::getLocation($address);
                    $locArr[$i][1] = $loc["lat"];
                    $locArr[$i][2] = $loc["lng"];

                    break;
                case 6:
                    if ($locArr[$i][5] === true) {
                        
                    } else {
                        $address = urlencode($locArr[$i][3]);
                        $loc = geocoder::getLocation($address);
                        $locArr[$i][1] = $loc["lat"];
                        $locArr[$i][2] = $loc["lng"];
                    }
                    break;
                default:
            }
        }
    }
    return $locArr;
}

function verifyFileUpload($theFile) {
    $allowedExts = array("csv");
    dlog('[verifyFileUpload]: allowing files ending in ' . json_encode($allowedExts));
    dlog('[verifyFileUpload]: with type == "text/csv", "application/vnd.ms-excel", "text/comma-separated-values" <br />');
    $extension = end(explode(".", $theFile["name"]));

    return ((($theFile["type"] == "text/csv")
            || ($theFile["type"] == "application/vnd.ms-excel")
            || ($theFile["type"] == "text/comma-separated-values"))
            && ($theFile["size"] < 20000)
            && in_array($extension, $allowedExts));
}

?>
