<?php
require_once "dbconnect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client List</title>
</head>
<body>

<?php
// Fetch clients
$query = $db->prepare("SELECT first_name, last_name, rol, id FROM client");
$query->execute();
$selectedNames = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<table border="1">
    <thead>
        <tr>
            <th>Naam</th>
            <th>Achternaam</th>
            <th>Rol</th>
            <th>Acties</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($selectedNames as $nameData) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($nameData['first_name']) . "</td>";
            echo "<td>" . htmlspecialchars($nameData['last_name']) . "</td>";
            echo "<td>" . htmlspecialchars($nameData['rol']) . "</td>";
            echo '<td><a href="adminedit.php?id=' . htmlspecialchars($nameData['id']) . '">Bewerken</a></td>';
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>
