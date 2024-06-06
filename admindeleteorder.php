<?php
// Verbinding maken met de database
require_once "dbconnect.php";

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_order'])) {
    $purchase_id = $_POST['purchase_id'];

    try {
        $query = $db->prepare("DELETE FROM purchase WHERE id = :id");
        $query->bindParam(':id', $purchase_id);
        $query->execute();

        echo "<script>alert('Bestelling succesvol verwijderd');</script>";
    } catch (PDOException $e) {
        echo "Fout bij het verwijderen van de bestelling: " . $e->getMessage();
    }
}

// Retrieve undelivered orders
try {
    $query = $db->prepare("SELECT p.id as purchase_id, p.date as purchase_date, c.first_name, c.last_name 
                           FROM purchase p
                           JOIN client c ON p.client_id = c.id
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
                <th>Klant Voornaam</th>
                <th>Klant Achternaam</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($undeliveredOrders as $order) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($order['purchase_id']) . "</td>";
                echo "<td>" . htmlspecialchars($order['purchase_date']) . "</td>";
                echo "<td>" . htmlspecialchars($order['first_name']) . "</td>";
                echo "<td>" . htmlspecialchars($order['last_name']) . "</td>";
                echo "<td>
                        <form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='POST'>
                            <input type='hidden' name='purchase_id' value='" . htmlspecialchars($order['purchase_id']) . "'>
                            <button type='submit' name='delete_order'>Verwijderen</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="index.php">Terug</a>
</body>
</html>
