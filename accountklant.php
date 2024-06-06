<?php
session_start(); // Start the session

require_once "dbconnect.php";

// Check if the client is logged in
if (!isset($_SESSION['client_id'])) {
    header("Location: accountklant.php");
    exit();
}

// Get the client ID from the session
$client_id = $_SESSION['client_id'];

// Retrieve the details of the logged-in client
try {
    $query = $db->prepare("SELECT * FROM client WHERE id = :client_id");
    $query->bindParam(':client_id', $client_id, PDO::PARAM_INT);
    $query->execute();
    $clientDetails = $query->fetch(PDO::FETCH_ASSOC);

    if (!$clientDetails) {
        echo "Klantgegevens niet gevonden.";
        exit();
    }
} catch (PDOException $e) {
    echo "Fout bij het ophalen van klantgegevens: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Eigen Gegevens Wijzigen</title>
</head>
<body>
    <h1>Eigen Gegevens Wijzigen</h1>
    <form action="update_client.php" method="POST">
        <label for="first_name">Voornaam:</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($clientDetails['first_name']); ?>" required>
        
        <label for="last_name">Achternaam:</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($clientDetails['last_name']); ?>" required>
        
        <label for="address">Adres:</label>
        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($clientDetails['address']); ?>" required>
        
        <label for="city">Woonplaats:</label>
        <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($clientDetails['city']); ?>" required>
        
        <label for="postcode">Postcode:</label>
        <input type="text" id="postcode" name="postcode" value="<?php echo htmlspecialchars($clientDetails['postcode']); ?>" required>
        
        <label for="phone">Telefoonnummer:</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($clientDetails['phone']); ?>" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($clientDetails['email']); ?>" required>
        
        <input type="hidden" name="client_id" value="<?php echo htmlspecialchars($clientDetails['id']); ?>">
        
        <button type="submit">Wijzigen</button>
        <a href="navklant.php">Annuleren</a>
    </form>
</body>
</html>
