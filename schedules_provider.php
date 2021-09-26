<html>
<body>

<!-- TODO
Check for existing email id's before insertion -->
<!-- providerid  update provider id based on sesssion -->

<?php
include("dbconnect.php");
include 'layout/header1.php';
include 'layout/navp.php';

$providerid = $_SESSION["pid"];
$err = "I hope you are having a good day :)";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

foreach($_POST['pslots'] as $value)
{
$dt = new DateTime($value);
$date = $dt->format('m/d/Y');
$time = $dt->format('H:i:s');
$newDate = date("Y-m-d", strtotime($date));  
}


$query1 = "INSERT INTO ProviderAppointment(`providerId`,`date`,`startTime`,`isAvailable`) VALUES 
('$providerid', '$newDate', '$time', True)";

if ($result1 = $conn->query($query1)) 
{
  header("location: welcomep.php");
}
else
{
  echo "dbms error";
}

}

?>

</body>
</html>
