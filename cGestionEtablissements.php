<?php
/**
 * Contrôleur : gestion des établissements
 */
use modele\dao\EtablissementDAO;
use modele\metier\Etablissement;
use modele\dao\Bdd;
require_once __DIR__.'/includes/autoload.php';
Bdd::connecter();

include("includes/_gestionErreurs.inc.php");
//include("includes/gestionDonnees/_connexion.inc.php");
//include("includes/gestionDonnees/_gestionBaseFonctionsCommunes.inc.php");

// 1ère étape (donc pas d'action choisie) : affichage du tableau des 
// établissements 
if (!isset($_REQUEST['action'])) {
    $_REQUEST['action'] = 'initial';
}

$action = $_REQUEST['action'];

// Aiguillage selon l'étape
switch ($action) {
    case 'initial' :
        include("vues/GestionEtablissements/vObtenirEtablissements.php");
        break;

    case 'detailEtab':
        $id = $_REQUEST['id'];
        include("vues/GestionEtablissements/vObtenirDetailEtablissement.php");
        break;

    case 'demanderSupprimerEtab':
        $id = $_REQUEST['id'];
        include("vues/GestionEtablissements/vSupprimerEtablissement.php");
        break;

    case 'demanderCreerEtab':
        include("vues/GestionEtablissements/vCreerModifierEtablissement.php");
        break;

    case 'demanderModifierEtab':
        $id = $_REQUEST['id'];
        include("vues/GestionEtablissements/vCreerModifierEtablissement.php");
        break;

    case 'validerSupprimerEtab':
        $id = $_REQUEST['id'];
        EtablissementDAO::delete($id);
        include("vues/GestionEtablissements/vObtenirEtablissements.php");
        break;

    case 'validerCreerEtab':case 'validerModifierEtab':
        $id = $_REQUEST['id'];
        $nom = $_REQUEST['nom'];
        $adresseRue = $_REQUEST['adresseRue'];
        $codePostal = $_REQUEST['codePostal'];
        $ville = $_REQUEST['ville'];
        $tel = $_REQUEST['tel'];
        $adresseElectronique = $_REQUEST['adresseElectronique'];
        $type = $_REQUEST['type'];
        $civiliteResponsable = $_REQUEST['civiliteResponsable'];
        $nomResponsable = $_REQUEST['nomResponsable'];
        $prenomResponsable = $_REQUEST['prenomResponsable'];

        if ($action == 'validerCreerEtab') {
            verifierDonneesEtabC($id, $nom, $adresseRue, $codePostal, $ville, $tel, $nomResponsable, $adresseElectronique);
            if (nbErreurs() == 0) {
                $unEtab = new Etablissement($id, $nom, $adresseRue, $codePostal, $ville, $tel, $adresseElectronique, $type, $civiliteResponsable, $nomResponsable, $prenomResponsable);
                EtablissementDAO::insert($unEtab);
                include("vues/GestionEtablissements/vObtenirEtablissements.php");
            } else {
                include("vues/GestionEtablissements/vCreerModifierEtablissement.php");
            }
        } else {
            verifierDonneesEtabM($id, $nom, $adresseRue, $codePostal, $ville, $tel, $nomResponsable, $adresseElectronique);
            if (nbErreurs() == 0) {
                $unEtab = new Etablissement($id, $nom, $adresseRue, $codePostal, $ville, $tel, $adresseElectronique, $type, $civiliteResponsable, $nomResponsable, $prenomResponsable);
                EtablissementDAO::update($id, $unEtab);
                include("vues/GestionEtablissements/vObtenirEtablissements.php");
            } else {
                include("vues/GestionEtablissements/vCreerModifierEtablissement.php");
            }
        }
        break;
}

// Fermeture de la connexion au serveur MySql
Bdd::deconnecter();

function verifierDonneesEtabC($id, $nom, $adresseRue, $codePostal, $ville, $tel, $nomResponsable, $adresseElectronique) {
    if ($id == "" || $nom == "" || $adresseRue == "" || $codePostal == "" ||
            $ville == "" || $tel == "" || $nomResponsable == "") {
        ajouterErreur('Chaque champ suivi du caractère * est obligatoire');
    }
    if ($id != "") {
        // Si l'id est constitué d'autres caractères que de lettres non accentuées 
        // et de chiffres, une erreur est générée
        if (!estChiffresOuEtLettres($id)) {
            ajouterErreur
                    ("L'identifiant doit comporter uniquement des lettres non accentuées et des chiffres");
        } else {
            if (EtablissementDAO::isAnExistingId($id)) {
                ajouterErreur("L'établissement $id existe déjà");
            }
        }
    }
    if ($nom != "" && EtablissementDAO::isAnExistingName(true, $id, $nom)) {
        ajouterErreur("L'établissement $nom existe déjà");
    }
    if ($codePostal != "" && !estUnCp($codePostal)) {
        ajouterErreur('Le code postal doit comporter 5 chiffres');
    }
    if ($adresseElectronique != "" && !estUneAE($adresseElectronique)) {
        ajouterErreur('Veuillez saisir une adresse mail au format 123abc@456def.aaa ou 123abc@456def.aa');
    }
    if ($nom != "" && !caracAlpha($nom)) {
        ajouterErreur('Seul les caractères alphabétiques et numériques sont acceptés');
    }
    
}

function verifierDonneesEtabM($id, $nom, $adresseRue, $codePostal, $ville, $tel, $nomResponsable, $adresseElectronique) {
    if ($nom == "" || $adresseRue == "" || $codePostal == "" || $ville == "" ||
            $tel == "" || $nomResponsable == "") {
        ajouterErreur('Chaque champ suivi du caractère * est obligatoire');
    }
    if ($nom != "" && EtablissementDAO::isAnExistingName(false, $id, $nom)) {
        ajouterErreur("L'établissement $nom existe déjà");
    }
    if ($codePostal != "" && !estUnCp($codePostal)) {
        ajouterErreur('Le code postal doit comporter 5 chiffres');
    }
    if ($adresseElectronique != "" && !estUneAE($adresseElectronique)) {
        ajouterErreur('Veuillez saisir une adresse mail au format 123abc@456def.aaa ou 123abc@456def.aa');
    }
    if ($nom != "" && !caracAlpha($nom)) {
        ajouterErreur('Seul les caractères alphabétiques et numériques sont acceptés');
    }
}

function estUnCp($codePostal) {
    // Le code postal doit comporter 5 chiffres
    return strlen($codePostal) == 5 && estEntier($codePostal);
}

function estUneAE($adresseElectronique){
    return preg_match ( " /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_ -]+(\.[a-zA-Z0-9_ -]+)*\.[a-zA-Z]{2,4}$/ ", $adresseElectronique);
    }
    
function caracAlpha($nom){
    return preg_match ( "/^[a-z0-9]+([\\s]{1}[a-z0-9]|[a-z0-9])+$/i", $nom);
    }