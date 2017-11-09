<?php
use modele\dao\DaoRepresentation;
use modele\dao\AttributionDAO;
use modele\dao\Bdd;
require_once __DIR__.'/../../includes/autoload.php';

include("includes/_debut.inc.php");

echo "<h1 align='center'>Programme par jours</h1>";
$lesRepresentations = DaoRepresentation::getAll();
$dateprec = -1;
$x = -1;

foreach ($lesRepresentations as $uneRepresentation) {
    $dateRep = $uneRepresentation->getDateRep();

    if($x==-1){
        $dateprec=$dateRep;
        $x=$x+1;
  
        echo "<strong>$dateRep</strong><br>
        <table width='55%' cellspacing='0' cellpadding='0' class='tabQuadrille'>";
        
        echo "
        <tr class='enTeteTabQuad'>
            <td colspan='5' width='35%'>Lieu</td>
            <td colspan='5' width='35%'>Groupe</td>
            <td colspan='5' width='10%'>Heure début</td>
            <td colspan='5' width='10%'>Heure fin</td>
            <td colspan='5' width='15%'></a></td>
            <td colspan='5' width='15%'></a></td>
        </tr>";
        }

        If($dateprec!=$dateRep){
            $dateprec=$dateRep;
            echo"</table><br>";
            echo"<strong>$dateRep</strong><br>
                <table width='55%' cellspacing='0' cellpadding='0' class='tabQuadrille'>";
            echo"
            <tr class='enTeteTabQuad'>
            <td colspan='5' width='35%'>Lieu</td>
            <td colspan='5' width='35%'>Groupe</td>
            <td colspan='5' width='10%'>Heure début</td>
            <td colspan='5' width='10%'>Heure fin</td>
            <td colspan='5' width='15%'></a></td>
            <td colspan='5' width='15%'></a></td>
        </tr>";
        }
        
    $lieu = $uneRepresentation->getLieu()->getNom();
    $groupe = $uneRepresentation->getGroupe()->getNom();
    $heureDeb = $uneRepresentation->getHeureDeb();
    $heureFin = $uneRepresentation->getHeureFin();
echo "
    <tr class='ligneTabQuadrille'>
        <td colspan='5' width='35%'>$lieu</td>
        <td colspan='5' width='35%'>$groupe</td>
        <td colspan='5' width='10%'align='center'>$heureDeb</td>
        <td colspan='5' width='10%'align='center'>$heureFin</td>
        <td colspan='5' width='15%' align='center'><a href='#'>Modifier</a></td>
        <td colspan='5' width='15%' align='center'><a href='#'>Supprimer</a></td>
    </tr>";
}