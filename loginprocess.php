<?php
session_start();
include "dbconnect.php";

if(isset($_POST["login"])){ // Corrected the form name check
    $email = $_POST["email"];
    $pwd = $_POST["password"];

    try {
        $query = "SELECT id, first_name, last_name, email, password FROM client WHERE email = :email";
        $query_run = $db_connection->prepare($query);

        $client_info = [
            ':email' => $email,
        ];

        $query_run->execute($client_info);
        $user = $query_run->fetch(PDO::FETCH_ASSOC);

        if($user) {
            if(password_verify($pwd, $user['password'])) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['name'] = $user['first_name'] . ' ' . $user['last_name'];
                $_SESSION['message'] = "U bent ingelogd";
                header("Location: admin.php");
                exit(0);
            } else {
                $_SESSION['message'] = "Ongeldig wachtwoord";
                header("Location: login.php");
                exit(1);
            }
        } else {
            $_SESSION['message'] = "Gebruiker niet gevonden!";
            header("Location: login.php");
            exit(1);
        }
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, 'errors.log'); // Log the error
        $_SESSION['message'] = "Er is een fout opgetreden. Probeer het later opnieuw.";
        header("Location: login.php");
        exit(1);
    }
} else {
    $_SESSION['message'] = "Ongeldige aanvraag";
    header("Location: login.php");
    exit(1);
}
