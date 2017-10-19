/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  sjudais
 * Created: 19 oct. 2017
 */

ALTER TABLE Representation
ADD CONSTRAINT fk_representation_lieu FOREIGN KEY(id_lieu) REFERENCES (id)
ADD CONSTRAINT fk_representation_groupe FOREIGN KEY(id_groupe) REFERENCES (id);