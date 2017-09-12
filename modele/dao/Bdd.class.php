<?php

namespace modele\dao;

use \PDO;
use \PDOException;

/**
 * Description of Bdd
 * Singleton de connexion à la base de données
 * Remarque : les noms de colonnes de la BDD seront automatiquement convertis en majuscules
 * (option PDO : $pdo_options[PDO::ATTR_CASE] = PDO::CASE_UPPER
 * @author btssio
 */
/**
 * DSN MYSQL
 */
define('HOTE', 'localhost');    // url du serveur de bases de données
define('BD', 'festival');       // nom de la base de données
define('LOGIN', 'festival');    // login d'un utilisateur de MySql avec des droits sur la BDD
define('MDP', 'secret');        // mot de passe de cet utilisateur
define('DSN', "mysql:host=" . HOTE . ";dbname=" . BD); // construction de la chaîne de connexion utilisée par PDO
/**
 * DSN ORACLE XE
 */
//define('HOTE', 'localhost:1521');
//define('BD', 'XE');
//define('LOGIN', 'FESTIVAL');
//define('MDP', 'secret');
//define('DSN', "oci:dbname=".HOTE."/". BD);

class Bdd {

    /**
     * Objet de type PDO, dépositaire de la connexion courante à la BDD
     * @var PDO
     */
    private static $pdo = null;

    /**
     * Crée un objet de type PDO et ouvre la connexion 
     * @return un objet de type PDO pour accéder à la base de données
     */
    public static function connecter() {
        // on ne crée une connexion que si elle n'existe pas déjà ...
        if (is_null(self::$pdo)) {
            try {
                // Attributs de connexion
                $pdo_options = array();
                $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;       // permet la gestion des exceptions
                $pdo_options[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES utf8";  // pour récupérer les données en UTF8
                $pdo_options[PDO::ATTR_CASE] = PDO::CASE_UPPER;                 // pour compatibilité avec Oracle database (noms de champs trancrits en majuscules)
                self::$pdo = new PDO(DSN, LOGIN, MDP, $pdo_options);
                
            } catch (PDOException $e) {
                echo "ERREUR : " . $e->getMessage();
                die();
            }
        }
        return self::$pdo;
    }

    public static function deconnecter() {
        self::$pdo = null;
    }

    public static function getPdo() {
        return self::$pdo;
    }

}
