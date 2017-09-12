<?php

use modele\dao\EtablissementDAO;
use modele\metier\Etablissement;
use modele\dao\Bdd;

require_once __DIR__ . '/../../includes/autoload.php';
Bdd::connecter();

include("includes/_debut.inc.php");

// OBTENIR LE DÉTAIL DE L'ÉTABLISSEMENT SÉLECTIONNÉ

$unEtab = EtablissementDAO::getOneById($id);
/* @var $unEtab Etablissement  */
$nom = $unEtab->getNom();
$adresseRue = $unEtab->getAdresse();
$codePostal = $unEtab->getCdp();
$ville = $unEtab->getVille();
$tel = $unEtab->getTel();
$adresseElectronique = $unEtab->getEmail();
$type = $unEtab->getTypeEtab();
$civiliteResponsable = $unEtab->getCiviliteResp();
$nomResponsable = $unEtab->getNomResp();
$prenomResponsable = $unEtab->getPrenomResp();


echo "
<br>
<table width='60%' cellspacing='0' cellpadding='0' class='tabNonQuadrille'>
   
   <tr class='enTeteTabNonQuad'>
      <td colspan='3'><strong>$nom</strong></td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td  width='20%'> Id: </td>
      <td>$id</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> Adresse: </td>
      <td>$adresseRue</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> Code postal: </td>
      <td>$codePostal</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> Ville: </td>
      <td>$ville</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> Téléphone: </td>
      <td>$tel</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> E-mail: </td>
      <td>$adresseElectronique</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> Type: </td>";
if ($type == 1) {
    echo "<td> Etablissement scolaire </td>";
} else {
    echo "<td> Autre établissement </td>";
}
echo "
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> Responsable: </td>
      <td>$civiliteResponsable&nbsp; $nomResponsable&nbsp; $prenomResponsable
      </td>
   </tr> 
</table>
<br>
<a href='cGestionEtablissements.php'>Retour</a>";

include("includes/_fin.inc.php");

