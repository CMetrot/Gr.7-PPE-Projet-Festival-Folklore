<?php

/**
 * Contrôleur : gestion des attributions d'hébergement
 */
use modele\dao\AttributionDAO;
use modele\dao\OffreDAO;
use modele\dao\Bdd;

require_once __DIR__ . '/includes/autoload.php';
Bdd::connecter();

include("includes/_gestionErreurs.inc.php");
//include("includes/gestionDonnees/_connexion.inc.php");
//include("includes/gestionDonnees/_gestionBaseFonctionsCommunes.inc.php");
//include("includes/gestionDonnees/_gestionBaseFonctionsGestionAttributions.inc.php");

// 1ère étape (donc pas d'action choisie) : affichage du tableau des 
// attributions en lecture seule
if (!isset($_REQUEST['action'])) {
    $_REQUEST['action'] = 'initial';
}

$action = $_REQUEST['action'];

// Aiguillage selon l'étape
switch ($action) {
    case 'initial':
        include("vues/AttributionChambres/vConsulterAttributionChambres.php");
        break;

    case 'demanderModifierAttrib':
        include("vues/AttributionChambres/vModifierAttributionChambres.php");
        break;

    case 'donnerNbChambres':
        $idEtab = $_REQUEST['idEtab'];
        $idTypeChambre = $_REQUEST['idTypeChambre'];
        $idGroupe = $_REQUEST['idGroupe'];
        $nbChambres = $_REQUEST['nbChambres'];
        include("vues/AttributionChambres/vDonnerNbChambresAttributionChambres.php");
        break;

    case 'validerModifierAttrib':
        $idEtab = $_REQUEST['idEtab'];
        $idTypeChambre = $_REQUEST['idTypeChambre'];
        $idGroupe = $_REQUEST['idGroupe'];
        $nbChambres = $_REQUEST['nbChambres'];
//        modifierAttribChamb($connexion, $idEtab, $idTypeChambre, $idGroupe, $nbChambres);
        if ($nbChambres == 0) {
            AttributionDAO::delete($idEtab, $idTypeChambre, $idGroupe);
        } else {
            // Vérifier l'existence de l'attribution considérée
            /* @var $uneAttrib modele\metier\Attribution */
            $uneAttrib = AttributionDAO::getOneById($idEtab, $idTypeChambre, $idGroupe);
            if ($uneAttrib != null) {
                // l'attribution existe déjà, il faut la mettre à jour
                AttributionDAO::update($idEtab, $idTypeChambre, $idGroupe, $nbChambres);
            } else {
                // l'attribution n'existe pas, il faut la créer
                AttributionDAO::insertValues($idEtab, $idTypeChambre, $idGroupe, $nbChambres);
            }
        }

        include("vues/AttributionChambres/vModifierAttributionChambres.php");
        break;
}

// Fermeture de la connexion au serveur MySql
Bdd::deconnecter();

// Retourne le nombre de chambres libres pour l'établissement et le type de
// chambre en question (retournera 0 si absence d'offre ou si absence de 
// disponibilité)  
function obtenirNbDispo($idEtab, $idTypeChambre) {
//    $nbOffre = obtenirNbOffre($connexion, $idEtab, $idTypeChambre);
    Bdd::connecter();
    $uneOffre = OffreDAO::getOneById($idEtab, $idTypeChambre);
    if (is_null($uneOffre)) {
        $nbOffre = 0;
    } else {
        $nbOffre = $uneOffre->getNbChambres();
    }

    if ($nbOffre != 0) {
        // Recherche du nombre de chambres occupées pour l'établissement et le
        // type de chambre en question
//        $nbOccup = obtenirNbOccup($connexion, $idEtab, $idTypeChambre);
        $nbOccup = AttributionDAO::getNbOccupiedRooms($idEtab, $idTypeChambre);
        // Calcul du nombre de chambres libres
        $nbChLib = $nbOffre - $nbOccup;
        return $nbChLib;
    } else {
        return 0;
    }
}



