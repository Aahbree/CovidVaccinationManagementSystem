<html>
<body>
<title><br> <br>Patient Details updated<br></title>
<center>
<h1>Patient Details updated</h1>
</center>
<center>


<?php
include 'dbconnect.php';
include 'layout/header1.php';
include 'layout/nav2.php';
// TODO 
// Need to update session variable
$pid=$_SESSION["id"];
$password1 = password_hash($_GET["psw"],PASSWORD_DEFAULT);
$query1 = "UPDATE Patient
SET
password='".$password1."'
WHERE patientId =".$pid;

if ($result1 = $conn->query($query1)) {

  
}
else
{
  echo "database updated failed";
}
?>
</body>
</html>