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
    private $lieu;
    /**
     * groupe en représentation
     * @var Groupe
     */
    private $groupe;
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
        $this->lieu = $unLieu;
        $this->groupe = $unGroupe;
        $this->dateRep = $dateRep;
        $this->heureDeb = $heureDeb;
        $this->heureFin = $heureFin;
    }
    
    function getIdRep() {
        return $this->idRep;
    }

    function getLieu() {
        return $this->lieu;
    }

    function getGroupe() {
        return $this->groupe;
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

    function setLieu($lieu) {
        $this->lieu = $lieu;
    }

    function setIdGroupe($groupe) {
        $this->groupe = $groupe;
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
