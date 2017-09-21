<?php
use modele\dao\GroupeDAO;
use modele\metier\Groupe;
use modele\dao\Bdd;
require_once __DIR__.'/../../includes/autoload.php';
Bdd::connecter();

include("includes/_debut.inc.php");

// CRÉER OU MODIFIER UN GROUPE
// S'il s'agit d'une création et qu'on ne "vient" pas de ce formulaire (on 
// "vient" de ce formulaire uniquement s'il y avait une erreur), il faut définir 
// les champs à vide sinon on affichera les valeurs précédemment saisies
if ($action == 'demanderCreerGroupe') {
    $id = '';
    $identiteResponsable = '';
    $adressePostale = '';
    $nombrePersonnes = '';
    $nomPays = '';
    $hebergement = '';
//    $adresseElectronique = '';
//    $type = 0;
//    $civiliteResponsable = 'Monsieur';
//    $nomResponsable = '';
//    $prenomResponsable = '';
}

// S'il s'agit d'une modification et qu'on ne "vient" pas de ce formulaire, il
// faut récupérer les données sinon on affichera les valeurs précédemment 
// saisies
if ($action == 'demanderModifierEtab') {
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
}

// Initialisations en fonction du mode (création ou modification) 
if ($action == 'demanderCreerEtab' || $action == 'validerCreerEtab') {
    $creation = true;
    $message = "Nouvel établissement";  // Alimentation du message de l'en-tête
    $action = "validerCreerEtab";
} else {
    $creation = false;
    $message = "$nom ($id)";            // Alimentation du message de l'en-tête
    $action = "validerModifierEtab";
}

// Déclaration du tableau des civilités
$tabCivilite = array("Monsieur", "Madame", "Mademoiselle");

echo "
<form method='POST' action='cGestionEtablissements.php?'>
   <input type='hidden' value='$action' name='action'>
   <br>
   <table width='85%' cellspacing='0' cellpadding='0' class='tabNonQuadrille'>
   
      <tr class='enTeteTabNonQuad'>
         <td colspan='3'><strong>$message</strong></td>
      </tr>";

// En cas de création, l'id est accessible sinon l'id est dans un champ
// caché               
if ($creation) {
    // On utilise les guillemets comme délimiteur de champ dans l'echo afin
    // de ne pas perdre les éventuelles quotes saisies (même si les quotes
    // ne sont pas acceptées dans l'id, on a le souci de ré-afficher l'id
    // tel qu'il a été saisi) 
    echo '
         <tr class="ligneTabNonQuad">
            <td> Id*: </td>
            <td><input type="text" value="' . $id . '" name="id" size ="10" 
            maxlength="8"></td>
         </tr>';
} else {
    echo "
         <tr>
            <td><input type='hidden' value='$id' name='id'></td><td></td>
         </tr>";
}
echo '
      <tr class="ligneTabNonQuad">
         <td> Nom*: </td>
         <td><input type="text" value="' . $nom . '" name="nom" size="50" 
         maxlength="45"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Adresse*: </td>
         <td><input type="text" value="' . $adresseRue . '" name="adresseRue" 
         size="50" maxlength="45"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Code postal*: </td>
         <td><input type="text" value="' . $codePostal . '" name="codePostal" 
         size="7" maxlength="5"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Ville*: </td>
         <td><input type="text" value="' . $ville . '" name="ville" size="40" 
         maxlength="35"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Téléphone* : </td>
         <td><input type="text" value="' . $tel . '" name="tel" size ="20" 
         maxlength="10" placeholder="10 Chiffres"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> E-mail: </td>
         <td><input type="text" value="' . $adresseElectronique . '" name=
         "adresseElectronique" size ="75" maxlength="70"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Type*: </td>
         <td>';
if ($type == 1) {
    echo " 
               <input type='radio' name='type' value='1' checked>  
               Etablissement Scolaire
               <input type='radio' name='type' value='0'>  Autre";
} else {
    echo " 
                <input type='radio' name='type' value='1'> 
                Etablissement Scolaire
                <input type='radio' name='type' value='0' checked> Autre";
}
echo "
           </td>
         </tr>
         <tr class='ligneTabNonQuad'>
            <td colspan='2' ><strong>Responsable:</strong></td>
            
         </tr>
         <tr class='ligneTabNonQuad'>
            <td> Civilité*: </td>
            <td> <select name='civiliteResponsable'>";
for ($i = 0; $i < 3; $i = $i + 1) {
    if ($tabCivilite[$i] == $civiliteResponsable) {
        echo "<option selected>$tabCivilite[$i]</option>";
    } else {
        echo "<option>$tabCivilite[$i]</option>";
    }
}
echo '
               </select>&nbsp; &nbsp; &nbsp; &nbsp; Nom*: 
               <input type="text" value="' . $nomResponsable . '" name=
               "nomResponsable" size="26" maxlength="25">
               &nbsp; &nbsp; &nbsp; &nbsp; Prénom: 
               <input type="text"  value="' . $prenomResponsable . '" name=
               "prenomResponsable" size="26" maxlength="25">
            </td>
         </tr>
   </table>';
echo "
   <table align='center' cellspacing='15' cellpadding='0'>
      <tr>
         <td align='right'><input type='submit' value='Valider' name='valider'>
         </td>
         <td align='left'><input type='reset' value='Annuler' name='annuler'>
         </td>
      </tr>
   </table>
   <a href='cGestionEtablissements.php'>Retour</a>
</form>";

include("includes/_fin.inc.php");

