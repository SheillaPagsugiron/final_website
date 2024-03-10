<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"
        defer></script>
    <script src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations-v1.0.4.js" defer></script>
    <script type="text/javascript"
        src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations.js"></script>
    <script src="registration.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap">
    <link rel="stylesheet" type="text/css" href="gumagana.css">
</head>

<body>
    <div class="container">
      <?php
      // Validate the submit button
      if (isset($_POST["Register"])) {
          // Retrieve form data
          $LastName = $_POST["LastName"];
          $FirstName = $_POST["FirstName"];
          $lotblk = $_POST["lotblk"];
          $street = $_POST["street"];
          $phasub = $_POST["phasub"];
          $country = $_POST["country"];
          $state = $_POST["state"];
          $city = $_POST["city"];
          $province = $_POST["province"];
          $barangay = $_POST["barangay"];
          $email = $_POST["Email"];
          $password = $_POST["password"];
          $RepeatPassword = $_POST["repeat_password"];

          $passwordHash = password_hash($password, PASSWORD_DEFAULT);
          $errors = array();

          // Validate if all fields are empty
          if (empty($LastName) || empty($FirstName) || empty($lotblk) || empty($street) || empty($phasub) || empty($email) || empty($password) || empty($RepeatPassword)) {
              array_push($errors, "All fields are required");
          }

          // Validate if the email is not valid
          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              array_push($errors, "Email is not valid");
          }

          // Password should not be less than 8
          if (strlen($password) < 8) {
              array_push($errors, "Password must be at least 8 characters long");
          }

          // Check if password is the same
          if ($password != $RepeatPassword) {
              array_push($errors, "Password does not match");
          }

          require_once "database.php";
          $sql = "SELECT * FROM user WHERE email = '$email'";
          $result = mysqli_query($conn, $sql);
          $rowCount = mysqli_num_rows($result);
          if ($rowCount > 0) {
              array_push($errors, "Email Already Exists!");
          }

          if (count($errors) > 0) {
              foreach ($errors as $error) {
                  echo "<div class='alert alert-danger'>$error</div>";
              }
          } else {
              // Insert data into the database
              $sql = "INSERT INTO user (Last_Name, First_Name, LotBlk, Street, PhasSubd, Country, State, CityMuni, Province, Barangay, email, password) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
              $stmt = mysqli_stmt_init($conn);
              $preparestmt = mysqli_stmt_prepare($stmt, $sql);
              if ($preparestmt) {
                  mysqli_stmt_bind_param($stmt, "ssssssssssss", $LastName, $FirstName, $lotblk, $street, $phasub, $country, $state, $city, $province, $barangay, $email, $passwordHash);
                  mysqli_stmt_execute($stmt);
                  echo "<div class='alert alert-success'>You are Registered Successfully!</div>";
              } else {
                  die("Something went wrong");
              }
          }
      }
      ?>


      <section class="signup">
        <form action="registration.php" method="post">
            <div class="country-selection" style="text-align: center;">
                <input type="radio" id="philippines" name="country" value="PH">
                <label for="philippines">Philippines</label>
                <input type="radio" id="otherCountry" name="country" value="other" checked>
                <label for="otherCountry">Other Country</label>
            </div>

            <label>Name:</label>
            <div class="name">
                <input type="text" name="LastName" id="lname" placeholder="Last Name" required>
                <input type="text" name="FirstName" id="fname" placeholder="First Name" required>
            </div>

            <div class="address">
                <label>Address:</label>
                <input type="text" name="lotblk" id="lotblk" placeholder="Lot/Blk" required>
                <input type="text" name="street" id="street" placeholder="Street" required>
                <input type="text" name="phasub" id="phasub" placeholder="Phase/Subdivision" required>

                <div class="signup-form" id="otherCountryForm">
                    <!-- Other country form fields -->
                    <div class="select-option">
                        <select class="form-select country" name="country" data-live-search="true"
                            aria-label="Select Country">
                        </select>
                        <select class="form-select state" name="state" aria-label="Select State">
                        </select>
                        <select class="form-select city" name="city" aria-label="Select City">
                        </select>
                    </div>
                </div>
                <div class="signup-form" id="philippinesForm" style="display:none;">
                    <!-- Philippines form fields -->
                    <div class="select-option">
                        <select class="form-select" name="region" id="region" aria-label="Select Region">
                            <option selected>Select Region</option>
                        </select>
                        <select class="form-select" name="province" id="province" aria-label="Select Province">
                            <option selected>Select Province</option>
                        </select>
                        <select class="form-select" name="cityMunicipality" id="cityMunicipality" aria-label="Select City / Municipality">
                            <option selected>Select City/Municipality</option>
                        </select>
                        <select class="form-select" name="barangay" id="barangay" aria-label="Select Barangay">
                            <option selected>Select Barangay</option>
                        </select>
                    </div>
                </div>
            </div>

            <label>Email / Password:</label>
            <div class="emailpassw">
                <input type="email" name="Email" id="email" placeholder="Email" required>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <input type="password" name="repeat_password" id="conpassword" placeholder="Repeat password" required>
            </div>

            <div class="form-group register-button">
                <input type="submit" name="Register" value="Register">
            </div>

            <div class="link">Already have an account? <a href="login.php">Login Here</a></div>
        </form>
      </section>
    </div>
</body>

</html>
