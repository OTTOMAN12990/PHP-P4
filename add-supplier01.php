<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<form action="" method="POST">
    <label for="companyName">Bedrijfsnaam</label>
    <input type="text" name="companyName" required>

    <label for="adress">Adres</label>
    <input type="text" name="adress">

    <label for="streetNumber">Straatnaam</label>
    <input type="text" name="streetNumber">

    <label for="zipcode">Postcode</label>
    <input type="text" name="zipcode">

    <label for="city">Stad</label>
    <input type="text" name="city">

    <label for="state">Provincie</label>
    <input type="text" name="state">

    <label for="countryId">Landid</label>
    <input type="number" name="countryId">

    <label for="telephone">Telefoonnummer</label>
    <input type="text" name="telephone">

    <label for="website">Website</label>
    <input type="text" name="website">

    <input type="submit" value="Verzenden" name="send">
</form>

<?php 

include("dbconnect.php");

if( isset($_POST['send'])){
    $companyName = $_POST['companyName'];
    $adress = $_POST['adress'];
    $streetNumber = $_POST['streetNumber'];
    $zipcode = $_POST['zipcode'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $countryId = $_POST['countryId'];
    $telephone = $_POST['telephone'];
    $website = $_POST['website'];

    try {
        $query = "INSERT INTO supplier (company, adress, streetnr, zipcode, city, state, countryid, telephone, website)
                  VALUES (:company, :adress, :streetnr, :zipcode, :city, :state, :countryid, :telephone, :website)";
        $query_run = $db->prepare($query);
        $supplier = [
            ':company' => $companyName,
            ':adress' => $adress,
            ':streetnr' => $streetNumber,
            ':zipcode' => $zipcode,
            ':city' => $city,
            ':state' => $state,
            ':countryid' => $countryId,
            ':telephone' => $telephone,
            ':website' => $website,
        ];

        var_dump($supplier);
        $query_run->execute($supplier);
        header("Location: index.php");

    } catch (PDOException $e){
        echo $e->getMessage();
    }
}
 
?>
</body>
</html>
