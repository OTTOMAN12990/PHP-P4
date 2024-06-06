<?php
// Verbinding maken met de database
require_once "dbconnect.php";

// Controleren of de purchase_id is doorgegeven via POST
if(isset($_POST['purchase_id'])) {
    // Het ID van de geselecteerde bestelling ophalen uit de POST-data
    $purchase_id = $_POST['purchase_id'];
    
    // Bestelling verwijderen op basis van de purchase_id
    try {
        // Begin een transactie om atomiciteit te waarborgen
        $db->beginTransaction();

        // Verwijder de bestellingsregels voor deze bestelling
        $query = $db->prepare("DELETE FROM purchaseline WHERE purchaseid = :purchase_id");
        $query->bindParam(':purchase_id', $purchase_id);
        $query->execute();

        // Verwijder de bestelling zelf
        $query = $db->prepare("DELETE FROM purchase WHERE id = :purchase_id");
        $query->bindParam(':purchase_id', $purchase_id);
        $query->execute();

        // Commit de transactie als alle queries succesvol zijn uitgevoerd
        $db->commit();

        // Redirect naar stap 4 met succesmelding
        header("Location: shw-all-purchase4.php?deleted=true");
        exit();
    } catch (PDOException $e) {
        // Rol transactie terug bij fout
        $db->rollBack();

        echo "Fout bij het verwijderen van de bestelling: " . $e->getMessage();
    }
} else {
    // Als purchase_id niet is doorgegeven via POST, terug naar stap 1
    header("Location: shw-all-purchase.php");
    exit();
}
?>
