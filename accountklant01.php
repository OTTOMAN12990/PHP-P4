<?php
session_start(); // Start the session

require_once "dbconnect.php";

// Check if the client is logged in
if (!isset($_SESSION['client_id'])) {
    header("Location: accountklant.php");
    exit();
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the submitted data
    $client_id = $_POST['client_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $postcode = $_POST['postcode'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // Validate and sanitize the input data
    $first_name = filter_var($first_name, FILTER_SANITIZE_STRING);
    $last_name = filter_var($last_name, FILTER_SANITIZE_STRING);
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    $city = filter_var($city, FILTER_SANITIZE_STRING);
    $postcode = filter_var($postcode, FILTER_SANITIZE_STRING);
    $phone = filter_var($phone, FILTER_SANITIZE_STRING);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);

    if ($email === false) {
        echo "Ongeldig e-mailadres.";
        exit();
    }

    // Update the client details in the database
    try {
        $query = $db->prepare("
            UPDATE client
            SET first_name = :first_name,
                last_name = :last_name,
                address = :address,
                city = :city,
                postcode = :postcode,
                phone = :phone,
                email = :email
            WHERE id = :client_id
        ");
        $query->bindParam(':first_name', $first_name);
        $query->bindParam(':last_name', $last_name);
        $query->bindParam(':address', $address);
        $query->bindParam(':city', $city);
        $query->bindParam(':postcode', $postcode);
        $query->bindParam(':phone', $phone);
        $query->bindParam(':email', $email);
        $query->bindParam(':client_id', $client_id, PDO::PARAM_INT);
        $query->execute();

        header("Location: accountklant.php?update=success");
        exit();
    } catch (PDOException $e) {
        echo "Fout bij het bijwerken van klantgegevens: " . $e->getMessage();
        exit();
    }
} else {
    echo "Ongeldig verzoek.";
    exit();
}
?>
