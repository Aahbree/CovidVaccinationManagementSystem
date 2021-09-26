<html>
<body>

<?php
include("dbconnect.php");
include 'layout/header1.php';
include 'layout/nav2.php';

$patientid = $_SESSION["id"];
function setkey_Todbms($key,$slots)
{   $tid = '';
    if($key=='monday')
    {
        if($slots=='8'){  $tid=1; }
        else if ($slots=='10'){ $tid=2; }
        else if ($slots=='12'){ $tid=3; }
        else if ($slots=='2'){ $tid=4; }
        else if ($slots=='4'){ $tid=5; }
    }
    else if($key=='tuesday')
    {
        if($slots=='8'){  $tid=6; }
        else if ($slots=='10'){ $tid=7; }
        else if ($slots=='12'){ $tid=8; }
        else if ($slots=='2'){ $tid=9; }
        else if ($slots=='4'){ $tid=10; }
    }
    else if($key=='wednesday')
    {
        if($slots=='8'){  $tid=11; }
        else if ($slots=='10'){ $tid=12; }
        else if ($slots=='12'){ $tid=13; }
        else if ($slots=='2'){ $tid=14; }
        else if ($slots=='4'){ $tid=15; }
    }
    else if($key=='thursday')
    {
        if($slots=='8'){  $tid=16; }
        else if ($slots=='10'){ $tid=17; }
        else if ($slots=='12'){ $tid=18; }
        else if ($slots=='2'){ $tid=19; }
        else if ($slots=='4'){ $tid=20; }
    }
    else if($key=='friday')
    {
        if($slots=='8'){  $tid=21; }
        else if ($slots=='10'){ $tid=22; }
        else if ($slots=='12'){ $tid=23; }
        else if ($slots=='2'){ $tid=24; }
        else if ($slots=='4'){ $tid=25; }
    }
    else if($key=='saturday')
    {
        if($slots=='8'){  $tid=26; }
        else if ($slots=='10'){ $tid=27; }
        else if ($slots=='12'){ $tid=28; }
        else if ($slots=='2'){ $tid=29; }
        else if ($slots=='4'){ $tid=30; }
    }
    else if($key=='sunday')
    {
        if($slots=='8'){  $tid=31; }
        else if ($slots=='10'){ $tid=32; }
        else if ($slots=='12'){ $tid=33; }
        else if ($slots=='2'){ $tid=34; }
        else if ($slots=='4'){ $tid=35; }
    }
    return $tid;
}

$query2 = "DELETE FROM TimeslotPreference where TimeslotPreference.patientId = ?";
$stmt = $conn->prepare($query2);
$stmt->bind_param('i',$patientid);
$res = $stmt->execute();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    foreach($_POST as $key => $val) {
        foreach($val as $day => $slots){
            
            $tid_value = setkey_Todbms($key,$slots);  
            
            if($tid_value!='')
            {   
                $tid = $tid_value;
                $query1 = "INSERT INTO TimeslotPreference(patientId, tid) VALUES (?,?)";
                $stmt = $conn->prepare($query1);
                $stmt->bind_param('ii',$patientid,$tid);
     
                $res = $stmt->execute();
                
            }

        }        
    	


	}
	
	header("location: welcome.php");
	
}
?>

</body>
</html>
