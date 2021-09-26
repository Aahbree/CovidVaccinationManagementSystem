<html>
<body>
<title><br> <br>Patient Details updated<br></title>
<center>
<h1>Patient Details updated</h1>
</center>
<center>


<?php
include 'dbconnect.php';
include 'layout/nav2.php';

$pid=$_SESSION["id"];



function display_function(&$patientName,&$dob,&$phone,&$state,&$city,$pin,&$Max_distance,$value)
{
  echo $value;
  echo '<tr>
  <style>
  input[type=text]{
    width: 50%;
    padding: 5px 12px 5px 20px;
    border: 1px solid #ccc;
    border-radius: 3px;
    resize: vertical;
    background-color: lightgrey;
    text-align: left;
    font-size: 15px;
  }
  
  label {
   padding: 5px 12px 5px 0;
    display: inline-block;
    width: 8%;
    margin-left: 0%;
    border: 1px solid #ccc;
    border-radius: 1px;
    resize: vertical;
    text-align: right;
    font-size: 15px;
  }
  </style>
  <form action="Song.php" method="post">
  <div class="row">
  <label for="Name">Name</label>
  <input type="text" name=patientName value="'.$patientName.'" style="width: 250px;" readonly />
  <br/>
  <label>Date of birth</label>
  <input type="text" name="dob" value="'.$dob.'" style="width: 250px;" readonly />
  <br/>
  <label>Phone number</label>
  <input type="text" name="phone" value="'.$phone.'" style="width: 250px;" readonly />
  <br/>
  <label>State</label>
  <input type="text" name="state" value="'.$state.'" style="width: 250px;" readonly />
  <br/>
  <label>City</label>
  <input type="text" name="city" value="'.$city.'" style="width: 250px;" readonly >
  <br/>
  <label>Pincode</label>
  <input type="text" name="pin" value="'.$pin.'" style="width: 250px;" readonly >
  <br/>
  <label>Max Distance</label>
  <input type="text" name="Max_distance" value="'.$Max_distance.'" style="width: 250px;" readonly >
  <br/>
  </div >
  </form>
  <br>
  </tr>';
}

$query = "SELECT * FROM Patient WHERE patientId = $pid";
if (($result = $conn->query($query))&&($result->num_rows > 0)) 
{

    while ($row = $result->fetch_assoc()) 
    {
        $patientName = $row["patientName"];
        $dob = $row["dob"];
        $phone = $row["phone"];
        $address = $row["address"];
        $state = $row["state"];
        $city = $row["city"];
        $pin = $row["pin"];
        $email = $row["email"];
        $password = $row["password"];
        $Max_distance = $row["max_distance"];
        $Priority = $row["priority"];

    }
  }
else
  {
        echo'<h1>'."There are no patients of ID =  ".$pid.'<h1/>';
  }

$value = "OLD Details";
display_function($patientName,$dob,$phone,$state,$city,$pin,$Max_distance,$value );

// getting values from HTML Side
$HTML_Name= $_GET["Name"];
$HTML_Phone_Number= $_GET["Phone"];
$HTML_Address= $_GET["Address"];
$HTML_dob= $_GET["dob"];
if (isset($_GET['State'])) {
	$HTML_State= $_GET["State"];
}
$HTML_City= $_GET["City"];
$HTML_PIN = $_GET["pincode"];
$HTML_Max_Distance= $_GET["Max"];


// checking if the values are empty or not
// Updating values which are not empty
if(empty($HTML_Name)) { $patientName = $patientName; } else{ $patientName = $HTML_Name;}
if(empty($HTML_Phone_Number)) { $phone = $phone; } else{ $phone = $HTML_Phone_Number;}
if(empty($HTML_Address)) { $address = $address; } else{ $address = $HTML_Address;}
if(empty($HTML_dob)) { $dob = $dob; } else{ $dob = $HTML_dob;}
if(empty($HTML_State)) { $state = $state; } else{ $state = $HTML_State;}
if(empty($HTML_City)) { $city = $city; } else{ $city = $HTML_City;}
if(empty($HTML_PIN)) { $pin = $pin; } else{ $pin = $HTML_PIN;}
if(empty($HTML_Max_Distance)) { $Max_distance = $Max_distance; } else{ $Max_distance = $HTML_Max_Distance;}


$query1 = "UPDATE Patient
SET
patientName = '$patientName',
dob = '$dob',
phone = $phone,
address = '$address',
state = '$state',
city = '$city',
pin = '$pin',
max_distance  = $Max_distance
WHERE patientId =".$pid;

if ($result1 = $conn->query($query1)) {

  //echo "database updated succesfully";
}
else
{
  echo "database updated failed";
}

$value = "New Details";
display_function($patientName,$dob,$phone,$state,$city,$pin,$Max_distance,$value );

mysqli_close($conn);
?>


<style>
.col-50 {
  float: left;
  margin-bottom: 50px;
  margin-left: 45%;
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: black;
  border-radius: 4px;
  cursor: pointer;
  text-align: left;

}
</style>

</center>

</body>
</html>