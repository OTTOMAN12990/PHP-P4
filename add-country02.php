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
$query = $db->prepare("SELECT name, code FROM country");
$query->execute();
$selectedCountries = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<table border="1">
<a href='admin.php'>terug</a>"
    <thead>
        <tr>
            <th>naam</th>
            <th>code</th>
            <th>Acties</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($selectedCountries as $countryData) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($countryData['name']) . "</td>";
            echo "<td>" . htmlspecialchars($countryData['code']) . "</td>";
            echo '<td><a href="add-country01.php?id=' . htmlspecialchars($countryData['code']) . '">Bewerken</a></td>';
            echo "</tr>";
        }


        



        //update

        
if(isset($_POST["countryedit"])){
    $name = $_POST["name"];
    $rol = $_POST["code"];
}
$update_query = $db->prepare("UPDATE country SET name = :name WHERE id = :id");
$query_run= $db->prepare($query);
$selectedCountries = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<table border="1">
    <thead>
        <tr>
            <th>Naam</th>
            <th>code</th>
        
            <th>Acties</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($selectedCountries as $countryData) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($countryData['name']) . "</td>";
            echo "<td>" . htmlspecialchars($countryData['code']) . "</td>";
    
            echo '<td><a href="add-country01.php?id=' . htmlspecialchars($countryData['id']) . '">Bewerken</a></td>';
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>
