<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>TypeChambreDAO : test</title>
    </head>

    <body>

        <?php

        use modele\dao\TypeChambreDAO;
        use modele\dao\Bdd;
        use modele\metier\TypeChambre;

        require_once __DIR__ . '/../includes/autoload.php';

        $id = 'C3';
        Bdd::connecter();

        echo "<h2>Test TypeChambreDAO</h2>";
        // Test n°1
        echo "<h3>1- getOneById</h3>";
        try {
            $objet = TypeChambreDAO::getOneById($id);
            echo "<p>Voici le libelle d'identifiant $id : " . $objet->getLibelle() . "</p>";
            var_dump($objet);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°2
        echo "<h3>2- getAll</h3>";
        try {
            $lesObjets = TypeChambreDAO::getAll();
            var_dump($lesObjets);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°3
        echo "<h3>3- insert</h3>";
        try {
            $id = 'C9';
            $objet = new TypeChambre($id, 'Dortoir');
            $ok = TypeChambreDAO::insert($objet);
            if ($ok) {
                echo "<h4>ooo réussite de l'insertion ooo</h4>";
                $objetLu = TypeChambreDAO::getOneById($id);
                var_dump($objetLu);
            } else {
                echo "<h4>*** échec de l'insertion ***</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }


        // Test n°4
        echo "<h3>4- update</h3>";
        try {
            $objet->setLibelle('Chambrée');
            $ok = TypeChambreDAO::update($id, $objet);
            if ($ok) {
                echo "<h4>ooo réussite de la mise à jour ooo</h4>";
                $objetLu = TypeChambreDAO::getOneById($id);
                var_dump($objetLu);
            } else {
                echo "<h4>*** échec de la mise à jour ***</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°5
        echo "<h3>5- delete</h3>";
        try {
            $ok = TypeChambreDAO::delete($id);
            if ($ok) {
                echo "<h4>ooo réussite de la suppression ooo</h4>";
            } else {
                echo "<h4>*** échec de l'insertion ***</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°6
        echo "<h3>6-1- isAnExistingId - id existant</h3>";
        $id = "C1"; // id existant
        try {
            $ok = TypeChambreDAO::isAnExistingId($id);
            if ($ok == 1) {
                echo "<h4>ooo réussite du test, l'id existe ooo</h4>";
            } else {
                echo "<h4>*** échec du test ***</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }
        echo "<h3>6-2- isAnExistingId - id inexistant</h3>";
        $id = "Cx"; // id absent
        try {
            $ok = TypeChambreDAO::isAnExistingId($id);
            if ($ok == 1) {
                echo "<h4>*** échec du test, l'id ne devrait pas exister ***</h4>";
                
            } else {
                echo "<h4>ooo réussite du test, l'id n'existe pas ooo</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }
        echo "<h3>7- isAnExistingLibelle</h3>";
        try {
            $ok = TypeChambreDAO::isAnExistingLibelle(true, 'C9', '1 lit'); // libellé existant en création
            $ok = $ok && !TypeChambreDAO::isAnExistingLibelle(true, 'C9', '1 couette'); // libellé inexistant en création
            $ok = $ok && !TypeChambreDAO::isAnExistingLibelle(false, 'C1', '1 lit'); // libellé existant mais correspondant à l'id
            $ok = $ok && TypeChambreDAO::isAnExistingLibelle(false, 'C9', '1 lit'); // libellé inexistant en mode modification
            if ($ok) {
                echo "<h4>ooo réussite du test </h4>";
                
            } else {
                echo "<h4>*** échec du test ***</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }
        Bdd::deconnecter();
        ?>


    </body>
</html>
