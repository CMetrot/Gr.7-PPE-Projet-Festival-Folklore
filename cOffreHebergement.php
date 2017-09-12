<?php

/**
 * Contrôleur : gestion des offres d'hébergement
 */
use modele\dao\OffreDAO;
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
        include("vues/OffreHebergement/vConsulterOffreHebergement.php");
        break;

    case 'demanderModifierOffre':
        $idEtab = $_REQUEST['idEtab'];
        include("vues/OffreHebergement/vModifierOffreHebergement.php");
        break;

    case 'validerModifierOffre':
        $idEtab = $_REQUEST['idEtab'];
        $idTypeChambre = $_REQUEST['idTypeChambre'];
        $nbChambres = $_REQUEST['nbChambres'];

        $nbLignes = $_REQUEST['nbLignes']; // nombre de types de chambres
        $err = false;
        // Pour chaque type de chambre
        for ($i = 0; $i < $nbLignes; $i = $i + 1) {
            // Si la valeur saisie n'est pas numérique ou est inférieure aux 
            // attributions déjà effectuées pour cet établissement et ce type de
            // chambre, la modification n'est pas effectuée
            $entier = estEntier($nbChambres[$i]);
//            $modifCorrecte = estModifOffreCorrecte($connexion, $idEtab, $idTypeChambre[$i], $nbChambres[$i]);
            // La modification de l'offre est acceptée si elle est supérieure aux nbre de chambres déjà attribuées
            $estModifCorrecte = ($nbChambres[$i] >= AttributionDAO::getNbOccupiedRooms($idEtab, $idTypeChambre[$i]));
            if (!$entier || !$estModifCorrecte) {
                $err = true;
            } else {
                if ($nbChambres[$i] == 0) {
                    OffreDAO::delete($idEtab, $idTypeChambre[$i]);
                } else {
                    // rechercher s'il existe déjà une offre pour ce type de chambre
                    $uneOffre = OffreDAO::getOneById($idEtab, $idTypeChambre[$i]);
                    if ($uneOffre != null) {
                        OffreDAO::update($idEtab, $idTypeChambre[$i], $nbChambres[$i]);
                    } else {
                        // on ne dispose pas de l'objet
                        OffreDAO::insertValues($idEtab, $idTypeChambre[$i], $nbChambres[$i]);
                    }
                }
            }
        }
        if ($err) {
            ajouterErreur(
                    "Valeurs non entières ou inférieures aux attributions effectuées");
            include("vues/OffreHebergement/vModifierOffreHebergement.php");
        } else {
            include("vues/OffreHebergement/vConsulterOffreHebergement.php");
        }
        break;
}

// Fermeture de la connexion au serveur MySql
Bdd::deconnecter();

