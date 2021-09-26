<?php
require_once "DBConnect.php";
include 'layout/header1.php';
include 'layout/nav.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patientName = $_POST['patientName'];
    $dob = $_POST['dob'];
	$phone = $_POST['phone'];
	$address = $_POST['address'];
    $city = $_POST['city'];
	$state = $_POST['state'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);

    $sql = "select cust_email from customer where cust_email='$email2';";
    $stmt1 = $link->prepare($sql);
    $stmt1->execute();
    $res = $stmt1->get_result();

    if ($res->num_rows > 0) {
        // output data of each row
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if ($email2 == $row['cust_email']) {
            $err = "Email already exists";
        }
    } else {
       $sql2 = "CALL tempRegistration(?, ?, ?, ?, ?, ?, ?, ? )";
        $stmt2 = $link->prepare($sql2);
        $stmt2->bind_param('ssiiisbs', $name, $email2, $city, $block, $apt, $intro, $cust_photo, $password);
        //$stmt2->execute();
        //run the store proc
        if (!$stmt2->execute()) {
            die( "CALL failed: (" . $mysqli->errno . ") " . $mysqli->error);
        }
        $stmt2->close();
        //session_start();
        //$_SESSION["name"]=$name;
        $cookie_name = "user";
        $cookie_value = $name;
        setcookie($cookie_name, $cookie_value, time() + 300, "/"); // 86400 = 1 day
        header("location: confirmation.php");
    }
    $res->close();
    $stmt1->close();
    $link->close();
}


?>



<?php include "include/header.php" ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#cityID").change(function() {
            debugger;
            var selectedCity = $("#cityID option:selected").val();
            $.ajax({
                type: "POST",
                url: "include/blockByCity.php",
                data: {
                    city: selectedCity
                }
            }).done(function(data) {
                $("#response").html(data);
            });


            $.ajax({
                type: "POST",
                url: "include/signUpMap.php",
                data: {
                    city: selectedCity
                }
            }).done(function(data) {
                if (data != '') {
                var dataStr = data;
                var block_details = dataStr.split('%%');
                var LatLng = {
                  lat: 40.730610,
                  lng: -73.935242
                };
                var map = new google.maps.Map(document.getElementById('map'), {
                  center: custLatLng,
                  zoom: 10
                });

                for (var i = 0; i < block_details.length; i++) {
                  var coordinates = block_details[i];
                  var coordinatesArr = coordinates.split('$$');
                  var myLatLng = {
                    lat: parseFloat(coordinatesArr[2]),
                    lng: parseFloat(coordinatesArr[3])
                  };
                  var v_title = coordinatesArr[1];
                  var marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    title: v_title,
                    customInfo: coordinatesArr[0]
                  });
                  map.setCenter(marker.getPosition());
                  map.setZoom(11);
                   google.maps.event.addDomListener(marker, 'click', function() {
                       debugger;
                       $("#blockID").val(this.customInfo);
                //     window.location.href = 'http://www.google.co.uk/';
                   });
                }
              }
              else
              {
                var custLatLng = {
                  lat: 40.730610,
                  lng: -73.935242
                };
                var map = new google.maps.Map(document.getElementById('map'), {
                  center: custLatLng,
                  zoom: 10
                });
              }
            });

        });
    });
</script>
</head>

<body>
    <style type="text/css">
        body {
            font: 14px sans-serif;
        }

        .wrapper {
            width: 350px;
            padding: 20px;
        }
    </style>

    <div class="wrapper container">
        <img class="rounded mx-auto d-block" src="img/logo.png" width="200" height="120" alt="">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email2" class="form-control" required>
                <!-- <span class="help-block"><?php echo $email_err; ?></span> -->
            </div>

            <?php

            $sql = "select distinct city_id, city_name from blocks";
            $stmt1 = $link->prepare($sql);
            $stmt1->execute();
            $result = $stmt1->get_result();
            $result = $link->query($sql);
            if ($result->num_rows > 0) {
                echo "<div class='form-group'>   
                <label>City</label>
                <select name='city' id='cityID' class='form-control' required>
                <option value='Select'>Select</option>";
                // output data of each row
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    echo "<option value=" . $row["city_id"] . ">" . $row["city_name"] . "</option>";
                }
                echo "</select> </div>";
            }
            ?>
            <div class='form-group' style="height: 300px; width: 310px;" id="map"></div>
            <div id="response" class='form-group'>
                <label>Block</label>
                <select name="block" id="blockID" class="form-control" required>

                </select>
                <!--Response will be inserted here-->
            </div>


            <div class="form-group">
                <label>Apartment Number</label>
                <input type="text" name="apt" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Introduction</label>
                <textarea name="intro" rows="4" cols="50" id="exampleFormControlTextarea1" placeholder="Please enter intro" required></textarea>
            </div>
            <div class="form-group">
                <label>Upload a picture</label>
                <input type="file" name="cust_photo" accept="image/*" class="form-control-file" id="exampleFormControlFile1">
            </div>
            <div class="form-group">
                <label>Password</labeNumber>
                    <input type="password" name="password" class="form-control" required>
            </div>
            <!-- <div class="form-group"> -->
            <!-- <label>Confirm Password</label> -->
            <!-- <input type="password" name="confirm_password" class="form-control" required> -->
            <!-- </div> -->
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <span class="help-block"><?php echo $err; ?></span><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>
</body>
<script type="text/javascript">
          // $(document).ready(function() {
          //       //debugger;
          //       var custID = $("#userIdMap").text();
          //       $("#userIdMap").hide()
          //       $.ajax({
          //         type: "POST",
          //         url: "include/mapMarkers.php",
          //         data: {
          //           cid: custID
          //         }
          //       }).done(function(data) {
          //         debugger;
          //         console.log(data);
          //         var coordinates = data;
          //         var coordinatesArr = coordinates.split('%%');
          //         myLatLng = {
          //           lat: parseFloat(coordinatesArr[1]),
          //           lng: parseFloat(coordinatesArr[2])
          //         };
          //         v_title=coordinatesArr[3];
          //         initMap();

          //       });
          //     });



        function initMap() {
                var custLatLng = {
                  lat: 40.730610,
                  lng: -73.935242
                };
                var map = new google.maps.Map(document.getElementById('map'), {
                  center: custLatLng,
                  zoom: 10
                });
          }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApCWOHmn53M9sVFahUSi0D_dyEiJHDSbw&callback=initMap" async defer></script>
        <!-- <br>243 68th st, Brooklyn,<br>
        NY 11220<br><br>
        No. of people in same block = <br>
        No. of people in same hood = -->
</html>