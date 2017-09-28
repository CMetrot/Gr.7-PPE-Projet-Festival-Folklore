<!DOCTYPE html">
<html lang="fr">
    <head>
        <title>Festival</title>
        <meta http-equiv="Content-Language" content="fr">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="css/cssGeneral.css" rel="stylesheet" type="text/css">
        <link href="css/cssOnglets.css" rel="stylesheet" type="text/css">
    </head>
    <body class='basePage'>
        <div style="text-align:right;">SCAB (Steven_Judais | Corentin_Métrot | Alan_Roblin | Benjamin_LeMaoult)</div>
        <!--  Tableau contenant le titre et les menus -->
        <table width="100%" cellpadding="0" cellspacing="0">
            <!-- Titre -->
            <tr> 
                <td class="titre">Festival Folklores du Monde <br>
                    <span id="texteNiveau2" class="texteNiveau2">
                        H&eacute;bergement des groupes</span><br>&nbsp;
                        <img src="images/logo.jpg" style="height: 50px; width: 50px;"><img/>
                </td>
            </tr>
            <!-- Menus -->
            <tr> 
                <td>
                    <!-- On inclut le fichier de gestion des onglets ; si on a des 
                    menus traditionnels, il faudra inclure le fichier adéquat -->
                    <?php include("_onglets.inc.php"); ?>

                    <div id='barreMenus'>
                        <ul class='menus'>
                            <?php construireMenu("Accueil", "index.php", 1); ?>
                            <?php construireMenu("Gestion établissements", "cGestionEtablissements.php", 2); ?>
                            <?php construireMenu("Gestion types chambres", "cGestionTypesChambres.php", 3); ?>
                            <?php construireMenu("Offre hébergement", "cOffreHebergement.php", 4); ?>
                            <?php construireMenu("Attribution chambres", "cAttributionChambres.php", 5); ?>
                        </ul>
                    </div>

                </td>
            </tr>
            <!-- Fin des menus -->
            <tr>
                <td class="basePage">
                    <br><center><br>


