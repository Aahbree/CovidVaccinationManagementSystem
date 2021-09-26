<!DOCTYPE HTML>  
<html>
<head>
<style>
    .error {color: #FF0000;}
    * {
      box-sizing: border-box;
    }

    input[type=text], select, textarea {
      width: 50%;
      padding: 12px;
      border: 1px solid #ccc;
      background-color: lightblue;
      border-radius: 4px;
      resize: vertical;
      border-radius: 4px;
    }
	
	input[type=password], select, textarea {
      width: 50%;
      padding: 12px;
      border: 1px solid #ccc;
      background-color: lightblue;
      border-radius: 4px;
      resize: vertical;
      border-radius: 4px;
    }

    label {
      padding: 12px 12px 12px 0;
      display: inline-block;
    }

    input[type=submit] {
      background-color: #4CAF50;
      color: white;
      padding: 15px 80px ;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      float: left;
      text-align: right;
      margin-left: 460px;
    }

    input[type=submit]:hover {
      background-color: #45a049;
    }

    .container {
      border-radius: 5px;
      background-color: #f2f2f2;
      padding: 6px;
      margin-top: 25px;
      padding: 12px 0px 100px 80px;

    }

    .col-25 {
      float: left;
      width: 25%;
      margin-top: 1px;
      text-align: right;
    }

    .col-75 {
      float: left;
      width: 50%;
      margin-top: 1px;
    }

    .col-50 {
      float: left;
      margin-top: 25px;
      margin-left: 30%;
      margin-bottom: 250px;
    }

    .row:after {
      content: "";
      display: table;
      clear: both;
    }

    /* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
    @media screen and (max-width: 600px) {
      .col-25, .col-75, input[type=submit] {
        width: 100%;
        margin-top: 50px;
      }
    }

</style>
</head>
<body>  

<?php
// check for email id already exists
// This file has both html and php code , where we update the form input fields dynamically

include("DBConnect.php");
//todo
$PID = 1;
$referer = filter_input(INPUT_SERVER, 'HTTP_REFERER');
$nameErr = $emailErr = $genderErr = $websiteErr = "";
$name = $email = $gender = $comment = $website = "";
$phone = $phoneErr = "";
$pincode = $pincodeErr = "";
$maxdistance = $maxdistanceErr = "";
$cpassword = $cpasswordErr = "";
$password = $passwordErr = "";
$city = $cityErr = "";
$state = $stateErr = "";
$address = $addressErr = "";
$dob = $dobErr = "";

$flag = true;
$flag2= true;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  if (empty($_POST["name"])) 
  {
    $nameErr = "Name is required";
    $flag = false;
  } 
  else {
    $name = $_POST["name"];
    //  if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
      $flag = false;
    }
    if (preg_match("/[\'^£$%&*()@#~?><>,|=_+¬}{-]/", $name))
      {
        $nameErr = "Invalid : Special charecters used";
        $flag = false;
      }
      $name = test_input($_POST["name"]);
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
    $flag = false;
  } else {
    $email = $_POST["email"];
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
      $flag = false;
    }
  }


  if (empty($_POST["password"])) {
    $passwordErr = "password is required";
    $flag = false;
  } else {
    $password = test_input($_POST["password"]);
    if (0) {
      $passwordErr = "password email format";
      $flag = false;
    }
  }


  if (empty($_POST["cpassword"])) 
  {
    $cpasswordErr = "confirm password is required";
    $flag = false;
  } 
  else 
  {
    $cpassword = test_input($_POST["cpassword"]);
    if ($cpassword != $password)
    {
      $passwordErr = "PASSWORD MISMATCH";
      $cpasswordErr = "PASSWORD MISMATCH";
      $flag = false;
    }

    if (0) {
      $cpasswordErr = "Invalid confirm password format";
      $flag = false;
    }
  }

  if (empty($_POST["phone"])) {
    $phoneErr = " phone is required";
    $flag = false;
  } else {
    $phone = $_POST["phone"];
    if (!preg_match("/^[0-9]{10}$/",$phone))
     {
      $phoneErr = "Invalid format : Enter 10 digits numbers only!  ";
      $flag = false;
    }
    $phone = test_input($_POST["phone"]);
  }

  if (empty($_POST["city"])) {
    $cityErr = " city is required";
    $flag = false;
  } else {
    $city = test_input($_POST["city"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$city)) {
      $cityErr = "Invalid city format";
      $flag = false;
    }
  }

  if (empty($_POST["state"])) {
    $stateErr = " state is required";
    $flag = false;
  } else {
    $state = test_input($_POST["state"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$state)) {
      $stateErr = "Invalid state format";
      $flag = false;
    }
  }

  if (empty($_POST["pincode"])) {
    $pincodeErr = " pincode is required";
    $flag = false;
  } else {
    $pincode = test_input($_POST["pincode"]);
    if (!preg_match("/^[0-9]{5}$/",$pincode)){ 
      $pincodeErr = "Invalid format:5 digits only";
      $flag = false;
    }
  }

  if (empty($_POST["address"])) {
    $addressErr = " address is required";
    $flag = false;
  } else {
    $address = test_input($_POST["address"]);
    if (!preg_match("/^[a-zA-Z-'0-9 ]*$/",$address)) {
      $addressErr = "Invalid address format";
      $flag = false;
    }
  }

  if (empty($_POST["maxdistance"])) {
    $maxdistanceErr = " maxdistance is required";
    $flag = false;
  } else {
    $maxdistance = test_input($_POST["maxdistance"]);
    if (!preg_match("/[0-9]/",$maxdistance)){
      $maxdistanceErr = "Invalid format : Numbers only";
      $flag = false;
    }
  }

  if (empty($_POST["dob"])) {
    $dobErr = " Date of birth is required";
    $flag = false;
  } else {
    $dob = test_input($_POST["dob"]);
    if (!preg_match("/(?:19|20)(?:(?:[13579][26]|[02468][048])-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))|(?:[0-9]{2}-(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:29|30))|(?:(?:0[13578]|1[02])-31)))$/",$dob)) 
    {
      $dobErr = "Invalid Format Enter YYYY-MM-DD";
      $flag = false;
    }
  }
  
  
  if($flag == true)
  {
    echo "Entered Values are correct";

    $HTML_Name = test_input($_POST["name"]);
    $HTML_Phone_Number = test_input($_POST["phone"]);
    $HTML_Address = test_input($_POST["address"]);
    $HTML_dob = test_input($_POST["dob"]);
    $HTML_State = test_input($_POST["state"]);
    $HTML_City = test_input($_POST["city"]);
    $HTML_PIN = test_input($_POST["pincode"]);
    $HTML_Max_Distance = test_input($_POST["maxdistance"]);
    $HTML_Email = test_input($_POST["email"]);
    $HTML_Password = test_input($_POST["password"]);
  

  // Get coordinates from google api
  $address1 = $HTML_Address . ", " . $HTML_City . ", " . $HTML_State . " " . $HTML_PIN;
  $api_key = "AIzaSyDg2kIRdvvR7shwqnUvvuW3Kbp20AAo8Xg";
  $addressnew = str_replace(" ", "+", $address1);
  $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$addressnew&key=$api_key");
  $json = json_decode($json);


  $providerLatitude = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
  $providerLongitude = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
  $password1 = password_hash($_POST["password"],PASSWORD_DEFAULT);

  $query1 = "INSERT INTO Patient( patientName, dob, phone, address, city,	state, pin, latitude, longitude, email, password, max_distance) VALUES ( ?,?,?,?,?,?, ?,?,?,?,?,?)";
  $stmt = $conn->prepare($query1);
  $stmt->bind_param(
    'sssssssssssi',
    $HTML_Name,
    $HTML_dob,
    $HTML_Phone_Number,
    $HTML_Address,
    $HTML_City,
    $HTML_State,
    $HTML_PIN,
    $providerLatitude,
    $providerLongitude,
    $HTML_Email,
    $password1,
    $HTML_Max_Distance
  );
  $res = $stmt->execute();
  echo '<br>' . $res;
  if ($res) 
  {
    echo '<br>' . '<br>' . "Your Account has been created";
  } else 
  {
    echo '<br>' . '<br>' . "FAIL to execute query";
    $flag2=false;
  }
}

$PID = $conn->insert_id;
session_start();
$_SESSION['var']=$PID;


//am updating the table for patient history in the dbms
  if($flag2)
  {
    if (isset($_POST['health'])) 
    {
      foreach ($_POST['health'] as $value) 
      {
        echo '<br>' . $value . '<br>';
    
        $query1 = "INSERT INTO patienthistory(patientId , medCondition) 
        VALUES ($PID,'$value')";
    
        if ($result1 = $conn->query($query1)) {
          echo '<script>alert("Congratulations! Successfully signed up")</script>';
		  
        } else {
           echo '<script>alert("Failed. Try Again")</script>';
        }
      }
    }
  }
  
  


}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>


<div class="row">
<h2>Patient Sign up Page</h2>
<p><span class="error">* required field</span></p>
</div>
<div class="container">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

<div class="row">
    <div class="col-25">
      <label>Name</label>
    </div>
    <div class="col-75">
      <input type="text" name="name" value="<?php echo $name;?>">
      <span class="error">* <?php echo $nameErr;?></span>
      <br>
  </div>
  </div>

  <div class="row">
    <div class="col-25">
      <label>Email</label>
    </div>
    <div class="col-75">
      <input type="text" name="email" value="<?php echo $email;?>">
      <span class="error">* <?php echo $emailErr;?></span>
      <br>
  </div>
  </div>

  <div class="row">
    <div class="col-25">
      <label>Password</label>
    </div>
    <div class="col-75">
      <input type="password" name="password" value="<?php echo $password;?>">
      <span class="error">* <?php echo $passwordErr;?></span>
      <br>
  </div>
  </div>

  <div class="row">
    <div class="col-25">
    <label>Confirm Password</label>
    </div>
    <div class="col-75">
      <input type="password" name="cpassword" value="<?php echo $cpassword;?>">
      <span class="error">* <?php echo $cpasswordErr;?></span>
      <br>
  </div>
  </div>

  <div class="row">
    <div class="col-25">
    <label>Phone Number </label>
    </div>
    <div class="col-75">
      <input type="text" name="phone" value="<?php echo $phone;?>">
      <span class="error">* <?php echo $phoneErr;?></span>
      <br>
  </div>
  </div>

  <div class="row">
    <div class="col-25">
    <label>Date of Birth </label>
    </div>
    <div class="col-75">
      <input type="text" name="dob" value="<?php echo $dob;?>">
      <span class="error">* <?php echo $dobErr;?></span>
      <br>
  </div>
  </div>


<div class="row">
    <div class="col-25">
      <label>Address</label>
    </div>
    <div class="col-75">
      <input type="text" name="address" value="<?php echo $address;?>">
      <span class="error">* <?php echo $addressErr;?></span>
      <br>
  </div>
</div>

<div class="row">
    <div class="col-25">
    <label>City</label>
    </div>
    <div class="col-75">
      <input type="text" name="city" value="<?php echo $city;?>">
  <span class="error">* <?php echo $cityErr;?></span>
  <br>
  </div>
</div>

<div class="row">
    <div class="col-25">
    <label>State</label>
    </div>
    <div class="col-75">
        <select id="state" name="state" >
				<option disabled selected value> -- select an option -- </option>
                <option value="AL">Alabama</option>
                <option value="AK">Alaska</option>
                <option value="AZ">Arizona</option>
                <option value="AR">Arkansas</option>
                <option value="CA">California</option>
                <option value="CO">Colorado</option>
                <option value="CT">Connecticut</option>
                <option value="DE">Delaware</option>
                <option value="DC">District Of Columbia</option>
                <option value="FL">Florida</option>
                <option value="GA">Georgia</option>
                <option value="HI">Hawaii</option>
                <option value="ID">Idaho</option>
                <option value="IL">Illinois</option>
                <option value="IN">Indiana</option>
                <option value="IA">Iowa</option>
                <option value="KS">Kansas</option>
                <option value="KY">Kentucky</option>
                <option value="LA">Louisiana</option>
                <option value="ME">Maine</option>
                <option value="MD">Maryland</option>
                <option value="MA">Massachusetts</option>
                <option value="MI">Michigan</option>
                <option value="MN">Minnesota</option>
                <option value="MS">Mississippi</option>
                <option value="MO">Missouri</option>
                <option value="MT">Montana</option>
                <option value="NE">Nebraska</option>
                <option value="NV">Nevada</option>
                <option value="NH">New Hampshire</option>
                <option value="NJ">New Jersey</option>
                <option value="NM">New Mexico</option>
                <option value="NY">New York</option>
                <option value="NC">North Carolina</option>
                <option value="ND">North Dakota</option>
                <option value="OH">Ohio</option>
                <option value="OK">Oklahoma</option>
                <option value="OR">Oregon</option>
                <option value="PA">Pennsylvania</option>
                <option value="RI">Rhode Island</option>
                <option value="SC">South Carolina</option>
                <option value="SD">South Dakota</option>
                <option value="TN">Tennessee</option>
                <option value="TX">Texas</option>
                <option value="UT">Utah</option>
                <option value="VT">Vermont</option>
                <option value="VA">Virginia</option>
                <option value="WA">Washington</option>
                <option value="WV">West Virginia</option>
                <option value="WI">Wisconsin</option>
                <option value="WY">Wyoming</option>
              </select>






        <span class="error">* <?php echo $stateErr;?></span>
        <br>
    </div>
</div>


<div class="row">
    <div class="col-25">
    <label>Pincode</label>
    </div>
    <div class="col-75">
      <input type="text" name="pincode" value="<?php echo htmlspecialchars($pincode);?>">
  <span class="error">* <?php echo $pincodeErr;?></span>
  <br>
  </div>
</div>

<div class="row">
    <div class="col-25">
      <label>maxdistance</label>
    </div>
    <div class="col-75">
      <input type="text" name="maxdistance" value="<?php echo $maxdistance;?>">
      <span class="error">* <?php echo $maxdistanceErr;?></span>
      <br>
  </div>
  </div>
  
<div class="row">
<div class="col-25">
        <label >Health Problems</label>
</div>
<div class="col-75">
        <input type="checkbox" id="vehicle1" name="health[]" value="BloodPressure">
        <label for="health1">BloodPressure</label><br>

        <input type="checkbox" id="vehicle2" name="health[]" value="Diabetes">
        <label for="health2">Diabetes</label><br>

        <input type="checkbox" id="vehicle3" name="health[]" value="Cancer">
        <label for="health3">Cancer</label><br>

        <input type="checkbox" id="vehicle4" name="health[]" value="PCOD">
        <label for="health4">PCOD</label><br>

        <input type="checkbox" id="vehicle5" name="health[]" value="HeartProblem">
        <label for="health5"> HeartProblem</label><br>

        <input type="checkbox" id="vehicle6" name="health[]" value="OtherDiseases">
        <label for="health6">OtherDiseases</label>
  </div>
</div>

<center>
  <input type="submit" name="submit" value="Submit">  
</center>
</form>

</body>
</html>