Projet Festival (Festival Folklores du Monde de Saint Malo) en Php pour le module de PPE 2SLAM à La Joliverie (2017-2018)
- Version prof : réusinage terminé.
- Les scripts de création de la base de données MySql sont dans un sour-répertoire sql.
- Le projet est architecturé "façon MVC", mais pas de façon stricte : les vues contiennent des traitements
- phase de "réusinage" : création d'une couche modèle orientée objet, avec des classes métier et des classes DAO ; 
cette couche a été complétée en ajoutant les classes nécessaires pour gérer les offres d'hébergement ainsi que les attributions
d'offres aux groupes, et les classes DAO associées ; en intégrant l'usage de ces classes par les contrôleurs et les vues ;
les fonctions classiques ne sont plus utilisées : le répertoire "includes/gestionDonnees" a été supprimé.
Etapes suivantes :
    - Itération n°1 : installation et tests de l'existant
    - Itération 2 : page de consultation des groupes (objectif : se faire la main avec un développement simple)
    - Itération 3 : page de consultation des représentations (objectif : modéliser une association entre classes, mais en évitant les difficultés de codage des fonctionnalités de mise à jour)
    - Itération 4 ou 5 ou 6 au choix en fonction des capacités :
        - Itération 4 : authentification
        - Itération 5 : insertion/modification/suppression des groupes
        - Itération 6 : insertion/modification/suppression des représentations

