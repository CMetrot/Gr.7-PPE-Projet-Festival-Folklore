<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Attribution Test</title>
    </head>
    <body>
        <?php
        use modele\metier\Attribution;
        use modele\metier\Offre;
        use modele\metier\Etablissement;
        use modele\metier\TypeChambre;
        use modele\metier\Groupe;
        require_once __DIR__ . '/../includes/autoload.php';
        echo "<h2>Test unitaire de la classe métier Attribution</h2>";
        $unEtab = new Etablissement('9999999A', 'La Joliverie', '141 route de Clisson', '44230', 'Saint-Sébastien', '0240987456', 'contact@la-joliverie.com', 1, 'Monsieur', 'Bizet', 'Patrick');
        $unTypeChambre = new TypeChambre("C9", "Dortoir");
        $unGroupe = new Groupe("g999","les Joyeux Turlurons","général Alcazar","Tapiocapolis" ,25,"San Theodoros","O");
        $uneOffre = new Offre($unEtab, $unTypeChambre, 9);
        $objet = new Attribution($uneOffre, $unGroupe, 7);
        var_dump($objet);
        ?>
    </body>
</html>
