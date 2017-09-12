<?php

/**
 * Contrôleur : gestion des types de chambres
 */
use modele\metier\TypeChambre;
use modele\dao\TypeChambreDAO;
use modele\dao\Bdd;
require_once __DIR__ . '/includes/autoload.php';
Bdd::connecter();

include("includes/_gestionErreurs.inc.php");
//include("includes/gestionDonnees/_connexion.inc.php");
//include("includes/gestionDonnees/_gestionBaseFonctionsCommunes.inc.php");

// 1ère étape (donc pas d'action choisie) : affichage de l'ensemble des types 
// de chambres
if (!isset($_REQUEST['action'])) {
    $_REQUEST['action'] = 'initial';
}

$action = $_REQUEST['action'];

// Aiguillage selon l'étape
switch ($action) {
    case 'initial':
        include("vues/GestionTypesChambres/vObtenirTypesChambres.php");
        break;

    case 'demanderSupprimerTypeChambre':
        $id = $_REQUEST['id'];
        include("vues/GestionTypesChambres/vSupprimerTypeChambre.php");
        break;

    case 'demanderCreerTypeChambre':
        include("vues/GestionTypesChambres/vCreerModifierTypeChambre.php");
        break;

    case 'demanderModifierTypeChambre':
        $id = $_REQUEST['id'];
        include("vues/GestionTypesChambres/vCreerModifierTypeChambre.php");
        break;

    case 'validerSupprimerTypeChambre':
        $id = $_REQUEST['id'];
        TypeChambreDAO::delete($id);
        include("vues/GestionTypesChambres/vObtenirTypesChambres.php");
        break;

    case 'validerCreerTypeChambre':
        $id = $_REQUEST['id'];
        $libelle = $_REQUEST['libelle'];
        verifierDonneesTypeChambreC($id, $libelle);
        if (nbErreurs() == 0) {
            TypeChambreDAO::insert(new TypeChambre($id, $libelle));
            include("vues/GestionTypesChambres/vObtenirTypesChambres.php");
        } else {
            include("vues/GestionTypesChambres/vCreerModifierTypeChambre.php");
        }
        break;

    case 'validerModifierTypeChambre':
        $id = $_REQUEST['id'];
        $libelle = $_REQUEST['libelle'];
        verifierDonneesTypeChambreM($id, $libelle);
        if (nbErreurs() == 0) {
            TypeChambreDAO::update($id, new TypeChambre($id, $libelle));
            include("vues/GestionTypesChambres/vObtenirTypesChambres.php");
        } else {
            include("vues/GestionTypesChambres/vCreerModifierTypeChambre.php");
        }
        break;
}

// Fermeture de la connexion au serveur MySql
Bdd::deconnecter();

function verifierDonneesTypeChambreC($id, $libelle) {
    if ($id == "" || $libelle == "") {
        ajouterErreur('Chaque champ suivi du caractère * est obligatoire');
    }
    if ($id != "") {
        // Si l'id est constitué d'autres caractères que de lettres non accentuées 
        // et de chiffres, une erreur est générée
        if (!estChiffresOuEtLettres($id)) {
            ajouterErreur("L'identifiant doit comporter uniquement des lettres non accentuées et des chiffres");
        } else {
            if (TypeChambreDAO::isAnExistingId($id)) {
                ajouterErreur("Le type de chambre $id existe déjà");
            }
        }
    }
    if ($libelle != "" && TypeChambreDAO::isAnExistingLibelle(true, $id, $libelle)) {
        ajouterErreur("Le type de chambre $libelle existe déjà");
    }
}

function verifierDonneesTypeChambreM($id, $libelle) {
    if ($libelle == "") {
        ajouterErreur('Chaque champ suivi du caractère * est obligatoire');
    }
    if ($libelle != "" && TypeChambreDAO::isAnExistingLibelle(false, $id, $libelle)) {
        ajouterErreur("Le type de chambre $libelle existe déjà");
    }
}
