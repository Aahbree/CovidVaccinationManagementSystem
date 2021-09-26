<html>
<body>
<title><br> <br>Provider Details updated<br></title>
<center>
<h1>Provider Details updated</h1>
</center>
<center>


<?php
include 'dbconnect.php';
include 'layout/header1.php';
include 'layout/navp.php';

$providerid = $_SESSION["pid"];
$password1 = password_hash($_GET["psw"],PASSWORD_DEFAULT);

$query1 = "UPDATE Provider
SET password='".$password1."'
WHERE providerId =".$pid;

if ($result1 = $conn->query($query1)) {

  echo "database updated succesfully";
}
else
{
  echo "database update failed";
}
?>
</body>
</html>