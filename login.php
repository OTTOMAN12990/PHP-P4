<?php
// Include database connection file
require_once "dbconnect.php";

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him based on role
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    // Redirect user based on role
    if ($_SESSION["rol"] === 'admin') {
        header("location: admin.php");
        exit;
    } elseif ($_SESSION["rol"] === 'klant') {
        header("location: client.php");
        exit;
    }
}

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";
$login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if email is empty
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($email_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, email, password, rol FROM client WHERE email = :email";

        if ($stmt = $db->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

            // Set parameters
            $param_email = $email;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Check if email exists
                if ($stmt->rowCount() == 1) {
                    // Fetch result row as an associative array
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    // Verify password
                    if (password_verify($password, $row["password"])) {
                        // Password is correct, so start a new session
                        

                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $row["id"];
                        $_SESSION["email"] = $email;
                        $_SESSION["rol"] = $row["rol"];

                        // Redirect user based on role
                        if ($_SESSION["rol"] === 1) {
                            header("location: admin.php");
                        } elseif ($_SESSION["rol"] === 0) {
                            header("location: client.php");
                        }
                    } else {
                        // Password is not valid, display a generic error message
                        $login_err = "Invalid email or password.";
                    }
                } else {
                    // Email doesn't exist, display a generic error message
                    $login_err = "Invalid email or password.";
                }
            } else {
                // Something went wrong with the query execution, display a generic error message
                $login_err = "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
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
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo $email; ?>">
            <span><?php echo $email_err; ?></span>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
            <span><?php echo $password_err; ?></span>
        </div>
        <div>
            <input type="submit" value="Login">
        </div>
        <p><?php echo $login_err; ?></p>
        <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
    </form>
    <p>Admins can't log in using this form. If you are an admin, please use the <a href="adminlogin.php">admin login</a>.</p>
</body>
</html>
