<?php

namespace modele\dao;

use modele\metier\Representation;
use modele\metier\Lieu;
use modele\metier\Groupe;
use \PDO;

/**
 * Description of EtablissementDAO
 * Classe métier : Etablissement
 * @author prof
 * @version 2017
 */
class DaoRepresentation {

    /**
     * Instancier un objet de la classe Etablissement à partir d'un enregistrement de la table ETABLISSEMENT
     * @param array $enreg
     * @return Etablissement
     */
     protected static function enregVersMetier(array $enreg) {
        $idRep = $enreg['ID_REP'];
        $idLieu = $enreg['ID_LIEU'];
        $idGroupe = $enreg['ID_GROUPE'];
        $dateRep = $enreg['DATE_REP'];
        $heureDeb = $enreg['HEURE_DEB'];
        $heureFin = $enreg['HEURE_FIN'];

        $lieu = DaoLieu::getOneById($idLieu);
        $groupe = GroupeDAO::getOneById($idGroupe);
        $uneRep = new Representation($idRep, $lieu, $groupe, $dateRep, $heureDeb, $heureFin);

        return $uneRep;
    }

    /**
     * Valorise les paramètres d'une requête préparée avec l'état d'un objet Etablissement
     * @param type $objetMetier un Etablissement
     * @param type $stmt requête préparée
     */
    protected static function metierVersEnreg(Representation $objetMetier, PDOStatement $stmt) {
        // On utilise bindValue plutôt que bindParam pour éviter des variables intermédiaires
        // Note : bindParam requiert une référence de variable en paramètre n°2 ; 
        // avec bindParam, la valeur affectée à la requête évoluerait avec celle de la variable sans
        // qu'il soit besoin de refaire un appel explicite à bindParam
        $stmt->bindValue(':id', $objetMetier->getId());
        $stmt->bindValue(':idLieu', $objetMetier->getLieu()->getId());
        $stmt->bindValue(':idGroupe', $objetMetier->getGroupe()->getId());
        $stmt->bindValue(':dateRep', $objetMetier->getDateRep());
        $stmt->bindValue(':heureDeb', $objetMetier->getHeureDeb());
        $stmt->bindValue(':heureFin', $objetMetier->getHeureFin());
    }

    /**
     * Retourne la liste de tous les Etablissements
     * @return array tableau d'objets de type Etablissement
     */
    public static function getAll() {
        $lesObjets = array();
        $requete = "SELECT * FROM Representation ORDER BY date_rep";
        $stmt = Bdd::getPdo()->prepare($requete);
        $ok = $stmt->execute();
        if ($ok) {
            // Pour chaque enregisterement
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // instancier un Etablissement et l'ajouter au tableau
                $lesObjets[] = self::enregVersMetier($enreg);
            }
        }
        return $lesObjets;
    }

   /**
     * Recherche un établissement selon la valeur de son identifiant
     * @param string $id
     * @return Etablissement la représentation trouvé ; null sinon
     */
     public static function getOneById($id) {
        $objetConstruit = null;
        $requete = "SELECT * FROM Representation WHERE ID_REP = :id";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':id', $id);
        $ok = $stmt->execute();
        // attention, $ok = true pour un select ne retournant aucune ligne
        if ($ok && $stmt->rowCount() > 0) {
            $objetConstruit = self::enregVersMetier($stmt->fetch(PDO::FETCH_ASSOC));
        }
        return $objetConstruit;
    }
//
//    
//    /**
//     * Insérer un nouvel enregistrement dans la table à partir de l'état d'un objet métier
//     * @param Etablissement $objet objet métier à insérer
//     * @return boolean =FALSE si l'opération échoue
//     */
//    public static function insert(Representation $objet) {
//        $requete = "INSERT INTO Etablissement VALUES (:id, :idLieu, :idGroupe, :dateRep, :heureDeb, :heureFin)";
//        $stmt = Bdd::getPdo()->prepare($requete);
//        self::metierVersEnreg($objet, $stmt);
//        $ok = $stmt->execute();
//        return ($ok && $stmt->rowCount() > 0);
//    }
//
//    /**
//     * Mettre à jour enregistrement dans la table à partir de l'état d'un objet métier
//     * @param string identifiant de l'enregistrement à mettre à jour
//     * @param Etablissement $objet objet métier à mettre à jour
//     * @return boolean =FALSE si l'opérationn échoue
//     */
//    public static function update($id, Etablissement $objet) {
//        $ok = false;
//        $requete = "UPDATE  Etablissement SET NOM=:nom, ADRESSERUE=:rue,
//           CODEPOSTAL=:cdp, VILLE=:ville, TEL=:tel,
//           ADRESSEELECTRONIQUE=:email, TYPE=:type,
//           CIVILITERESPONSABLE=:civ, NOMRESPONSABLE=:nomResp, PRENOMRESPONSABLE=:prenomResp 
//           WHERE ID=:id";
//        $stmt = Bdd::getPdo()->prepare($requete);
//        self::metierVersEnreg($objet, $stmt);
//        $stmt->bindParam(':id', $id);
//        $ok = $stmt->execute();
//        return ($ok && $stmt->rowCount() > 0);
//    }
//
//     /**
//     * Détruire un enregistrement de la table ETABLISSEMENT d'après son identifiant
//     * @param string identifiant de l'enregistrement à détruire
//     * @return boolean =TRUE si l'enregistrement est détruit, =FALSE si l'opération échoue
//     */
//    public static function delete($id) {
//        $ok = false;
//        $requete = "DELETE FROM Etablissement WHERE ID = :id";
//        $stmt = Bdd::getPdo()->prepare($requete);
//        $stmt->bindParam(':id', $id);
//        $ok = $stmt->execute();
//        $ok = $ok && ($stmt->rowCount() > 0);
//        return $ok;
//    }
//
//    /**
//     * Retourne la liste des établissements qui ont enregistré des offres
//     * @return array tableau d'établissements
//     */
//    public static function getAllOfferingRooms() {
//        $lesObjets = array();
//        $requete = "SELECT * FROM Etablissement 
//                WHERE ID IN 
//                   (SELECT DISTINCT ID
//                    FROM Offre o
//                    INNER JOIN Etablissement e ON e.ID = o.IDETAB
//                    ORDER BY ID)";
//        $stmt = Bdd::getPdo()->prepare($requete);
//        $ok = $stmt->execute();
//        if ($ok) {
//            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
//                $lesObjets[] = self::enregVersMetier($enreg);
//            }
//        }
//        return $lesObjets;
//    }
//    
//    /**
//     * Permet de vérifier s'il existe ou non un établissement ayant déjà le même identifiant dans la BD
//     * @param string $id identifiant de l'établissement à tester
//     * @return boolean =true si l'id existe déjà, =false sinon
//     */
//    public static function isAnExistingId($id) {
//        $requete = "SELECT COUNT(*) FROM Etablissement WHERE ID=:id";
//        $stmt = Bdd::getPdo()->prepare($requete);
//        $stmt->bindParam(':id', $id);
//        $stmt->execute();
//        return $stmt->fetchColumn(0);
//    }
//
//    /**
//     * Permet de vérifier s'il existe ou non un établissement portant déjà le même nom dans la BD
//     * En mode modification, l'enregistrement en cours de modification est bien entendu exclu du test
//     * @param boolean $estModeCreation =true si le test est fait en mode création, =false en mode modification
//     * @param string $id identifiant de l'établissement à tester
//     * @param string $nom nom de l'établissement à tester
//     * @return boolean =true si le nom existe déjà, =false sinon
//     */
//    public static function isAnExistingName($estModeCreation, $id, $nom) {
//        $nom = str_replace("'", "''", $nom);
//        // S'il s'agit d'une création, on vérifie juste la non existence du nom sinon
//        // on vérifie la non existence d'un autre établissement (id!='$id') portant 
//        // le même nom
//        if ($estModeCreation) {
//            $requete = "SELECT COUNT(*) FROM Etablissement WHERE NOM=:nom";
//            $stmt = Bdd::getPdo()->prepare($requete);
//            $stmt->bindParam(':nom', $nom);
//            $stmt->execute();
//        } else {
//            $requete = "SELECT COUNT(*) FROM Etablissement WHERE NOM=:nom AND ID<>:id";
//            $stmt = Bdd::getPdo()->prepare($requete);
//            $stmt->bindParam(':id', $id);
//            $stmt->bindParam(':nom', $nom);
//            $stmt->execute();
//        }
//        return $stmt->fetchColumn(0);
//    }

}
