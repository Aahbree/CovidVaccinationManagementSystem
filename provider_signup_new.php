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
      padding: 12px 12px 10px 0;
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
      margin-left: 300px;
      margin-top: 30px;
    }

    input[type=submit]:hover {
      background-color: #45a049;
    }

    .container {
      border-radius: 5px;
      background-color: #f2f2f2;
      padding: 6px;
      margin-top: 25px;
      margin-left: 10%;
      margin-right: 10%;
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

include("dbconnect.php");

//todo
$PID = 1;
$referer = filter_input(INPUT_SERVER, 'HTTP_REFERER');
$nameErr = $emailErr = $genderErr = $websiteErr = "";
$ptype=$ptypeErr="";
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
  else 
  {
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
  
  if (empty($_POST["email"])) 
  {
    $emailErr = "Email is required";
    $flag = false;
  } 
  else 
  {
    $email = $_POST["email"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
      $emailErr = "Invalid email format";
      $flag = false;
    }
    $query = "select email from Provider where email='$email';";
    if (($result = $conn->query($query))&&($result->num_rows > 0)) 
    { 
        {
            $emailErr = "Email already exists";
            $flag = false;
        }
    }
  }

  if (empty($_POST["ptype"])) {
    $ptypeErr = "Provider type is required";
    $flag = false;
  } else {
    $ptype = $_POST["ptype"];
    if (!preg_match("/^[a-zA-Z-' ]*$/",$ptype)) {
      $ptypeErr = "Invalid Provider type ";
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

  }

  if (empty($_POST["phone"])) {
    $phoneErr = "PhoneNo is required";
    $flag = false;
  } else {
    $phone = $_POST["phone"];
    if (!preg_match("/^[0-9]{10}$/",$phone))
     {
      $phoneErr = "Invalid format:10 digits only  ";
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

  if($flag == true)
  {

    $HTML_Name = test_input($_POST["name"]);
    $HTML_Phone_Number = test_input($_POST["phone"]);
    $HTML_Address = test_input($_POST["address"]);
    $HTML_ptype = test_input($_POST["ptype"]);
    $HTML_State = test_input($_POST["state"]);
    $HTML_City = test_input($_POST["city"]);
    $HTML_PIN = test_input($_POST["pincode"]);
    $HTML_Email = test_input($_POST["email"]);
    $HTML_Password = test_input($_POST["password"]);
  
   $password1 = password_hash($_POST['password'],PASSWORD_DEFAULT);

  // Get coordinates from google api
  $address1 = $HTML_Address . ", " . $HTML_City . ", " . $HTML_State . " " . $HTML_PIN;
  $api_key = "AIzaSyDg2kIRdvvR7shwqnUvvuW3Kbp20AAo8Xg";
  $addressnew = str_replace(" ", "+", $address1);
  $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$addressnew&key=$api_key");
  $json = json_decode($json);


  $providerLatitude = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
  $providerLongitude = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};


  $query1 = "INSERT INTO Provider( providerName, providerType, phone, address, city,	
  state, pin, latitude, longitude, email, password) VALUES ( ?,?,?,?,?,?,?,?,?,?,?)";
  $stmt = $conn->prepare($query1);
  $stmt->bind_param(
    'sssssssssss',
    $HTML_Name,
    $HTML_ptype,
    $HTML_Phone_Number,
    $HTML_Address,
    $HTML_City,
    $HTML_State,
    $HTML_PIN,
    $providerLatitude,
    $providerLongitude,
    $HTML_Email,
    $password1
  );
  $res = $stmt->execute();
  if ($res) 
  {
	header("location: plogin.php");
  } else 
  {
    echo '<br>' . '<br>' . "FAIL to execute query";
    $flag2=false;
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
<center><h2>Provider Sign up Page</h2></center>
<center><p><span class="error">* required field</span></p></center>
</div>
<div class="container">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

<div class="row">
    <div class="col-25">
      <label>Name</label>
    </div>
    <div class="col-75">
      <input type="text" name="name" value="<?php echo htmlspecialchars($name);?>">
      <span class="error">* <?php echo htmlspecialchars($nameErr);?></span>
      <br>
  </div>
  </div>

  <div class="row">
    <div class="col-25">
    <label>Provider Type </label>
    </div>
    <div class="col-75">
      <input type="text" name="ptype" value="<?php echo htmlspecialchars($ptype);?>">
      <span class="error">* <?php echo htmlspecialchars($ptypeErr);?></span>
      <br>
  </div>
  </div>

  <div class="row">
    <div class="col-25">
      <label>Email</label>
    </div>
    <div class="col-75">
      <input type="text" name="email" value="<?php echo htmlspecialchars($email);?>">
      <span class="error">* <?php echo htmlspecialchars($emailErr);?></span>
      <br>
  </div>
  </div>

  <div class="row">
    <div class="col-25">
      <label>Password</label>
    </div>
    <div class="col-75">
      <input type="password" name="password" value="<?php echo htmlspecialchars($password);?>">
      <span class="error">* <?php echo htmlspecialchars($passwordErr);?></span>
      <br>
  </div>
  </div>

  <div class="row">
    <div class="col-25">
    <label>Confirm Password</label>
    </div>
    <div class="col-75">
      <input type="password" name="cpassword" value="<?php echo htmlspecialchars($cpassword);?>">
      <span class="error">* <?php echo htmlspecialchars($cpasswordErr);?></span>
      <br>
  </div>
  </div>

  <div class="row">
    <div class="col-25">
    <label>Phone Number </label>
    </div>
    <div class="col-75">
      <input type="text" name="phone" value="<?php echo htmlspecialchars($phone);?>">
      <span class="error">* <?php echo htmlspecialchars($phoneErr);?></span>
      <br>
  </div>
  </div>


<div class="row">
    <div class="col-25">
      <label>Address</label>
    </div>
    <div class="col-75">
      <input type="text" name="address" value="<?php echo htmlspecialchars($address);?>">
      <span class="error">* <?php echo htmlspecialchars($addressErr);?></span>
      <br>
  </div>
</div>

<div class="row">
    <div class="col-25">
    <label>City</label>
    </div>
    <div class="col-75">
      <input type="text" name="city" value="<?php echo htmlspecialchars($city);?>">
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






        <span class="error">* <?php echo htmlspecialchars($stateErr);?></span>
        <br>
    </div>
</div>


<div class="row">
    <div class="col-25">
    <label>Pincode</label>
    </div>
    <div class="col-75">
      <input type="text" name="pincode" value="<?php echo htmlspecialchars($pincode);?>">
  <span class="error">* <?php echo htmlspecialchars($pincodeErr);?></span>
  <br>
  </div>
</div>

<center>
  <input type="submit" name="submit" value="Submit">  
</center>
</form>

</body>
</html>