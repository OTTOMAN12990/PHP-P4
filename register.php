<?php
// Include database connection file
require_once "dbconnect.php";

// Define variables and initialize with empty values
$first_name = $last_name = $email = $address = $zipcode = $city = $state = $country = $telephone = $password = $confirm_password = "";
$first_name_err = $last_name_err = $email_err = $address_err = $zipcode_err = $city_err = $state_err = $country_err = $telephone_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate first name
    if(empty(trim($_POST["first_name"]))){
        $first_name_err = "Please enter your first name.";
    } else{
        $first_name = trim($_POST["first_name"]);
    }

    // Validate last name
    if(empty(trim($_POST["last_name"]))){
        $last_name_err = "Please enter your last name.";
    } else{
        $last_name = trim($_POST["last_name"]);
    }

    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter your email.";
    } else{
        $email = trim($_POST["email"]);
    }

    // Validate address
    if(empty(trim($_POST["address"]))){
        $address_err = "Please enter your address.";
    } else{
        $address = trim($_POST["address"]);
    }

    // Validate zipcode
    if(empty(trim($_POST["zipcode"]))){
        $zipcode_err = "Please enter your zipcode.";
    } else{
        $zipcode = trim($_POST["zipcode"]);
    }

    // Validate city
    if(empty(trim($_POST["city"]))){
        $city_err = "Please enter your city.";
    } else{
        $city = trim($_POST["city"]);
    }

    // Validate state
    if(empty(trim($_POST["state"]))){
        $state_err = "Please enter your state.";
    } else{
        $state = trim($_POST["state"]);
    }

    // Validate country
    if(empty(trim($_POST["country"]))){
        $country_err = "Please enter your country.";
    } else{
        $country = trim($_POST["country"]);
    }

    // Validate telephone
    if(empty(trim($_POST["telephone"]))){
        $telephone_err = "Please enter your telephone number.";
    } else{
        $telephone = trim($_POST["telephone"]);
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have at least 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if(empty($first_name_err) && empty($last_name_err) && empty($email_err) && empty($address_err) && empty($zipcode_err) && empty($city_err) && empty($state_err) && empty($country_err) && empty($telephone_err) && empty($password_err) && empty($confirm_password_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO client (first_name, last_name, email, address, zipcode, city, state, country, telephone, password) VALUES (:first_name, :last_name, :email, :address, :zipcode, :city, :state, :country, :telephone, :password)";

        if($stmt = $db->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":first_name", $first_name, PDO::PARAM_STR);
            $stmt->bindParam(":last_name", $last_name, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":address", $address, PDO::PARAM_STR);
            $stmt->bindParam(":zipcode", $zipcode, PDO::PARAM_STR);
            $stmt->bindParam(":city", $city, PDO::PARAM_STR);
            $stmt->bindParam(":state", $state, PDO::PARAM_STR);
            $stmt->bindParam(":country", $country, PDO::PARAM_STR);
            $stmt->bindParam(":telephone", $telephone, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

            // Set parameters
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page or wherever you want
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        unset($stmt);
    }
    // Close connection
    unset($db);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>
    <h2>Register</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" value="<?php echo $first_name; ?>">
            <span><?php echo $first_name_err; ?></span>
        </div>
        <div>
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name" value="<?php echo $last_name; ?>">
            <span><?php echo $last_name_err; ?></span>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo $email; ?>">
            <span><?php echo $email_err; ?></span>
        </div>
        <div>
            <label for="address">Address:</label>
            <input type="text" name="address" id="address" value="<?php echo $address; ?>">
            <span><?php echo $address_err; ?></span>
        </div>
        <div>
            <label for="zipcode">Zipcode:</label>
            <input type="text" name="zipcode" id="zipcode" value="<?php echo $zipcode; ?>">
            <span><?php echo $zipcode_err; ?></span>
        </div>
        <div>
            <label for="city">City:</label>
            <input type="text" name="city" id="city" value="<?php echo $city; ?>">
            <span><?php echo $city_err; ?></span>
        </div>
        <div>
            <label for="state">State:</label>
            <input type="text" name="state" id="state" value="<?php echo $state; ?>">
            <span><?php echo $state_err; ?></span>
        </div>
        <div>
            <label for="country">Country:</label>
            <input type="text" name="country" id="country" value="<?php echo $country; ?>">
            <span><?php echo $country_err; ?></span>
        </div>
        <div>
            <label for="telephone">Telephone:</label>
            <input type="text" name="telephone" id="telephone" value="<?php echo $telephone; ?>">
            <span><?php echo $telephone_err; ?></span>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
            <span><?php echo $password_err; ?></span>
        </div>
        <div>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" id="confirm_password">
            <span><?php echo $confirm_password_err; ?></span>
        </div>
        <div>
            <input type="submit" value="Submit">
            <input type="reset" value="Reset">
        </div>
    </form>
</body>
</html>

