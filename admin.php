

<!DOCTYPE html>
<html lang="nl"> 
<head>
    <meta charset="UTF-8">
    <title>Bread Company</title>
    <link rel="stylesheet" type="text/css" href="company.css">  
</head>

<body>
    <header>
        <h1>Welkom bij de Bread Company</h1>
        <!-- hieronder wordt het menu opgehaald. -->
        <?php
            session_start(); 
			
            include "navadmin.php";

        ?>
    </header>
 
    <!-- op de home pagina wat enthousiaste tekst over het bedrijf en de producten -->
    <main>
        <div class="centerflex">
            <img class="centreer" src="images/bread050.jpg" alt="main page image" width="500px"> 
        </div>
        <p> &nbsp; </p>
        <p>ingelogd als admin
        </p>
        
    </main>
    
</body>
</html>
