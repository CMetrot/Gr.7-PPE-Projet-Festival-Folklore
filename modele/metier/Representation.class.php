<?php
namespace modele\metier;

/**
 * Description of Representation
 *
 * @author cmetrot
 */
class Representation {
    
    /**
     * groupe en représentation
     * @var int
     */
    private $idRep;
    /**
     * groupe en représentation
     * @var Lieu
     */
    private $idLieu;
    /**
     * groupe en représentation
     * @var Groupe
     */
    private $idGroupe;
    /**
     * groupe en représentation
     * @var date
     */
    private $dateRep;
    /**
     * groupe en représentation
     * @var heure
     */
    private $heureDeb;
    /**
     * groupe en représentation
     * @var heure
     */
    private $heureFin;
    
    function __construct ($idRep, Lieu $unLieu, Groupe $unGroupe, $dateRep, $heureDeb, $heureFin){
        $this->idRep = $idRep;
        $this->idLieu = $unLieu;
        $this->idGroupe = $unGroupe;
        $this->dateRep = $dateRep;
        $this->heureDeb = $heureDeb;
        $this->heureFin = $heureFin;
    }
    
    function getIdRep() {
        return $this->idRep;
    }

    function getIdLieu() {
        return $this->idLieu;
    }

    function getIdGroupe() {
        return $this->idGroupe;
    }

    function getDateRep() {
        return $this->dateRep;
    }

    function getHeureDeb() {
        return $this->heureDeb;
    }

    function getHeureFin() {
        return $this->heureFin;
    }

    function setIdRep($idRep) {
        $this->idRep = $idRep;
    }

    function setIdLieu($idLieu) {
        $this->idLieu = $idLieu;
    }

    function setIdGroupe($idGroupe) {
        $this->idGroupe = $idGroupe;
    }

    function setDateRep($dateRep) {
        $this->dateRep = $dateRep;
    }

    function setHeureDeb($heureDeb) {
        $this->heureDeb = $heureDeb;
    }

    function setHeureFin($heureFin) {
        $this->heureFin = $heureFin;
    }
}
