<?php
namespace modele\metier;

/**
 * Description of Etablissement
 * un établissement a des capacités d'hébergement à offrir au festival
 * @author prof
 */
class Etablissement {
    /**
     * code  de 8 caractères alphanum.
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $nom;
    /**
     * n° de rue et rue
     * @var string
     */
    private $adresse;
    /**
     * code postal
     * @var string 
     */
    private $cdp;
    /**
     * @var string
     */
    private $ville;
    /**
     * @var string
     */
    private $tel;
    /**
     * @var string
     */
    private $email;
    /**
     * type d'établissement
     * =1 : établissement scolaire ; =0 : autre
     * libellé "en dur" dans le code
     * @var integer 
     */
    private $typeEtab; 
    /**
     * Monsieur ou Madame
     * @var string 
     */
    private $civiliteResp;
    /**
     * nom du responsable de l'établissement
     * @var string
     */
    private $nomResp;
    /**
     * @var string
     */
    private $prenomResp;
    
    function __construct($id, $nom, $adresse, $cdp, $ville, $tel, $email, $typeEtab, $civiliteResp, $nomResp, $prenomResp) {
        $this->id = $id;
        $this->nom = $nom;
        $this->adresse = $adresse;
        $this->cdp = $cdp;
        $this->ville = $ville;
        $this->tel = $tel;
        $this->email = $email;
        $this->typeEtab = $typeEtab;
        $this->civiliteResp = $civiliteResp;
        $this->nomResp = $nomResp;
        $this->prenomResp = $prenomResp;
    }

    function getId() {
        return $this->id;
    }

    function getNom() {
        return $this->nom;
    }

    function getAdresse() {
        return $this->adresse;
    }

    function getCdp() {
        return $this->cdp;
    }

    function getVille() {
        return $this->ville;
    }

    function getTel() {
        return $this->tel;
    }

    function getEmail() {
        return $this->email;
    }

    function getTypeEtab() {
        return $this->typeEtab;
    }

    function getCiviliteResp() {
        return $this->civiliteResp;
    }

    function getNomResp() {
        return $this->nomResp;
    }

    function getPrenomResp() {
        return $this->prenomResp;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setAdresse($adresse) {
        $this->adresse = $adresse;
    }

    function setCdp($cdp) {
        $this->cdp = $cdp;
    }

    function setVille($ville) {
        $this->ville = $ville;
    }

    function setTel($tel) {
        $this->tel = $tel;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setTypeEtab($typeEtab) {
        $this->typeEtab = $typeEtab;
    }

    function setCiviliteResp($civiliteResp) {
        $this->civiliteResp = $civiliteResp;
    }

    function setNomResp($nomResp) {
        $this->nomResp = $nomResp;
    }

    function setPrenomResp($prenomResp) {
        $this->prenomResp = $prenomResp;
    }


    
}
