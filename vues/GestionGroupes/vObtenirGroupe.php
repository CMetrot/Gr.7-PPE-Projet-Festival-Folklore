<?php
use modele\dao\GroupeDAO;
use modele\dao\AttributionDAO;
use modele\dao\Bdd;
require_once __DIR__.'/../../includes/autoload.php';
Bdd::connecter();

include("includes/_debut.inc.php");

// AFFICHER L'ENSEMBLE DES GROUPES
// CETTE PAGE CONTIENT UN TABLEAU CONSTITUÉ D'1 LIGNE D'EN-TÊTE ET D'1 LIGNE PAR
// GROUPE

echo "
<br>
<table width='55%' cellspacing='0' cellpadding='0' class='tabNonQuadrille'>

   <tr class='enTeteTabNonQuad'>
      <td colspan='4'><strong>Groupe</strong></td>
   </tr>";

$lesGroupes = GroupeDAO::getAll();
// BOUCLE SUR LES GROUPES
foreach ($lesGroupes as $unGroupe) {
    $id = $unGroupe->getId();
    $nom = $unGroupe->getNom();
    echo "
		<tr class='ligneTabNonQuad'>
         <td width='52%'>$nom</td>
         
         <td width='16%' align='center'> 
         <a href='cGestionGroupes.php?action=detailGroupes&id=$id'>
         </a></td>
         
         <td width='16%' align='center'> 
         <a href='cGestionGroupes.php?action=demanderModifierGroupes&id=$id'>
         </a></td>";

    // S'il existe déjà des attributions pour le groupe, il faudra
    // d'abord les supprimer avant de pouvoir supprimer l'établissement
//    if (!existeAttributionsEtab($connexion, $id)) {
    $lesAttributionsDeCeGroupe = AttributionDAO::getAllByIdGroupe($id);
    if (count($lesAttributionsDeCeGroupe)==0) {
        echo "
            <td width='16%' align='center'> 
            <a href='cGestionGroupes.php?action=demanderSupprimerGroupe&id=$id'>
            </a></td>";
    } else {
        echo "
            <td width='16%'>&nbsp; </td>";
    }
    echo "
      </tr>";
}
echo "
</table>
<br>
<a href='cGestionGroupes.php?action=demanderCreerGroupe'>
</a >";

include("includes/_fin.inc.php");
