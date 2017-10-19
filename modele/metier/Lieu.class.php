<?php
namespace modele\metier;

/**
 * Description of Lieu
 *
 * @author aroblin
 */
class Lieu {
    
    private $id;
    private $nom;
    private $adr;
    private $capacite;
    
    
    function __construct ($id, $nom, $adr, $capacite){
        $this->id = $id;
        $this->nom = $nom;
        $this->adr = $adr;
        $this->capacite = $capacite;
    }
    function getId() {
        return $this->id;
    }

    function getNom() {
        return $this->nom;
    }

    function getAdr() {
        return $this->adr;
    }

    function getCapacite() {
        return $this->capacite;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setAdr($adr) {
        $this->adr = $adr;
    }

    function setCapacite($capacite) {
        $this->capacite = $capacite;
    }


}
