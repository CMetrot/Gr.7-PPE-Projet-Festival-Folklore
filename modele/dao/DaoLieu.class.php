<?php
namespace modele\dao;


use modele\metier\Lieu;
use PDO;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modele\dao;

/**
 * Description of DaoLieu
 *
 * @author aroblin
 */
class DaoLieu {
    protected static function enregVersMetier(array $enreg) {
        $id = $enreg['id'];
        $nom = $enreg['nom'];
        $capacite = $enreg['capacite'];
        $adr = $enreg['adr'];
        $unLieu = new Lieu($id, $nom, $adr, $capacite);

        return $unLieu;
    }


    public static function getAll() {
        $lesObjets = array();
        $requete = "SELECT * FROM Lieu";
        $stmt = Bdd::getPdo()->prepare($requete);
        $ok = $stmt->execute();
        if ($ok) {
            // Tant qu'il y a des enregistrements dans la table
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                //ajoute un nouveau groupe au tableau
                $lesObjets[] = self::enregVersMetier($enreg);
            }
        }
        return $lesObjets;
    }

    /**
     * Recherche un groupe selon la valeur de son identifiant
     * @param string $id
     * @return Groupe le groupe trouvé ; null sinon
     */
    public static function getOneById($id) {
        $objetConstruit = null;
        $requete = "SELECT * FROM Lieu WHERE id = :id";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':id', $id);
        $ok = $stmt->execute();
        // attention, $ok = true pour un select ne retournant aucune ligne
        if ($ok && $stmt->rowCount() > 0) {
            $objetConstruit = self::enregVersMetier($stmt->fetch(PDO::FETCH_ASSOC));
        }
        return $objetConstruit;
    }


    /**
     * Retourne la liste des groupes attribués à un établissement donné
     * @param string $idEtab
     * @return array tableau d'éléments de type Groupe
     */
    public static function getAllByLieu($idLieu) {
        $lesLieux = array();  // le tableau à retourner
        $requete = "SELECT * FROM Lieu
                    WHERE id IN (
                    SELECT DISTINCT id FROM Lieu i
                            INNER JOIN Attribution a ON a.IDGROUPE = i.id 
                            WHERE IDETAB=:id
                    )";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':id', $idLieu);
        $ok = $stmt->execute();
        if ($ok) {
            // Tant qu'il y a des enregistrements dans la table
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                //ajoute un nouveau groupe au tableau
                $lesLieux[] = self::enregVersMetier($enreg);
            }
        } 
        return $lesLieux;
    }

    
    /**
     * Retourne la liste des groupes souhaitant un hébergement, ordonnée par id
     * @return array tableau d'éléments de type Groupe
     */
    public static function getAllToHost() {
        $lesLieux = array();
        $requete = "SELECT * FROM Lieu WHERE HEBERGEMENT='O' ORDER BY id";
        $stmt = Bdd::getPdo()->prepare($requete);
        $ok = $stmt->execute();
        if ($ok) {
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $lesLieux[] = self::enregVersMetier($enreg);
            }
        }
        return $lesLieux;
    }


    
    
}