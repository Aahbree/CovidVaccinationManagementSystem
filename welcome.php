<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
include 'dbconnect.php';
include 'layout/header1.php';
include 'layout/nav2.php';
$pid=$_SESSION["id"];

$patientname = "";

$query = "SELECT * FROM Patient WHERE patientId = $pid";
if (($result = $conn->query($query))&&($result->num_rows > 0)) 
{
    while ($row = $result->fetch_assoc()) 
    {
        $patientname = $row["patientName"];
    }
}
else
{
        echo'<h1>'."ID not found ".'<h1/>';
 }

?>
<div class="card-1" >
        <div class="card-body">
			<h1 class="card-title">Covid-19 Vaccination Management System</h1>
            <h4 class="card-text">Welcome <?php echo htmlspecialchars($patientname);?></h4>
                   
            
            <a href="patient_book_app.php" class="btn btn-primary" style="margin-bottom:3%">Book Appointment</a>
        
            <a href="patient_summary.php" class="btn btn-primary" style="margin-bottom:3%">Appointment Summary</a>
			
			<a href="patient_confirmed_view_new.php" class="btn btn-primary" style="margin-bottom:3%">Confirmed Appointment</a>
                     
        </div>
    </div>

</body>
</html>









