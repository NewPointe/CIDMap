<?
    header("Content-type: text/csv");
    header("Content-Disposition: attachment; filename=locations.csv");
    header("Pragma: no-cache");
    header("Expires: 0");
    
    include 'base.php';
    
    array2csvfile(jsonRetrieve("locations.json"), "php://output");
?>
