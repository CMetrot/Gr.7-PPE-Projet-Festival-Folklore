<?php
namespace modele\metier;

/**
 * Description of Attribution
 * Une instance d'Attribution représente le fait qu'un groupe 
 * bénéficie d'une offre (un type de chambre dans un établissement)
 * pour un certain nombre de chabres
 * @author btssio
 */
class Attribution {
    /**
     * @var Offre
     */
    private $offre;
    /**
     * @var Groupe 
     */
    private $groupe;
    /**
     * @var integer
     */
    private $nbChambres;
 
    function __construct(Offre $offre, Groupe $groupe, $nbChambres) {
        $this->offre = $offre;
        $this->groupe = $groupe;
        $this->nbChambres = $nbChambres;
    }
    function getOffre() {
        return $this->offre;
    }

    function getGroupe() {
        return $this->groupe;
    }

    function getNbChambres() {
        return $this->nbChambres;
    }

    function setOffre(Offre $offre) {
        $this->offre = $offre;
    }

    function setGroupe(Groupe $groupe) {
        $this->groupe = $groupe;
    }

    function setNbChambres($nbChambres) {
        $this->nbChambres = $nbChambres;
    }


}
