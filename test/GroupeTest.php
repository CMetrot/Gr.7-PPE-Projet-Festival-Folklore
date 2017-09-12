<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Groupe Test</title>
    </head>
    <body>
        <?php
        use modele\metier\Groupe;
        require_once __DIR__ . '/../includes/autoload.php';
        echo "<h2>Test unitaire de la classe métier Groupe</h2>";
        $objet = new Groupe("g999","les Joyeux Turlurons","général Alcazar","Tapiocapolis" ,25,"San Theodoros","N");
        var_dump($objet);
        ?>
    </body>
</html>
