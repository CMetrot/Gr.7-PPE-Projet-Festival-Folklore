<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Type Chambre Test</title>
    </head>
    <body>
        <?php
        use modele\metier\TypeChambre;
        require_once __DIR__ . '/../includes/autoload.php';
        echo "<h2>Test unitaire de la classe métier Type Chambre</h2>";
        $objet = new TypeChambre("C9", "Dortoir");
        var_dump($objet);
        ?>
    </body>
</html>
