<?php
require_once "dbconnect.php";

if (isset($_GET['id'])) {
    $name_id = $_GET['id'];

    try {
        // Fetch client details
        $get_name = $db->prepare("SELECT first_name, last_name, rol, id FROM client WHERE id = :id");
        $get_name->bindParam(':id', $name_id);
        $get_name->execute();
        $name = $get_name->fetch(PDO::FETCH_ASSOC);

        if (!$name) {
            echo "Client not found.";
            exit;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['adminedit'])) {
    try {
        $name_id = $_POST['name_id'];
        $rol = $_POST['rol'];

        // Update client's role
        $update_query = $db->prepare("UPDATE client SET rol = :rol WHERE id = :id");
        $update_query->bindParam(':rol', $rol);
        $update_query->bindParam(':id', $name_id);
        $update_query->execute();

        echo "Role updated successfully. <a href='adminbeheer.php'>terug naar adminbeheer list</a>";
        exit;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client Role</title>
</head>
<body>

<?php if (isset($name)): ?>
    <a href='adminbeheer.php'>terug naar adminbeheer</a>"
    <h2>Edit Role for <?= htmlspecialchars($name['first_name']) . " " . htmlspecialchars($name['last_name']); ?></h2>
    <form action="adminedit.php?id=<?= htmlspecialchars($name['id']); ?>" method="POST">
        <input type="hidden" name="name_id" value="<?= htmlspecialchars($name['id']); ?>">
        <label for="first_name">Voornaam</label>
        <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($name['first_name']); ?>" readonly>

        <label for="rol">Rol</label>
        <input type="text" id="rol" name="rol" value="<?= htmlspecialchars($name['rol']); ?>">
        
        <input type="submit" name="adminedit" value="Submit">
    </form>
<?php else: ?>
    <p>No client selected for editing.</p>
<?php endif; ?>

</body>
</html>
