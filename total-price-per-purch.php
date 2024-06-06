<?php
require_once "dbconnect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>orderlist</title>
</head>
<body>

<?php
$query = $db->prepare("SELECT productid, price, quantity, totaalprice FROM purchaseline");
$query->execute();
$selectedPrices = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<table border="1">
    <a href="admin.php">terug</a>
    <thead>
        <tr>
            <th>productid</th>
            <th>price</th>
            <th>quantity</th>
            <th>totaalprice</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($selectedPrices as $priceData) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($priceData['productid']) . "</td>";
            echo "<td>" . htmlspecialchars($priceData['price']) . "</td>";
            echo "<td>" . htmlspecialchars($priceData['quantity']) . "</td>";
            echo "<td>" . htmlspecialchars($priceData['totaalprice']) . "</td>";
           
            echo "</tr>";
        }


        

