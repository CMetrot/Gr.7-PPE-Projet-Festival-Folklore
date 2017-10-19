<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Test Représentation</title>
    </head>
    <body>
        <?php
            use modele\metier\Representation;
            use modele\metier\Lieu;
            use modele\metier\Groupe;
            require_once __DIR__ . '/../includes/autoload.php';
            echo "<h2>Test unitaire de la classe métier Representation</h2>";
            $lieu = new Lieu("1", "salle du panier fleuri","rue de bonneville", 450);
            $group = new Groupe("g999","les Joyeux Turlurons","général Alcazar","Tapiocapolis" ,25,"San Theodoros","N");
            $objet = new Representation("3", $lieu, $group, "11/07/2017", "20:30", "21:45");
            var_dump($objet);
        ?>
    </body>
</html>
