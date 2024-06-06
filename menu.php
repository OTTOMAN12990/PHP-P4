
<?php

// Start de sessie
session_start();

// Controleer of de gebruiker is ingelogd
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    // Controleer de rol van de gebruiker
    if(isset($_SESSION["rol"])){
        // Als de gebruiker een admin is, include navadmin.php
        if($_SESSION["rol"] === "admin"){
            include "navadmin.php";
        }
        // Als de gebruiker een klant is, include navklant.php
        elseif($_SESSION["rol"] === "klant"){
            include "navklant.php";
        }
        // Als de gebruiker een bezoeker is, include nav.html (standaard navbar)
        else {
            include "nav.html";
        }
    } else {
        // Als de rol niet is ingesteld, include nav.html (standaard navbar)
        include "nav.html";
    }
} else {
    // Als de gebruiker niet is ingelogd, include nav.html (standaard navbar)
    include "nav.html";
}
?>
