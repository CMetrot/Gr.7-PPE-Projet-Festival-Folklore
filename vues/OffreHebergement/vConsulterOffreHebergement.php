<?php
use \modele\dao\TypeChambreDAO;
use modele\dao\EtablissementDAO;
use modele\dao\OffreDAO;
use modele\dao\Bdd;
require_once __DIR__ . '/../../includes/autoload.php';
Bdd::connecter();

include("includes/_debut.inc.php");

// CONSULTER LES OFFRES DE TOUS LES ÉTABLISSEMENTS
// IL FAUT QU'IL Y AIT AU MOINS UN ÉTABLISSEMENT ET UN TYPE CHAMBRE POUR QUE 
// L'AFFICHAGE SOIT EFFECTUÉ
$lesEtablissements = EtablissementDAO::getAll();
$nbEtab = count($lesEtablissements);
$lesTypesChambres = TypeChambreDAO::getAll();
$nbTypesChambres = count($lesTypesChambres);

if ($nbEtab != 0 && $nbTypesChambres != 0) {
    // POUR CHAQUE ÉTABLISSEMENT : AFFICHAGE DU NOM ET D'UN TABLEAU COMPORTANT 1
    // LIGNE D'EN-TÊTE ET 1 LIGNE PAR TYPE DE CHAMBRE

    // BOUCLE SUR LES ÉTABLISSEMENTS
    foreach ($lesEtablissements as $unEtablissement) {
        $idEtab = $unEtablissement->getId();
        $nom = $unEtablissement->getNom();

        // AFFICHAGE DU NOM DE L'ÉTABLISSEMENT ET D'UN LIEN VERS LE FORMULAIRE DE
        // MODIFICATION
        echo "<strong>$nom</strong><br>
      <a href='cOffreHebergement.php?action=demanderModifierOffre&idEtab=$idEtab'>
      Modifier</a>
   
      <table width='45%' cellspacing='0' cellpadding='0' class='tabQuadrille'>";

        // AFFICHAGE DE LA LIGNE D'EN-TÊTE
        echo "
         <tr class='enTeteTabQuad'>
            <td width='30%'>Type</td>
            <td width='35%'>Capacité</td>
            <td width='35%'>Nombre de chambres</td> 
         </tr>";

        // BOUCLE SUR LES TYPES DE CHAMBRES (AFFICHAGE D'UNE LIGNE PAR TYPE DE 
        // CHAMBRE AVEC LE NOMBRE DE CHAMBRES OFFERTES DANS L'ÉTABLISSEMENT POUR 
        // LE TYPE DE CHAMBRE)
        foreach ($lesTypesChambres as $unTypeChambre) {

            echo " 
            <tr class='ligneTabQuad'>
               <td>".$unTypeChambre->getId()."</td>
               <td>".$unTypeChambre->getLibelle()."</td>";
            // On récupère le nombre de chambres offertes pour l'établissement 
            // et le type de chambre actuellement traités
//            $nbOffre = obtenirNbOffre($connexion, $idEtab, $unTypeChambre->getId());
            $uneOffre = OffreDAO::getOneById($unEtablissement->getId(), $unTypeChambre->getId());
            if (is_null($uneOffre)){
                $nbOffre = 0;
            }else{
                $nbOffre = $uneOffre->getNbChambres();
            }
            echo "
               <td>$nbOffre</td>
            </tr>";
        }
        echo "
      </table><br>";
    }
}

include("includes/_fin.inc.php");

