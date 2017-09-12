<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Attribution : test</title>
    </head>

    <body>

        <?php

        use modele\dao\OffreDAO;
        use modele\dao\GroupeDAO;
        use modele\dao\AttributionDAO;
        use modele\dao\Bdd;
        use modele\metier\Attribution;

require_once __DIR__ . '/../includes/autoload.php';

        Bdd::connecter();

        echo "<h2>Test de AttributionDAO</h2>";

        $idEtab = '0350773A';
        $idTypeCh = 'C3';
        $idGroupe = 'g005';

        // Test n°1
        echo "<h3>1- getOneById</h3>";
        $objet = AttributionDAO::getOneById($idEtab, $idTypeCh, $idGroupe);
        var_dump($objet);

        // Test n°2
        echo "<h3>2- getAll</h3>";
        $lesObjets = AttributionDAO::getAll();
        var_dump($lesObjets);

        // Test n°3-1 : 5 chambres de type C1 offertes par '0350785N' sont attribuées 
        echo "<h3>3-1- getNbOccupiedRooms > 0</h3>";
        $idEtab = '0350785N';
        $idTypeCh = 'C1';
        $nb = AttributionDAO::getNbOccupiedRooms($idEtab, $idTypeCh);
        var_dump($nb);

        // Test n°3-2 : 0 chambres de type C4 offertes par '0350785N' sont attribuées 
        echo "<h3>3-2- getNbOccupiedRooms == 0</h3>";
        $idEtab = '0350785N';
        $idTypeCh = 'C4';
        $nb = AttributionDAO::getNbOccupiedRooms($idEtab, $idTypeCh);
        var_dump($nb);

        // Test n°4
        echo "<h3>4- getAllByIdEtab : 2 attributions pour l'établissement '0350773A'</h3>";
        $idEtab = '0350773A';
        $lesObjets = AttributionDAO::getAllByIdEtab($idEtab);
        var_dump($lesObjets);
        
        // Test n°5
        echo "<h3>5- getAllByIdTypeChambre : 4 attributions pour le type de chambre 'C2'</h3>";
        $idTypeCh = 'C2';
        $lesObjets = AttributionDAO::getAllByIdTypeChambre($idTypeCh);
        var_dump($lesObjets);
        
        // Test n°6
        echo "<h3>6- insert</h3>";
        $idEtab = '0350773A';
        $idTypeCh = 'C2';
        $idGroupe = 'g005';
        $nb = 9;
        try {
//            /* @var $unEtab modele\metier\Offre */
//            $uneOffre = OffreDAO::getOneById($idEtab, $idTypeCh);
//            /* @var $unTypeCh modele\metier\TypeChambre */
//            $unGroupe = GroupeDAO::getOneById($idGroupe);
//            /* @var $objet modele\metier\Offre */
//            $objet = new Attribution($uneOffre, $unGroupe, $idGroupe);
            $ok = AttributionDAO::insertValues($idEtab, $idTypeCh, $idGroupe, $idGroupe);
            if ($ok) {
                echo "<h4>ooo réussite de l'insertion ooo</h4>";
                $objetLu = AttributionDAO::getOneById($idEtab, $idTypeCh, $idGroupe);
                var_dump($objetLu);
            } else {
                echo "<h4>*** échec de l'insertion ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }

        // Test n°7
        echo "<h3>7- update</h3>";
        $idEtab = '0350773A';
        $idTypeCh = 'C2';
        $idGroupe = 'g005';
        $newNb = 10;
        try {
            $ok = AttributionDAO::update($idEtab, $idTypeCh, $idGroupe, $newNb);
            if ($ok) {
                $objetLu = AttributionDAO::getOneById($idEtab, $idTypeCh, $idGroupe);
                if ($objetLu->getNbChambres() == $newNb) {
                    echo "<h4>ooo réussite de la mise à jour ooo</h4>";
                    var_dump($objetLu);
                } else {
                    echo "<h4>*** échec de la mise à jour, le nombre de chambres n'est pas le bon ***</h4>";
                }
            } else {
                echo "<h4>*** échec de la mise à jour, erreur DAO ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête, erreur PDO ***</h4>" . $e->getMessage();
        }
        
        // Test n°8
        echo "<h3>8- delete</h3>";
        try {
            $ok = AttributionDAO::delete($idEtab, $idTypeCh, $idGroupe);
            if ($ok) {
                echo "<h4>ooo réussite de la suppression ooo</h4>";
            } else {
                echo "<h4>*** échec de la suppression ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }
        
        Bdd::deconnecter();
        ?>


    </body>
</html>
