<?php
// Verbinding maken met de database
require_once "dbconnect.php";

// Handle adding a country
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_country'])) {
    $country_name = $_POST["country_name"];
    $country_code = $_POST["country_code"];

    try {
        $query = $db->prepare("INSERT INTO country (name, code) VALUES (:name, :code)");
        $query->bindParam(':name', $country_name);
        $query->bindParam(':code', $country_code);
        $query->execute();

        echo "<script>alert('Land succesvol toegevoegd');</script>";
    } catch (PDOException $e) {
        echo "Fout bij het toevoegen van het land: " . $e->getMessage();
    }
}

// Handle deleting a country
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_country'])) {
    $country_code = $_POST["country_code"];

    try {
        $query = $db->prepare("DELETE FROM country WHERE code = :code");
        $query->bindParam(':code', $country_code);
        $query->execute();

        echo "<script>alert('Land succesvol verwijderd');</script>";
    } catch (PDOException $e) {
        echo "Fout bij het verwijderen van het land: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Land Beheer</title>
</head>
<body>
    <h1>Land Toevoegen</h1>
    <form id="addForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="country_name">Land Naam:</label>
        <input type="text" id="country_name" name="country_name" required>
        
        <label for="country_code">Land Code:</label>
        <input type="text" id="country_code" name="country_code" required>
        
        <button type="submit" name="add_country">Toevoegen</button>
        <button type="button" id="clearAddForm">Annuleren</button>
    </form>

    <h1>Land Verwijderen</h1>
    <form id="deleteForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="country_name_delete">Land Naam:</label>
        <input type="text" id="country_name_delete" name="country_name" required>
        
        <label for="country_code_delete">Land Code:</label>
        <input type="text" id="country_code_delete" name="country_code" required>
        
        <button type="submit" name="delete_country">Verwijderen</button>
        <button type="button" id="clearDeleteForm">Annuleren</button>
    </form>
    <a href="add-country02.php">Terug</a>

    <script>
        // Add event listener for the "annuleren" button of the add form
        document.getElementById('clearAddForm').addEventListener('click', function() {
            document.getElementById('addForm').reset();
        });
        
        // Add event listener for the "annuleren" button of the delete form
        document.getElementById('clearDeleteForm').addEventListener('click', function() {
            document.getElementById('deleteForm').reset();
        });
    </script>
</body>
</html>
