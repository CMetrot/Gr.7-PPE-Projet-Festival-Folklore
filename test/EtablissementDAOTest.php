<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>EtablissementDAO : test</title>
    </head>

    <body>

        <?php

        use modele\dao\EtablissementDAO;
        use modele\dao\Bdd;
        use modele\metier\Etablissement;

require_once __DIR__ . '/../includes/autoload.php';

        $id = '0352072M';
        Bdd::connecter();

        echo "<h2>1- EtablissementDAO</h2>";

        // Test n°1
        echo "<h3>Test getOneById</h3>";
        try {
            $objet = EtablissementDAO::getOneById($id);
            var_dump($objet);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°2
        echo "<h3>2- getAll</h3>";
        try {
            $lesObjets = EtablissementDAO::getAll();
            var_dump($lesObjets);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°3
        echo "<h3>3- insert</h3>";
        try {
            $id = '9999999A';
            $objet = new Etablissement($id, 'La Joliverie', '141 route de Clisson', '44230', 'Saint-Sébastien', '0240987456', 'contact@la-joliverie.com', 1, 'Monsieur', 'Bizet', 'Patrick');
            $ok = EtablissementDAO::insert($objet);
            if ($ok) {
                echo "<h4>ooo réussite de l'insertion ooo</h4>";
                $objetLu = EtablissementDAO::getOneById($id);
                var_dump($objetLu);
            } else {
                echo "<h4>*** échec de l'insertion ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }

        // Test n°3-bis
        echo "<h3>3- insert déjà présent</h3>";
        try {
            $id = '9999999A';
            $objet = new Etablissement($id, 'La Jol - bis', '141 route de Clisson aussi', '44230', 'Saint-Séb. bd', '0240987456', 'contact@la-joliverie.com', 1, 'Madame', 'Viard-Gaudin', 'Catherine');
            $ok = EtablissementDAO::insert($objet);
            if ($ok) {
                echo "<h4>*** échec du test : l'insertion ne devrait pas réussir  ***</h4>";
                $objetLu = Bdd::getOneById($id);
                var_dump($objetLu);
            } else {
                echo "<h4>ooo réussite du test : l'insertion a logiquement échoué ooo</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>ooo réussite du test : la requête d'insertion a logiquement échoué ooo</h4>" . $e->getMessage();
        }

        // Test n°4
        echo "<h3>4- update</h3>";
        try {
            $objet->setCdp('44000');
            $objet->setVille('Nantes');
            $ok = EtablissementDAO::update($id, $objet);
            if ($ok) {
                echo "<h4>ooo réussite de la mise à jour ooo</h4>";
                $objetLu = EtablissementDAO::getOneById($id);
                var_dump($objetLu);
            } else {
                echo "<h4>*** échec de la mise à jour ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }

        // Test n°5
        echo "<h3>5- delete</h3>";
        try {
            $ok = EtablissementDAO::delete($id);
//            $ok = EtablissementDAO::delete("xxx");
            if ($ok) {
                echo "<h4>ooo réussite de la suppression ooo</h4>";
            } else {
                echo "<h4>*** échec de la suppression ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }

        // Test n°6
        echo "<h3>6- getAllOfferingRooms</h3>";
        try {
            $lesObjets = EtablissementDAO::getAllOfferingRooms();
            var_dump($lesObjets);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°7
        echo "<h3>7- isAnExistingId</h3>";
        try {
            $id = "0352072M";
            $ok = EtablissementDAO::isAnExistingId($id);
            $ok = $ok && !EtablissementDAO::isAnExistingId('AZERTY');
            if ($ok) {
                echo "<h4>ooo test réussi ooo</h4>";
            } else {
                echo "<h4>*** échec du test ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }

        // Test n°8
        echo "<h3>7- isAnExistingName</h3>";
        try {
            // id et nom d'un établissement existant
            $id = "0350785N";
            $nom = "Collège de Moka";
            $ok=true;
            // en mode modification (1er paramètre = false)
            $ok = EtablissementDAO::isAnExistingName(false, "0123456", $nom);
            $ok = $ok && !EtablissementDAO::isAnExistingName(false, $id, $nom);
            // en mode création (1er paramètre = true)
            $ok = $ok && EtablissementDAO::isAnExistingName(true, "0123456", $nom);
            $ok = $ok && !EtablissementDAO::isAnExistingName(true, "0123456", "Ecole");
            if ($ok) {
                echo "<h4>ooo test réussi ooo</h4>";
            } else {
                echo "<h4>*** échec du test ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }

        Bdd::deconnecter();
        ?>


    </body>
</html>
