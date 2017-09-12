<?php

namespace modele\dao;

use modele\metier\Offre;
use modele\metier\Etablissement;
use modele\metier\TypeChambre;
use PDO;

/**
 * Description of OffreDAO
 * Classe métier :  Offre
 * @author prof
 * @version 2017
 */
class OffreDAO {

    /**
     * crée un objet métier à partir d'un enregistrement de la table OFFRE et des tables liées
     * @param array $enreg Description
     * @return Offre objet métier obtenu
     */
    protected static function enregVersMetier($enreg) {
        $idEtab = $enreg['IDETAB'];
        $idTypeChambre = $enreg['IDTYPECHAMBRE'];
        $nbChambre = $enreg['NOMBRECHAMBRES'];
        // construire les objets Etablissement et TypeChambre à partir de leur identifiant       
        $objetEtab = EtablissementDAO::getOneById($idEtab);
        $objetTypeCh = TypeChambreDAO::getOneById($idTypeChambre);
        // instancier l'objet Offre
        $objetMetier = new Offre($objetEtab, $objetTypeCh, $nbChambre);

        return $objetMetier;
    }

    /**
     * Complète une requête préparée
     * les paramètres de la requête associés aux valeurs des attributs d'un objet métier
     * @param Offre $objetMetier
     * @param PDOStatement $stmt
     */
    protected static function metierVersEnreg(Offre $objetMetier, \PDOStatement $stmt) {
        // On utilise bindValue plutôt que bindParam pour éviter des variables intermédiaires
        /* @var $etab Etablissement */
        $etab = $objetMetier->getEtablissement();
        /* @var $typeCh TypeChambre */
        $typeCh = $objetMetier->getTypeChambre();
        $stmt->bindValue(':idEtab', $etab->getId());
        $stmt->bindValue(':idTypeCh', $typeCh->getId());
        $stmt->bindValue(':nb', $objetMetier->getNbChambres());
    }

    /**
     * Retourne la liste de toutes les offres
     * @return array tableau d'objets de type Offre
     */
    public static function getAll() {
        $lesObjets = array();
        $requete = "SELECT * FROM Offre";
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
     * Construire un objet d'après son identifiant, à partir des des enregistrements de la table Offre
     * L'identifiant de la table Offre est composé : ($idEtab, $idTypeChambre)
     * @param string $idEtab identifiant de l'établissement émetteur de l'offre
     * @param string $idTypeChambre identifiant du type de chambre concerné par l'offre
     * @return Offre : objet métier si trouvé dans la BDD, null sinon
     */
    public static function getOneById($idEtab, $idTypeChambre) {
        $objetConstruit = null;
        $requete = "SELECT * FROM Offre WHERE IDETAB = :idEtab AND IDTYPECHAMBRE = :idTypeCh";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idTypeCh', $idTypeChambre);
        $ok = $stmt->execute();
        // attention, $ok = true pour un select ne retournant aucune ligne
        if ($ok && $stmt->rowCount() > 0) {
            $objetConstruit = self::enregVersMetier($stmt->fetch(PDO::FETCH_ASSOC));
        }

        return $objetConstruit;
    }

    /**
     * Détruire un enregistrement de la table OFFRE d'après son identifiant
     * @param string $idEtab identifiant de l'établissement émetteur de l'offre
     * @param string $idTypeCh identifiant du type de chambre concerné par l'offre
     * @return boolean =TRUE si l'enregistrement est détruit, =FALSE si l'opération échoue
     */
    public static function delete($idEtab, $idTypeCh) {
        $ok = false;
        $requete = "DELETE FROM Offre "
                . " WHERE IDETAB=:idEtab AND IDTYPECHAMBRE=:idTypeCh";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idTypeCh', $idTypeCh);
        $ok = $stmt->execute();
        return ($ok && $stmt->rowCount() > 0);
    }

   /**
     * Insérer un nouvel enregistrement dans la table à partir de l'état d'un objet métier
     * @param Offre objet métier à insérer
     * @return boolean =FALSE si l'opération échoue
     */
    public static function insert(Offre $objet) {
        $ok = false;
        $requete = "INSERT INTO Offre "
                . "  VALUES(:idEtab, :idTypeCh, :nb)";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($objet, $stmt);
        $ok = $stmt->execute();
        return ($ok && $stmt->rowCount() > 0);
    }

   /**
     * Insérer un nouvel enregistrement dans la table à partir des valeurs à insérer
     * @param string $idEtab identifiant de l'établissement émetteur de l'offre
     * @param string $idTypeCh identifiant du type de chambre concerné par l'offre
    *  @param int $nb nombre de lits pour cette offre
     * @return boolean =FALSE si l'opération échoue
     */
    public static function insertValues($idEtab, $idTypeCh, $nb) {
        $ok = false;
        $requete = "INSERT INTO Offre "
                . "  VALUES(:idEtab, :idTypeCh, :nb)";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idTypeCh', $idTypeCh);
        $stmt->bindParam(':nb', $nb);
        $ok = $stmt->execute();
        return ($ok && $stmt->rowCount() > 0);
    }

    /**
     * Mise à jour du nombre de chambres associé à une offre
     * @param string $idEtab identifiant de l'établissement concerné par l'offre
     * @param string $idTypeCh identifiant du type de chambre concerné par l'offre
     * @param int $nb nouveau nombre de chambre 
     * @return boolean =true si la mise à jour a été correcte
     */
    public static function update($idEtab, $idTypeCh, $nb) {
        $ok = false;
        $offreLue = self::getOneById($idEtab, $idTypeCh);
        $offreLue->setNbChambres($nb);
        $requete = "UPDATE Offre "
                . " SET NOMBRECHAMBRES=:nb "
                . " WHERE IDETAB=:idEtab AND IDTYPECHAMBRE=:idTypeCh";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($offreLue, $stmt);
        $ok = $stmt->execute();
        return ($ok && $stmt->rowCount() > 0);
    }

}
