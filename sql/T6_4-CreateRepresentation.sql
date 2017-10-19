/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  sjudais
 * Created: 19 oct. 2017
 */
CREATE TABLE Representation (
    id_rep INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    id_lieu INT(11),
    id_groupe VARCHAR(4),
    date_rep DATE,
    heure_deb TIME,
    heure_fin TIME)

