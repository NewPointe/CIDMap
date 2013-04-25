<?

    function outputCSV($data) {
        $outputBuffer = fopen("php://output", 'w');
        foreach($data as $val) {
            fputcsv($outputBuffer, $val);
        }
        fclose($outputBuffer);
    }
    
    header("Content-type: text/csv");
    header("Content-Disposition: attachment; filename=locations.csv");
    header("Pragma: no-cache");
    header("Expires: 0");

    outputCSV(json_decode(file_get_contents("locations.json")));
?>
