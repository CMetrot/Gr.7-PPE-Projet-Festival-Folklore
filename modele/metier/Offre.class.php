<?php
namespace modele\metier;

/**
 * Description d'une offre d'hébergement
 * 
 * @author prof
 */
class Offre {
    /** établissement concerné par l'offre
     * @var modele\metier\Etablissement
     */
    private $etablissement;
    /**
     * type de chambre concerné par l'offre
     * @var modele\metier\TypeChambre
     */
    private $typeChambre;
    /**
     * nombre de chambres offertes
     * @var integer
     */
    private $nbChambres;
    
    function __construct(Etablissement $etablissement, TypeChambre $typeChambre, $nbChambre) {
        $this->etablissement = $etablissement;
        $this->typeChambre = $typeChambre;
        $this->nbChambres = $nbChambre;
    }

    function getEtablissement() {
        return $this->etablissement;
    }

    function getTypeChambre() {
        return $this->typeChambre;
    }

    function getNbChambres() {
        return $this->nbChambres;
    }

    function setEtablissement(Etablissement $etablissement) {
        $this->etablissement = $etablissement;
    }

    function setTypeChambre(TypeChambre $typeChambre) {
        $this->typeChambre = $typeChambre;
    }

    function setNbChambres($nbChambre) {
        $this->nbChambres = $nbChambre;
    }


    
}
