<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Bevestiging Verwijdering</title>
</head>
<body>
    <h1>Bevestiging Verwijdering</h1>
    <?php if (isset($_GET['deleted']) && $_GET['deleted'] == "true"): ?>
        <p>De bestelling is succesvol verwijderd.</p>
    <?php else: ?>
        <p>Er is een fout opgetreden. Probeer het opnieuw.</p>
    <?php endif; ?>
    <a href="admin.php">Terug naar Homepagina</a>
</body>
</html>
