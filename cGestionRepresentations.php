<?php

/**
 * Contrôleur : gestion des offres d'hébergement
 */
use modele\dao\DaoRepresentation;
use modele\dao\AttributionDAO;
use modele\dao\Bdd;

require_once __DIR__ . '/includes/autoload.php';
Bdd::connecter();


include("includes/_gestionErreurs.inc.php");
//include("includes/gestionDonnees/_connexion.inc.php");
//include("includes/gestionDonnees/_gestionBaseFonctionsCommunes.inc.php");

// 1ère étape (donc pas d'action choisie) : affichage du tableau des offres en 
// lecture seule
if (!isset($_REQUEST['action'])) {
    $_REQUEST['action'] = 'initial';
}

$action = $_REQUEST['action'];

// Aiguillage selon l'étape   
switch ($action) {
    case 'initial' :
        include("vues/GestionRepresentations/vObtenirRepresentations.php");
        break;

    
}

// Fermeture de la connexion au serveur MySql
Bdd::deconnecter();

