
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
$allowedExts = array("csv");
$extension = end(explode(".", $_FILES["uploadedfile"]["name"]));
if ((($_FILES["uploadedfile"]["type"] == "text/csv")
|| ($_FILES["uploadedfile"]["type"] == "application/vnd.ms-excel")
|| ($_FILES["uploadedfile"]["type"] == "text/comma-separated-values"))
&& ($_FILES["uploadedfile"]["size"] < 20000)
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["uploadedfile"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["uploadedfile"]["error"] . "<br>";
    }
  else
    {
    echo "Upload: " . $_FILES["uploadedfile"]["name"] . "<br>";
    echo "Type: " . $_FILES["uploadedfile"]["type"] . "<br>";
    echo "Size: " . ($_FILES["uploadedfile"]["size"] / 1024) . " kB<br>";
    echo "Temp file: " . $_FILES["uploadedfile"]["tmp_name"] . "<br>";
      move_uploaded_file($_FILES["uploadedfile"]["tmp_name"],
      "uploads/locations.csv");
      echo "Stored in: " . "uploads/" . $_FILES["file"]["name"]. "<br>". "<br>". "<br>";
      
      praseCSVfile();
      
    }
  }
else
  {
  echo "Invalid file";
  }
  
  class geocoder{
    static private $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=";

    static public function getLocation($address){
        $url = self::$url.urlencode($address);
        
        $resp_json = file_get_contents($url);
        $resp = json_decode($resp_json, true);

        if($resp['status']==='OK'){
            return $resp['results'][0]['geometry']['location'];
        }else{
            return false;
        }
    }
}
  
  
  function praseCSVfile() {
  $locArr = praseCSV('uploads/locations.csv');
  
  for($i = 0; $i < count($locArr); $i++) {
      
      $address=urlencode($locArr[$i][3]);
      $loc = geocoder::getLocation($address);
$locArr[$i][1] = $loc["lat"];
$locArr[$i][2] = $loc["lng"];
  }
  file_put_contents('locations.json', json_encode($locArr));
  echo "Success!";
  
}
  function praseCSV($file) {
      
      $readline = null;
      $finalarray = array();
      
      $csvfile = fopen($file, "r");
      
      while(!feof($csvfile)) {
      $readline = fgetcsv($csvfile);
      $readlinefixed = [$readline[0], 0, 0, $readline[1], $readline[2]];
      $finalarray[] = $readlinefixed;
      }
      
      return $finalarray;
      
  }
?>
        <br />
        <a href="manage.php">Back to management</a>
    </body>
</html>
