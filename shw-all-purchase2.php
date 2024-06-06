<?php
// Verbinding maken met de database
require_once "dbconnect.php";

// Controleren of de purchase_id is doorgegeven via de URL
if(isset($_GET['purchase_id'])) {
    // Het ID van de geselecteerde bestelling ophalen uit de URL
    $purchase_id = $_GET['purchase_id'];
    
    // Bestellingdetails ophalen op basis van de purchase_id
    try {
        $query = $db->prepare("SELECT p.id as purchase_id, p.purchasedate as purchasedate, 
                                      c.first_name, c.last_name, c.address, c.city
                               FROM purchase p
                               JOIN client c ON p.clientid = c.id
                               WHERE p.id = :purchase_id");
        $query->bindParam(':purchase_id', $purchase_id);
        $query->execute();
        $orderDetails = $query->fetch(PDO::FETCH_ASSOC);

        // Purchaselinegegevens ophalen voor deze bestelling
        $query = $db->prepare("SELECT product.name as product_name, category.name as category_name, 
                                      purchaseline.quantity, purchaseline.price
                               FROM purchaseline
                               JOIN product ON purchaseline.productid = product.id
                               JOIN category ON product.categoryid = category.id
                               WHERE purchaseline.purchaseid = :purchase_id");
        $query->bindParam(':purchase_id', $purchase_id);
        $query->execute();
        $purchaselineDetails = $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Fout bij het ophalen van bestellingdetails: " . $e->getMessage();
    }
} else {
    // Als purchase_id niet is doorgegeven, terug naar stap 1
    header("Location: stap1.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Bestelling Details</title>
</head>
<body>
    <h1>Bestelling Details</h1>
    <h2>Bestelling Informatie</h2>
    <p><strong>Purchase ID:</strong> <?php echo htmlspecialchars($orderDetails['purchase_id']); ?></p>
    <p><strong>Purchase Datum:</strong> <?php echo htmlspecialchars($orderDetails['purchasedate']); ?></p>
    <p><strong>Klant Naam:</strong> <?php echo htmlspecialchars($orderDetails['first_name'] . ' ' . $orderDetails['last_name']); ?></p>
    <p><strong>Klant Adres:</strong> <?php echo htmlspecialchars($orderDetails['address'] . ', ' . $orderDetails['city']); ?></p>

   
    <!-- Bevestigingsknop om de bestelling te verwijderen -->
    <form action="shw-all-purchase3.php" method="POST">
        <input type="hidden" name="purchase_id" value="<?php echo htmlspecialchars($orderDetails['purchase_id']); ?>">
        <button type="submit" name="confirm_delete">Bevestigen</button>
    </form>

    <a href="shw-all-purchase.php">Annuleren</a>
</body>
</html>
