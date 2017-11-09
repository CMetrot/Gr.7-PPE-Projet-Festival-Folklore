<?php
use modele\dao\DaoRepresentation;
use modele\dao\AttributionDAO;
use modele\dao\Bdd;
require_once __DIR__.'/../../includes/autoload.php';

include("includes/_debut.inc.php");

echo "
    <br>
    <table width='55%' cellspacing='0' cellpadding='0' class='tabNonQuadrille'>
    <tr class='enTeteTabQuad'>
        <td colspan='4' width='35%'>Lieu</td>
        <td colspan='4' width='35%'>Groupe</td>
        <td colspan='4' width='10%'>Heure début</td>
        <td colspan='4' width='10%'>Heure fin</td>
    </tr>";



$lesRepresentations = DaoRepresentation::getAll();
// BOUCLE SUR LES REPRESENTATIONS
foreach ($lesRepresentations as $uneRepresentation) {
    $id = $uneRepresentation->getLieu()->getId();
    $nom = $uneRepresentation->getGroupe()->getId();
echo "
    <tr class='ligneTabNonQuad'>
         <td colspan='4' width='35%'></td>";

}