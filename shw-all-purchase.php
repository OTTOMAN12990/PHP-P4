<?php
// Verbinding maken met de database
require_once "dbconnect.php";

// Handle delete request and redirect to step 2
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_order'])) {
    $purchase_id = $_POST['purchase_id']; // ID van de geselecteerde bestelling

    // Redirect naar stap 2 met de ID van de geselecteerde bestelling
    header("Location: shw-all-purchase2?purchase_id=" . urlencode($purchase_id));
    exit();
}

// Retrieve undelivered orders
try {
    $query = $db->prepare("SELECT p.id as purchase_id, p.purchasedate as purchasedate, 
                                  c.first_name, c.last_name
                           FROM purchase p
                           JOIN client c ON p.clientid = c.id
                           WHERE p.delivered = 0");
    $query->execute();
    $undeliveredOrders = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Fout bij het ophalen van bestellingen: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Ongedeleverde Bestellingen</title>
</head>
<body>
    <h1>Ongedeleverde Bestellingen</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Purchase ID</th>
                <th>Purchase Datum</th>
                <th>Klant Naam</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($undeliveredOrders as $order) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['purchase_id']); ?></td>
                    <td><?php echo htmlspecialchars($order['purchasedate']); ?></td>
                    <td><?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></td>
                    <td>
                        <!-- Verwijderformulier voor elke bestelling -->
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <input type="hidden" name="purchase_id" value="<?php echo htmlspecialchars($order['purchase_id']); ?>">
                            <button type="submit" name="delete_order">Verwijderen</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="admin.php">Terug</a>
</body>
</html>
