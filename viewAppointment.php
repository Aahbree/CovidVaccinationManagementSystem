<html>
<body>>

<title>Accepted Apointments<br></title>
<center>
<h2><br> <br><br>List of Accepted Apointments</h2>
</center>
<center>
<!-- //todo -->

<?php
include 'dbconnect.php';
include 'layout/header1.php';
include 'layout/navp.php';

$providerid = $_SESSION["pid"];

function display_function(&$aid,&$pid,&$a_date,&$a_starttime)
{
  echo '<tr>
  <style>
  table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
  }
  td, th {
    text-align: center; 
    background-color: 
    lightblue; border: 
    2px solid black; 
    padding: 3px; 
    width: 200px;
  }
  </style>
  <table>
  <tr>
  <td> '.htmlspecialchars($aid).'</td>
  <td> '.htmlspecialchars($pid).'</td>
  <td>'.htmlspecialchars($a_date).'</td> 
  <td>'.htmlspecialchars($a_starttime).'</td> 
  </tr>
  </table>
  </tr>';
}

function display_function2()
{
  echo '<br<br><br><tr>
  <style>
  table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 50%;
    height : 10%
  }
  td, th {
    text-align: center; 
    background-color: 
    lightblue; border: 
    4px solid black; 
    width: 200px;
    padding: 0 3px 0 0;
  }
  </style>
  <table>
  <tr>
  <td>   <b>Apointment id </td>
  <td>   <b>Patient id </td>
  <td>   <b>StartTime </td> 
  <td>   <b>Date</td> 
  </tr>
  </table>
  </tr>';
}

display_function2();

  $query1 = "SELECT ao.appointmentId,patientid,date as datee,startTime FROM appointmentOffer ao JOIN ProviderAppointment pa on ao.appointmentId=pa.appointmentId
  WHERE status='Accepted' and ao.providerId = ? order by datee";
  $stmt = $conn->prepare($query1);
  $stmt->bind_param('i', $providerid);
  $res = $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) 
  {
    while ($row = $result->fetch_assoc())
    {
    $aid=$row["appointmentId"];
	$pid=$row["patientid"];
    $a_date = $row["datee"];
    $a_starttime = $row["startTime"];
    display_function($aid,$pid,$a_date,$a_starttime);
    }
  } 
  else
  {
    echo '<p color:red;> <b>'."Apointments not yet accepted ".'</p></b>';

  }

mysqli_close($conn);
?>
<br>
<style>
.col-60 {
  float: center;
  margin: auto;
  margin-bottom: 0px;
  background-color: green;
  border: none;
  color: white;
  padding: 16px 30px;
  text-decoration: none;
  margin: 4px 2px;
  cursor: pointer;
  width: 8%;
  font-size: 15px;
}
</style>
<div class="col-50">
<div class="d-flex justify-content-center">
  <u><a class="btn btn-primary" onclick="history.back()"> Back Page</a></u>
</div>
</div>
</center>

</body>
</html>