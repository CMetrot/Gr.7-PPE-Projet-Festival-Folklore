<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Dao Lieu : test</title>
    </head>

    <body>

        <?php

        use modele\dao\DaoLieu;
        use modele\dao\Bdd;
        use modele\metier\Lieu;

require_once __DIR__ . '/../includes/autoload.php';

        $id = 1;
        Bdd::connecter();

        echo "<h2>Test DaoLieu</h2>";

        // Test n°1
        echo "<h3>Test getOneById</h3>";
        try {
            $objet = DaoLieu::getOneById($id);
            var_dump($objet);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°2
        echo "<h3>Test getAll</h3>";
        try {
            $lesObjets = DaoLieu::getAll();
            var_dump($lesObjets);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        Bdd::deconnecter();
        ?>
        


    </body>
</html>
