/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  sjudais
 * Created: 19 oct. 2017
 */

/*Exécuter d'abord la première requète*/
INSERT INTO Representation (id_rep, id_lieu, id_groupe, date_rep, heure_deb, heure_fin)
VALUES
(1, 1, 'g012', '2017-11-07', '20:30:00', '21:45:00');
/*Exécuter le reste des requètes*/
INSERT INTO Representation (id_lieu, id_groupe, date_rep, heure_deb, heure_fin)
VALUES
(1, 'g014', '2017-11-07', '21:45:00', '23:00:00');