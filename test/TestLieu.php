<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Test Lieu</title>
    </head>
    <body>
        <?php
            use modele\metier\Lieu;
            require_once __DIR__ . '/../includes/autoload.php';
            echo "<h2>Test unitaire de la classe métier Lieu</h2>";
            $objet = new Lieu("1", "salle du panier fleuri","rue de bonneville", 450);
            var_dump($objet);
        ?>
    </body>
</html>
