<html>

<body>

  <!-- TODO
Check for existing email id's before insertion 
update patient pid here $PID = 1;
password hashing-->


  <?php
  include("dbconnect.php");

  //todo
  $PID = 1;
  $referer = filter_input(INPUT_SERVER, 'HTTP_REFERER');
  // echo $referer;

  //cross site scripting checking : VALIDATION AGAINST XSS
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $err = "I hope you are having a good day :)" . '<br>';
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $HTML_Name = test_input($_POST["Name"]);
    $HTML_Phone_Number = test_input($_POST["Phone"]);
    $HTML_Address = test_input($_POST["Address"]);
    $HTML_dob = test_input($_POST["dob"]);
    $HTML_State = test_input($_POST["State"]);
    $HTML_City = test_input($_POST["City"]);
    $HTML_PIN = test_input($_POST["Pincode"]);
    $HTML_Max_Distance = test_input($_POST["Max"]);
    $HTML_Email = test_input($_POST["Email"]);
    $HTML_Password = test_input($_POST["Password"]);
  }

  $check = 0;
  if (filter_var($HTML_Email, FILTER_VALIDATE_EMAIL)) {
    $check = 1;
    //var_dump(filter_var($HTML_Email, FILTER_VALIDATE_EMAIL));
  } else {
    //var_dump(filter_var($HTML_Email, FILTER_VALIDATE_EMAIL));
    // header('Location: '.$referer); 
    $redirect = 'url=' . $referer;
    echo '<br>' . '<h2>' . " INVALID EMAIL ADDRESS , PLEASE ENTER AGAIN";
    header("Refresh:5; $redirect");
    $check = 0;
  }



  if ($check) {
    $address1 = $HTML_Address . ", " . $HTML_City . ", " . $HTML_State . " " . $HTML_PIN;
    $api_key = "AIzaSyBlriAaOMXyugBr1q3bNJ90FcXhJrGyWYc";
    $address = str_replace(" ", "+", $address1);
    $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&key=$api_key");
    $json = json_decode($json);


    $providerLatitude = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $providerLongitude = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};

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
      $HTML_Password,
      $HTML_Max_Distance
    );
    $res = $stmt->execute();
    if ($res) 
    {
     echo '<script>alert("Congratulations! Successfully signed up")</script>';
 	 $PID = $conn->insert_id;
     echo $PID;
    //am updating the table for patient history in the dbms
	 if (isset($_POST['health'])) {
      foreach ($_POST['health'] as $value) {
       echo '<br>' . $value . '<br>';
       $query1 = "INSERT INTO patienthistory(patientId , medCondition) 
       sVALUES (".$PID.",'$value')";
       if ($result1 = $conn->query($query1)) {
        header("location: user_preference.html");
       } 
	   else {
        echo "Value already exists for the patinet" . $value . '<br>';
       }
      }
     }
    }
	else 
    {
      echo '<script>alert("Failed. Try Again")</script>';
    }

    // var_dump($stmt);

    
    // $res = $stmt->get_result();
    // var_dump($res);
  
  }
  ?>

</body>
</html>