<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Offre Test</title>
    </head>
    <body>
        <?php
        use modele\metier\Offre;
        use modele\metier\Etablissement;
        use modele\metier\TypeChambre;
        require_once __DIR__ . '/../includes/autoload.php';
        echo "<h2>Test unitaire de la classe métier Offre</h2>";
        $unEtab = new Etablissement('9999999A', 'La Joliverie', '141 route de Clisson', '44230', 'Saint-Sébastien', '0240987456', 'contact@la-joliverie.com', 1, 'Monsieur', 'Bizet', 'Patrick');
        $unTypeChambre = new TypeChambre("C9", "Dortoir");
        $objet = new Offre($unEtab, $unTypeChambre, 9);
        var_dump($objet);
        ?>
    </body>
</html>
