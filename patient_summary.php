<html>
<body>
<br>

<title>Apointments Summary<br></title>
<center>
<h1>Apointments Summary</h1>
</center>
<center>

<?php
include 'dbconnect.php';
include 'layout/nav2.php';
$patientid = $_SESSION["id"];

function display_function(&$a,&$b,&$c,&$d,&$e,&$f)
{
  echo '<tr>
  <style>
  table {

    border-collapse: collapse;
    width: 90%;
    margin : auto;
  }
  td{
    text-align: center; 
    background-color: 
    lightblue; border: 
    display: inline-block;
    margin-top:5px;
    padding: 12px;

  }
  </style>
  <table>
  <tr>
  <td>   <b>Apointment id </td>
  <td>   <b>Provider Name </td> 
  <td>   <b>Provider Address </td> 
  <td>   <b>Apointment Date</td> 
  <td>   <b>Apointment Time</td>
  <td>   <b>Status</td> 
  <br>
  </tr>
  <tr>
  <td>'.htmlspecialchars($a).'</td>
  <td> '.htmlspecialchars($b).'</td>
  <td> '.htmlspecialchars($c).'</td>
  <td>'.htmlspecialchars($d).'</td> 
  <td>'.htmlspecialchars($e).'</td> 
  <td>'.htmlspecialchars($f).'</td>
  </tr>
  </table>
  </tr>';
}


$query1 = "SELECT AppointmentOffer.appointmentId as a_id ,
AppointmentOffer.status as a_status,
AppointmentOffer.patientId as patient_id,
AppointmentOffer.providerid as provider_id,
ProviderAppointment.date as a_date,
Provider.providerName as po_name,
Provider.address as po_address,
Provider.city as po_city,
Provider.state as po_state,
Provider.pin as po_pin,
ProviderAppointment.startTime as po_stime
FROM AppointmentOffer 
JOIN Provider join ProviderAppointment
WHERE AppointmentOffer.providerid = Provider.providerId 
and patientid = ? 
and AppointmentOffer.appointmentId = ProviderAppointment.appointmentId ";
  $stmt = $conn->prepare($query1);
  $stmt->bind_param('i', $patientid);
  $res = $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0)  
  {
    while ($row = $result->fetch_assoc())
    {
    $a_id=$row["a_id"];
    $po_name=$row["po_name"];

    $po_address=$row["po_address"];
    $po_city=$row["po_city"];
    $po_state=$row["po_state"];
    $po_pin=$row["po_pin"];
    $po_address_full= $po_address.''.$po_city." ".$po_state." ".$po_pin;

    $a_date=$row["a_date"];
    $a_stime= $row["po_stime"];
    $a_status=$row["a_status"];
    $_SESSION["aid"] = $a_id;
    display_function($a_id,$po_name,$po_address_full,$a_date,$a_stime,$a_status);
    }
  } 
  else
  {
    echo '<p color:red;> <b><h3>'."Please confirm your apointments in book appointments page".'</p></b></h3>';
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


<div class="col-60">
  <u><a class="btn btn-primary" onclick="history.back()"> Back Page </a></u>
</div>
</center>

</body>
</html>

