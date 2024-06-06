<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<form action="" method="POST">
    <label for="name">Naam</label>
    <input type="text" name="name" required>


    <input type="submit" value="Verzenden" name="send">
</form>

<?php 

include("dbconnect.php");

if( isset($_POST['send'])){
    $name = $_POST['name'];

    try {
        $query = "INSERT INTO category (name)
                  VALUES (:name)";
        $query_run = $db->prepare($query);
        $category = [
            ':name' => $name,
        ];

        var_dump($category);
        $query_run->execute($category);
        header("Location: index.php");

    } catch (PDOException $e){
        echo $e->getMessage();
    }
}
 
?>
</body>
</html>
