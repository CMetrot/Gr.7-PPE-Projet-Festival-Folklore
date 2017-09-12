<?php

use modele\dao\TypeChambreDAO;
use modele\dao\GroupeDAO;
use modele\dao\EtablissementDAO;
use modele\dao\AttributionDAO;
use modele\dao\Bdd;

require_once __DIR__ . '/../../includes/autoload.php';
Bdd::connecter();

include("includes/_debut.inc.php");

// CONSULTER LES ATTRIBUTIONS DE TOUS LES ÉTABLISSEMENTS
// IL FAUT QU'IL Y AIT AU MOINS UN ÉTABLISSEMENT OFFRANT DES CHAMBRES POUR QUE 
// L'AFFICHAGE SOIT EFFECTUÉ
$lesEtabOffrantChambres = EtablissementDAO::getAllOfferingRooms();
$nbEtabOffrantChambres = count($lesEtabOffrantChambres);
if ($nbEtabOffrantChambres != 0) {
    echo "
   <center> <a href='cAttributionChambres.php?action=demanderModifierAttrib'>
   Effectuer ou modifier les attributions</a> <br> <br>";

    // POUR CHAQUE ÉTABLISSEMENT : AFFICHAGE D'UN TABLEAU COMPORTANT 2 LIGNES 
    // D'EN-TÊTE (LIGNE NOM ET LIGNE DISPONIBILITÉS) ET LE DÉTAIL DES ATTRIBUTIONS

    $lesTypesChambres = TypeChambreDAO::getAll();
    $nbTypesChambres = count($lesTypesChambres);

    // Détermination du :
    //    . % de largeur que devra occuper chaque colonne contenant les attributions
    //      (100 - 35 pour la colonne d'en-tête) / nb de types chambres
    //    . nombre de colonnes de chaque tableau
    $pourcCol = 65 / $nbTypesChambres;
    $nbCol = $nbTypesChambres + 1;

    // BOUCLE SUR LES ÉTABLISSEMENTS
    foreach ($lesEtabOffrantChambres as $unEtab) {
        $idEtab = $unEtab->getId();
        $nomEtab = $unEtab->getNom();

        echo "
      <table width='70%' cellspacing='0' cellpadding='0' class='tabQuadrille'>";

        // AFFICHAGE DE LA 1ÈRE LIGNE D'EN-TÊTE
        echo "
         <tr class='enTeteTabQuad'>
            <td colspan='$nbCol'><strong>$nomEtab</strong></td>
         </tr>";

        // AFFICHAGE DE LA 2ÈME LIGNE D'EN-TÊTE : 1 LIT : NOMBRE DE CHAMBRES 
        // DISPONIBLES, 2 À 3 LITS : NOMBRE DE CHAMBRES DISPONIBLES...  
        echo "
         <tr class='enTete2TabQuad'>
      
            <td width='35%'><i>Disponibilités</i></td>";

        // BOUCLE SUR LES TYPES DE CHAMBRES 
        foreach ($lesTypesChambres as $unTypeChambre) {
            // On recherche les disponibilités pour l'établissement et le type
            // de chambre en question
            $nbChDispo = obtenirNbDispo($idEtab, $unTypeChambre->getId());
            echo "<td><center>" . $unTypeChambre->getLibelle() . "<br>$nbChDispo</center></td>";
        }
        echo "
         </tr>";

        // AFFICHAGE DU DÉTAIL DES ATTRIBUTIONS : UNE LIGNE PAR GROUPE AFFECTÉ 
        // DANS L'ÉTABLISSEMENT

        $lesGroupesEtab = GroupeDAO::getAllByEtablissement($idEtab);
        // BOUCLE SUR LES GROUPES DE L'ETABLISSEMENT (CHAQUE GROUPE EST AFFICHÉ EN LIGNE)
        foreach ($lesGroupesEtab as $unGroupe) {
            $idGroupe = $unGroupe->getId();
            $nomGroupe = $unGroupe->getNom();
            echo "
            <tr class='ligneTabQuad'>
               <td width='35%'>&nbsp;$nomGroupe</td>";

            // BOUCLE SUR LES TYPES DE CHAMBRES (CHAQUE TYPE DE CHAMBRE 
            // FIGURE EN COLONNE)
            foreach ($lesTypesChambres as $unTypeChambre) {
                // On recherche si des chambres du type en question ont 
                // déjà été attribuées à ce groupe dans l'établissement
//                $nbOccupGroupe = obtenirNbOccupGroupe($connexion, $idEtab, $unTypeChambre->getId(), $idGroupe);
                /* @var $uneAttrib modele\metier\Attribution */
                $uneAttrib = AttributionDAO::getOneById($idEtab, $unTypeChambre->getId(), $idGroupe);
                if (!is_null($uneAttrib)) {
                    $nbOccupGroupe = $uneAttrib->getNbChambres();
                } else {
                    $nbOccupGroupe = 0;
                }
                echo "
                  <td width='$pourcCol%'><center>$nbOccupGroupe</center></td>";
            } // Fin de la boucle sur les types de chambres
            echo "
            </tr>";
        } // Fin de la boucle sur les groupes
        echo "
      </table>
      <br>";
    } // Fin de la boucle sur les établissements
}

include("includes/_fin.inc.php");

