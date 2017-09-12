<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>OffreDAO : test</title>
    </head>

    <body>

        <?php

        use modele\dao\OffreDAO;
        use modele\dao\EtablissementDAO;
        use modele\dao\TypeChambreDAO;
        use modele\dao\Bdd;
        use modele\metier\Offre;

require_once __DIR__ . '/../includes/autoload.php';

        Bdd::connecter();

        // Jeu d'essai
        $idEtab = '0350785N';
        $idTypeCh_1 = 'C3';
        $idTypeCh_2 = 'C5';
        $nb_1 = 99;
        $nb_2 = 88;

        echo "<h2>Test de OffreDAO</h2>";

        // Test n°1
        echo "<h3>1- getOneById</h3>";
        $objet = OffreDAO::getOneById($idEtab, $idTypeCh_1);
        var_dump($objet);

        // Test n°2
        echo "<h3>2- getAll</h3>";
        $lesObjets = OffreDAO::getAll();
        var_dump($lesObjets);

        // Test n°3
        echo "<h3>3- insert</h3>";
        try {
//            /* @var $unEtab modele\metier\Etablissement */
//            $unEtab = EtablissementDAO::getOneById($idEtab);
//            /* @var $unTypeCh modele\metier\TypeChambre */
//            $unTypeCh = TypeChambreDAO::getOneById($idTypeCh_2);
//            /* @var $objet modele\metier\Offre */
//            $objet = new Offre($unEtab, $unTypeCh, $nb_1);
            $ok = OffreDAO::insertValues($idEtab, $idTypeCh_2, $nb_1);
            if ($ok) {
                echo "<h4>ooo réussite de l'insertion ooo</h4>";
//                $objetLu = OffreDAO::getOneById($unEtab->getId(), $unTypeCh->getId());
                $objetLu = OffreDAO::getOneById($idEtab, $idTypeCh_2);
                var_dump($objetLu);
            } else {
                echo "<h4>*** échec de l'insertion ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }

        // Test n°4
        echo "<h3>4- update</h3>";
        try {
            $ok = OffreDAO::update($idEtab, $idTypeCh_2, $nb_2);
            if ($ok) {
                $objetLu = OffreDAO::getOneById($idEtab, $idTypeCh_2);
                if ($objetLu->getNbChambres() == $nb_2) {
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

        // Test n°5
        echo "<h3>5- delete</h3>";
        try {
            $ok = OffreDAO::delete($idEtab, $idTypeCh_2);
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
