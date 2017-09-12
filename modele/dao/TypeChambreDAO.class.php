<?php

namespace modele\dao;

use modele\metier\TypeChambre;
use PDOStatement;
use PDO;

/**
 * Description of TypeChambreDAO
 * Classe métier  :  TypeChambre
 * @author prof
 * @version 2017
 */
class TypeChambreDAO {

    /**
     * crée un objet métier à partir d'un enregistrement
     * @param array $enreg
     * @return TypeChambre objet métier obtenu
     */
    protected static function enregVersMetier(array $enreg) {
        $id = $enreg['ID'];
        $libelle = $enreg['LIBELLE'];
        $objetMetier = new TypeChambre($id, $libelle);
        return $objetMetier;
    }

    /**
     * Complète une requête préparée
     * les paramètres de la requête associés aux valeurs des attributs d'un objet métier
     * @param TypeChambre $objetMetier
     * @param PDOStatement $stmt
     */
    protected static function metierVersEnreg(TypeChambre $objetMetier, PDOStatement $stmt) {
        $stmt->bindValue(':id', $objetMetier->getId());
        $stmt->bindValue(':libelle', $objetMetier->getLibelle());
    }
    
    /**
     * Retourne la liste de tous les types de chambres
     * @return array tableau d'objets de type TypeChambre
     */
    public static function getAll() {
        $lesObjets = array();
        $requete = "SELECT * FROM TypeChambre";
        $stmt = Bdd::getPdo()->prepare($requete);
        $ok = $stmt->execute();
        if ($ok) {
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $lesObjets[] = self::enregVersMetier($enreg);
            }
        }
        return $lesObjets;
    }

  /**
     * Recherche un type de chambre selon la valeur de son identifiant
     * @param string $id
     * @return TypeChambre le type de chambre trouvé ; null sinon
     */
    public static function getOneById($id) {
        $objetConstruit = null;
        $requete = "SELECT * FROM TypeChambre WHERE ID = :id";
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
     * Insérer un nouvel enregistrement dans la table à partir de l'état d'un objet métier
     * @param TypeChambre $objet objet métier à insérer
     * @return boolean =FALSE si l'opération échoue
     */
    public static function insert(TypeChambre $objet) {
        $ok = false;
        $requete = "INSERT INTO TypeChambre VALUES (:id, :libelle)";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($objet, $stmt);
        $ok = $stmt->execute();
        $ok = $ok && $stmt->rowCount() > 0;
        return $ok;
    }

    /**
     * Mettre à jour enregistrement dans la table à partir de l'état d'un objet métier
     * @param string identifiant de l'enregistrement à mettre à jour
     * @param TypeChambre $objet objet métier à mettre à jour
     * @return boolean =FALSE si l'opérationn échoue
     */
    public static function update($id, TypeChambre $objet) {
        $ok = false;
        $requete = "UPDATE TypeChambre SET LIBELLE = :libelle WHERE ID = :id";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($objet, $stmt);
        $stmt->bindParam(':id', $id);
        $ok = $stmt->execute();
        $ok = $ok && ($stmt->rowCount() > 0);
        return $ok;
    }

     /**
     * Détruire un enregistrement de la table TYPECHAMBRE d'après son identifiant
     * @param string identifiant de l'enregistrement à détruire
     * @return boolean =TRUE si l'enregistrement est détruit, =FALSE si l'opération échoue
     */
    public static function delete($id) {
        $ok = false;
        $requete = "DELETE FROM TypeChambre WHERE ID = :id";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':id', $id);
        $ok = $stmt->execute();
        $ok = $ok && ($stmt->rowCount() > 0);
        return $ok;
    }

    /**
     * Recherche si le libellé proposé existe déjà dans la base de données
     * @param boolean $estModeCreation =true si mode création, =false si modification
     * @param string $id id du type chambre à  vérifier
     * @param string $libelle 
     * @return int le nombre de libellés de types de chambres déjà existant dans la BD (0 ou 1) ; c'est donc aussi un booléen
     */
    public static function isAnExistingLibelle($estModeCreation, $id, $libelle) {
        $libelle = str_replace("'", "''", $libelle);
        // S'il s'agit d'une création, on vérifie juste la non existence du libellé
        // sinon on vérifie la non existence d'un autre type chambre (id!='$id') 
        // ayant le même libelle
        if ($estModeCreation) {
            $requete = "SELECT COUNT(*) FROM TypeChambre WHERE LIBELLE=:lib";
            $stmt = Bdd::getPdo()->prepare($requete);
            $stmt->bindParam(':lib', $libelle);
        } else {
            $requete = "SELECT COUNT(*) FROM TypeChambre WHERE LIBELLE=:lib and ID <> :id";
            $stmt = Bdd::getPdo()->prepare($requete);
            $stmt->bindParam(':lib', $libelle);
            $stmt->bindParam(':id', $id);
        }
        $stmt->execute();
        return $stmt->fetchColumn(0);
    }


    /**
     * Recherche un identifiant de type de chambre existant
     * @param string $id du type de chambre recherché
     * @return int le nombre de types de chambres correspondant à cet id (0 ou 1)
     */
    public static function isAnExistingId($id) {
        $requete = "SELECT COUNT(*) FROM TypeChambre WHERE ID=:id";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchColumn(0);
    }

}
