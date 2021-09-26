<html>
<body>

<!-- TODO
Check for existing email id's before insertion -->

<?php
include("dbconnect.php");
$err = "I hope you are having a good day :)";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $HTML_Name= $_POST["Name"];
    $HTML_PType= $_POST["PType"];
    $HTML_Phone_Number= $_POST["Phone"];
    $HTML_Address= $_POST["Address"];
    $HTML_State= $_POST["State"];
    $HTML_City= $_POST["City"];
    $HTML_PIN = $_POST["Pincode"];
    $HTML_Email = $_POST["Email"];
    $HTML_Password= $_POST["Password"];
}

$password1 = password_hash($_POST['Password'],PASSWORD_DEFAULT);


// api key : converting address into latitude and longitude
$address1 = $HTML_Address.", ".$HTML_City.", ".$HTML_State." ".$HTML_PIN;
$api_key = "AIzaSyBlriAaOMXyugBr1q3bNJ90FcXhJrGyWYc";
$address = str_replace(" ", "+", $address1);
$json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&key=$api_key"); 
$json = json_decode($json);


$providerLatitude = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
$providerLongitude = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};


$query1 = "INSERT INTO `Provider` ( 
  `providerName`,
  `providerType`,
  `phone`,
  `address`,
  `city`	,
  `state`,
  `pin`,
  `latitude`,
  `longitude`,
  `email`,
  `password`
  ) VALUES   
( '$HTML_Name', '$HTML_PType', '$HTML_Phone_Number', '$HTML_Address', '$HTML_City', 
'$HTML_State','$HTML_PIN','$providerLatitude','$providerLongitude', '$HTML_Email',
 '$password1')";

if ($result1 = $conn->query($query1)) {

  header("location: plogin.php");
}
else
{
  echo "dbms error";
}
?>

</body>
</html>
