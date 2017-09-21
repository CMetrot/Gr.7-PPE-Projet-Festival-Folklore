<?php

namespace modele\dao;

use modele\metier\Attribution;
use \PDO;

/**
 * Description of AttributionDAO
 * Classe métier :  Attribution
 * @author prof
 * @version 2017
 */
class AttributionDAO {

    /**
     * Instancier un objet de la classe Attribution à partir d'un enregistrement de la table ATTRIBUTION
     * @param array $enreg
     * @return Attribution
     */
    protected static function enregVersMetier(array $enreg) {
        $idEtab = $enreg['IDETAB'];
        $idTypeChambre = $enreg['IDTYPECHAMBRE'];
        $idGroupe = $enreg['IDGROUPE'];
        $nbChambres = $enreg['NOMBRECHAMBRES'];
        // construire les objets Offre et Groupe à partir de leur identifiant       
        $objetOffre = OffreDAO::getOneById($idEtab, $idTypeChambre);
        $objetGroupe = GroupeDAO::getOneById($idGroupe);
        // instancier l'objet Attribution
        $objetMetier = new Attribution($objetOffre, $objetGroupe, $nbChambres);

        return $objetMetier;
    }

   /**
     * Complète une requête préparée
     * les paramètres de la requête associés aux valeurs des attributs d'un objet métier
     * @param Attribution $objetMetier
     * @param PDOStatement $stmt
     */
    protected static function metierVersEnreg(Attribution $objetMetier, \PDOStatement $stmt) {
        // On utilise bindValue plutôt que bindParam pour éviter des variables intermédiaires
        /* @var $offre Offre */
        $offre = $objetMetier->getOffre();
        /* @var $groupe Groupe */
        $groupe = $objetMetier->getGroupe();
        $stmt->bindValue(':idEtab', $offre->getEtablissement()->getId());
        $stmt->bindValue(':idTypeCh', $offre->getTypeChambre()->getId());
        $stmt->bindValue(':idGroupe', $groupe->getId());
        $stmt->bindValue(':nb', $objetMetier->getNbChambres());
    }

    /**
     * Retourne la liste de toutes les attributions
     * @return array tableau d'objets de type Attribution
     */
    public static function getAll() {
        $lesObjets = array();
        $requete = "SELECT * FROM Attribution";
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
     * Liste des objets Attribution concernant un établissement donné
     * @param string $idEtab : identifiant de l'établissement dont on filtre les attributions
     * @return array : tableau d'Attribution(s)
     */
    public static function getAllByIdEtab($idEtab) {
        $lesObjets = array();
        $requete = "SELECT * FROM Attribution WHERE IDETAB = :idEtab ";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idEtab', $idEtab);
        $ok = $stmt->execute();
        if ($ok) {
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $lesObjets[] = self::enregVersMetier($enreg);
            }
        }
        return $lesObjets;
    }

       /**
     * Liste des objets Attribution concernant un groupe donné
     * @param string $idGroupe : identifiant du groupe dont on filtre les attributions
     * @return array : tableau d'Attribution(s)
     */
    public static function getAllByIdGroupe($idGroupe) {
        $lesObjets = array();
        $requete = "SELECT * FROM Attribution WHERE IDGROUPE = :idGroupe ";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idGroupe', $idGroupe);
        $ok = $stmt->execute();
        if ($ok) {
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $lesObjets[] = self::enregVersMetier($enreg);
            }
        }
        return $lesObjets;
    }
    
    /**
     * Liste des objets Attribution concernant un établissement donné
     * @param string $idTypeCh : identifiant de l'établissement dont on filtre les attributions
     * @return array : tableau d'Attribution(s)
     */
    public static function getAllByIdTypeChambre($idTypeCh) {
        $lesObjets = array();
        $requete = "SELECT * FROM Attribution WHERE IDTYPECHAMBRE = :idTypeCh";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idTypeCh', $idTypeCh);
        $ok = $stmt->execute();
        if ($ok) {
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $lesObjets[] = self::enregVersMetier($enreg);
            }
        }
        return $lesObjets;
    }

    /**
     * Construire un objet d'après son identifiant, à partir des des enregistrements de la table ATTRIBUTION
     * L'identifiant de la table Attribution est composé : ($idEtab, $idTypeChambre, $idGroupe)
     * @param string $idEtab identifiant de l'établissement émetteur de l'attribution
     * @param string $idTypeChambre identifiant du type de chambre concerné par l'attribution
     * @param string $idGroupe identifiant du groupe concerné par l'attribution
     * @return Attribution : objet métier si trouvé dans la BDD, null sinon
     */
    public static function getOneById($idEtab, $idTypeChambre, $idGroupe) {
        $objetConstruit = null;
        $requete = "SELECT * FROM Attribution "
                . "WHERE IDETAB = :idEtab AND IDTYPECHAMBRE = :idTypeCh AND IDGROUPE = :idGroupe";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idTypeCh', $idTypeChambre);
        $stmt->bindParam(':idGroupe', $idGroupe);
        $ok = $stmt->execute();
        // attention, $ok = true pour un select ne retournant aucune ligne
        if ($ok && $stmt->rowCount() > 0) {
            $objetConstruit = self::enregVersMetier($stmt->fetch(PDO::FETCH_ASSOC));
        }

        return $objetConstruit;
    }

    /**
     * Détruire un enregistrement de la table ATTRIBUTION d'après son identifiant
     * @param string $idEtab identifiant de l'établissement émetteur de l'attribution
     * @param string $idTypeChambre identifiant du type de chambre concerné par l'attribution
     * @param string $idGroupe identifiant du groupe concerné par l'attribution
     * @return boolean =TRUE si l'enregistrement est détruit, =FALSE si l'opération échoue
     */
    public static function delete($idEtab, $idTypeCh, $idGroupe) {
        $ok = false;
        $requete = "DELETE FROM Attribution "
                . " WHERE IDETAB=:idEtab AND IDTYPECHAMBRE=:idTypeCh AND IDGROUPE=:idGroupe";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idTypeCh', $idTypeCh);
        $stmt->bindParam(':idGroupe', $idGroupe);
        $ok = $stmt->execute();
        return ($ok && $stmt->rowCount() > 0);
    }

    /**
     * Ajout d'un enregistrement dans la table Attribution
     * @param Attribution $objet attribution à créer
     * @return boolean =true si la mise à jour a été correcte
     */
    public static function insert(Attribution $objet) {
        /* @var $objet Attribution  */
        return self::insertValues($objet->getOffre()->getEtablissement()->getId()
                        , $objet->getOffre()->getTypeChambre()->getId()
                        , $objet->getGroupe()->getId()
                        , $objet->getNbChambres());
    }

    /**
     * Ajout d'un enregistrement dans la table Attribution
     * @param string $idEtab identifiant de l'établissement concerné par l'attribution
     * @param string $idTypeCh identifiant du type de chambre concerné par l'attribution
     * @param string $idGroupe identifiant du groupee concerné par l'attribution
     * @param int $nb nombre de chambres attribuées
     * @return boolean =true si la mise à jour a été correcte
     */
    public static function insertValues($idEtab, $idTypeCh, $idGroupe, $nb) {
        $ok = false;
        $requete = "INSERT INTO Attribution "
                . "  VALUES(:idEtab, :idTypeCh, :idGroupe, :nb)";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idTypeCh', $idTypeCh);
        $stmt->bindParam(':idGroupe', $idGroupe);
        $stmt->bindParam(':nb', $nb);
        $ok = $stmt->execute();
        return ($ok && $stmt->rowCount() > 0);
    }

    /**
     * Mise à jour du nombre de chambres associé à une attribution
     * @param string $idEtab identifiant de l'établissement concerné par l'attribution
     * @param string $idTypeCh identifiant du type de chambre concerné par l'attribution
     * @param string $idGroupe identifiant du groupee concerné par l'attribution
     * @param int $nb nouveau nombre de chambres
     * @return boolean =true si la mise à jour a été correcte
     */
    public static function update($idEtab, $idTypeCh, $idGroupe, $nb) {
        $ok = false;
        $attribLue = self::getOneById($idEtab, $idTypeCh, $idGroupe);
        $attribLue->setNbChambres($nb);
        $requete = "UPDATE Attribution "
                . " SET NOMBRECHAMBRES=:nb "
                . " WHERE IDETAB=:idEtab AND IDTYPECHAMBRE=:idTypeCh AND IDGROUPE=:idGroupe";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($attribLue, $stmt);
        $ok = $stmt->execute();
        return ($ok && $stmt->rowCount() > 0);
    }

    /**
     * Retourne le nombre de chambres occupées pour l'offre (idEtab, idTypeChambre) considérée
     * @param string $idEtab
     * @param string $idTypeChambre
     * @return integer nombre de chambres
     */
    public static function getNbOccupiedRooms($idEtab, $idTypeChambre) {
        $requete = "SELECT IFNULL(SUM(NOMBRECHAMBRES), 0) AS totalChambresOccup FROM Attribution "
                . " WHERE IDETAB=:idEtab AND IDTYPECHAMBRE=:idTypeCh";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idTypeCh', $idTypeChambre);
        $stmt->execute();
        $nb = $stmt->fetchColumn();
        return $nb;
    }


}
