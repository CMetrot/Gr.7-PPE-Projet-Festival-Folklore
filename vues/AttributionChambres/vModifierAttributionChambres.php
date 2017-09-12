<?php

use modele\dao\TypeChambreDAO;
use modele\dao\GroupeDAO;
use modele\dao\EtablissementDAO;
use modele\dao\OffreDAO;
use modele\dao\AttributionDAO;
use modele\dao\Bdd;

require_once __DIR__ . '/../../includes/autoload.php';
Bdd::connecter();

include("includes/_debut.inc.php");

// EFFECTUER OU MODIFIER LES ATTRIBUTIONS POUR L'ENSEMBLE DES ÉTABLISSEMENTS
// CETTE PAGE CONTIENT UN TABLEAU CONSTITUÉ DE 3 LIGNES D'EN-TÊTE (LIGNE TITRE, 
// LIGNE ÉTABLISSEMENTS ET LIGNE TYPES DE CHAMBRES) ET DU DÉTAIL DES 
// ATTRIBUTIONS 
// UNE LÉGENDE FIGURE SOUS LE TABLEAU
// Recherche du nombre d'établissements offrant des chambres pour le 
// dimensionnement des colonnes
$lesEtabOffrantChambres = EtablissementDAO::getAllOfferingRooms();
$nbEtabOffrantChambres = count($lesEtabOffrantChambres);

// Détermination du pourcentage de largeur des colonnes "établissements"
$pourcCol = 65 / $nbEtabOffrantChambres;

// Recherche du nombre de types de chambres pour le dimensionnement des colonnes
$lesTypesChambres = TypeChambreDAO::getAll();
$nbTypesChambres = count($lesTypesChambres);


// Calcul du nombre de colonnes du tableau   
$nbCol = ($nbEtabOffrantChambres * $nbTypesChambres) + 1;

echo "
<br>
<table width='90%' cellspacing='0' cellpadding='0' class='tabQuadrille'>";

// AFFICHAGE DE LA 1ÈRE LIGNE D'EN-TÊTE
echo "
   <tr class='enTeteTabQuad'>
      <td  colspan='$nbCol'><strong>
      Effectuer ou modifier les attributions</strong></td>
   </tr>";

// AFFICHAGE DE LA 2ÈME LIGNE D'EN-TÊTE (ÉTABLISSEMENTS)
echo "
   <tr class='ligneTabQuad'>
      <td rowspan='2'>&nbsp;</td>";

// BOUCLE SUR LES ÉTABLISSEMENTS
foreach ($lesEtabOffrantChambres as $unEtab) {
    $nom = $unEtab->getNom();

    // La colonne d'en-tête établissement regroupe autant de colonnes 
    // qu'il existe de types de chambres 
    echo "
         <td width='$pourcCol%' colspan='$nbTypesChambres'><center>$nom</center>
         </td>";
}
echo "
   </tr>";

// AFFICHAGE DE LA 3ÈME LIGNE D'EN-TÊTE (LIGNE AVEC C1, C2, ..., C1, C2, ...)
echo "
   <tr class='ligneTabQuad'>";

// BOUCLE BASÉE SUR LE CRITÈRE ÉTABLISSEMENT 
foreach ($lesEtabOffrantChambres as $unEtab) {
    $idEtab = $unEtab->getId();
    // BOUCLE BASÉE SUR LES TYPES DE CHAMBRES
    // Pour chaque établissement, on affiche forcément chaque type de 
    // chambre avec un fond gris si le type de chambre n'est pas proposé et
    // avec un fond vert associé au nombre de chambres libres si le type de
    // chambre est proposé et qu'il reste des chambres libres de ce type.
    // Si le type de chambre est proposé dans l'établissement et qu'il ne
    // reste plus de chambres libres de ce type, l'affichage est effectué
    // sans fond particulier
    foreach ($lesTypesChambres as $unTypeChambre) {
        $idTypeChambre = $unTypeChambre->getId();
//        $nbOffre = obtenirNbOffre($connexion, $idEtab, $idTypeChambre);
        $uneOffre = OffreDAO::getOneById($idEtab, $idTypeChambre);
        if (is_null($uneOffre)) {
            $nbOffre = 0;
        } else {
            $nbOffre = $uneOffre->getNbChambres();
        }
        if ($nbOffre == 0) {
            // Affichage du type de chambre sur fond gris
            echo "<td class='absenceOffre'>$idTypeChambre<br>&nbsp;</td>";
        } else {
            // Recherche du nombre de chambres occupées pour l'établissement 
            // et le type de chambre courants
//            $nbOccup = obtenirNbOccup($connexion, $idEtab, $idTypeChambre);
            $nbOccup = AttributionDAO::getNbOccupiedRooms($idEtab, $idTypeChambre);


            // Calcul du nombre de chambres libres
            $nbChLib = $nbOffre - $nbOccup;

            // Pour un établissement et un code type chambre, on affiche le
            // type chambre sur fond vert avec le nombre de chambres libres
            // s'il y a des chambres libres sinon seul le type chambre est 
            // affiché               
            if ($nbChLib != 0) {
                echo "<td class='libre'>$idTypeChambre<br>$nbChLib</td>";
            } else {
                echo "<td class='reserveSiLien'>$idTypeChambre<br>&nbsp;
                  </td>";
            }
        }
    } // Fin de la boucle des types de chambres
} // Fin de la boucle basée sur le critère établissement
echo "
   </tr>";

// 4ÈME PARTIE : CORPS DU TABLEAU : CONSTITUTION D'UNE LIGNE PAR GROUPE À 
// HÉBERGER AVEC LES CHAMBRES ATTRIBUÉES ET LES LIENS POUR EFFECTUER OU
// MODIFIER LES ATTRIBUTIONS

$lesGroupes = GroupeDAO::getAllToHost();

// BOUCLE SUR LES GROUPES À HÉBERGER 
foreach ($lesGroupes as $unGroupe) {
    $idGroupe = $unGroupe->getId();
    $nom = $unGroupe->getNom();
    echo "
      <tr class='ligneTabQuad'>
         <td align='center' width='25%'>$nom</td>";

    // BOUCLE SUR LES ÉTABLISSEMENTS
    foreach ($lesEtabOffrantChambres as $unEtab) {
        $idEtab = $unEtab->getId();
        // BOUCLE SUR LES TYPES DE CHAMBRES
        foreach ($lesTypesChambres as $unTypeChambre) {
            $idTypeChambre = $unTypeChambre->getId();
            // Pour chaque cellule, 4 cas possibles :
            // 1) type chambre inexistant dans cet étab : fond gris, 
            // 2) des chambres ont déjà été attribuées au groupe pour cet
            //    étab et ce type de chambre : fond jaune avec le nb de 
            //    chambres attribuées et lien permettant de modifier le nb,
            // 3) aucune chambre du type en question n'a encore été attribuée
            //    au groupe dans cet étab et il n'y a plus de chambres libres
            //    de ce type dans l'étab : cellule vide,
            // 4) aucune chambre du type en question n'a encore été attribuée
            //    au groupe dans cet étab et il reste des chambres libres de 
            //    ce type dans l'établissement : affichage d'un lien pour 
            //    faire une attribution
//            $nbOffre = obtenirNbOffre($connexion, $idEtab, $idTypeChambre);
            $uneOffre = OffreDAO::getOneById($idEtab, $idTypeChambre);
            if (is_null($uneOffre)) {
                $nbOffre = 0;
            } else {
                $nbOffre = $uneOffre->getNbChambres();
            }
            if ($nbOffre == 0) {
                // Affichage d'une cellule vide sur fond gris 
                echo "<td class='absenceOffre'>&nbsp;</td>";
            } else {
//                $nbOccup = obtenirNbOccup($connexion, $idEtab, $idTypeChambre);
                $nbOccup = AttributionDAO::getNbOccupiedRooms($idEtab, $idTypeChambre);

                // Calcul du nombre de chambres libres
                $nbChLib = $nbOffre - $nbOccup;

                // On recherche si des chambres du type en question ont déjà
                // été attribuées à ce groupe dans cet établissement
//                $nbOccupGroupe = obtenirNbOccupGroupe($connexion, $idEtab, $idTypeChambre, $idGroupe);
                /* @var $uneAttrib modele\metier\Attribution */
                $uneAttrib = AttributionDAO::getOneById($idEtab, $idTypeChambre, $idGroupe);
                if (!is_null($uneAttrib)) {
                    $nbOccupGroupe = $uneAttrib->getNbChambres();
                } else {
                    $nbOccupGroupe = 0;
                }
                if ($nbOccupGroupe != 0) {
                    // Le nombre de chambres maximum pouvant être 
                    // demandées est la somme du nombre de chambres 
                    // libres et du nombre de chambres actuellement 
                    // attribuées au groupe
                    $nbMax = $nbChLib + $nbOccupGroupe;
                    echo "
                     <td class='reserve'>
                     <a href='cAttributionChambres.php?action=donnerNbChambres&idEtab=$idEtab&idTypeChambre=$idTypeChambre&idGroupe=$idGroupe&nbChambres=$nbMax'>
                     $nbOccupGroupe</a></td>";
                } else {
                    // Cas où il n'y a pas de chambres de ce type 
                    // attribuées à ce groupe dans cet établissement : 
                    // on affiche un lien vers donnerNbChambres s'il y a 
                    // des chambres libres sinon rien n'est affiché     
                    if ($nbChLib != 0) {
                        echo "
                        <td class='reserveSiLien'>
                        <a href='cAttributionChambres.php?action=donnerNbChambres&idEtab=$idEtab&idTypeChambre=$idTypeChambre&idGroupe=$idGroupe&nbChambres=$nbChLib'>
                        __</a></td>";
                    } else {
                        echo "<td class='reserveSiLien'>&nbsp;</td>";
                    }
                }
            }
        } // Fin de la boucle sur les types de chambres
    } // Fin de la boucle sur les établissements       
} // Fin de la boucle sur les groupes à héberger
echo "
</table>"; // Fin du tableau principal
// AFFICHAGE DE LA LÉGENDE
echo "
<table width='70%' align=center>
   <tr>
      <br>
	    <td class='reserveSiLien' height='10'>&nbsp;</td>
      <td width='21%' align='left'>Réservation possible si lien affiché</td>
      <td class='absenceOffre' height='10'>&nbsp;</td>
      <td width='21%' align='left'>Absence d'offre</td>
      <td class='reserve' height='10'>&nbsp;</td>
      <td width='21%' align='left'>Nombre de places réservées</td>
      <td class='libre' height='10'>&nbsp;</td>
      <td width='21%' align='left'>Nombre de places encore disponibles</td>
   </tr>
</table>";
echo "<br><center><a href='cAttributionChambres.php'>Retour</a></center>";

include("includes/_fin.inc.php");

