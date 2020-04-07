<?php
/**
 * Copyright (C) 2017 Andrew SASSOYE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, version 3.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace JOBINGE\EntreprisesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="JOBINGE\EntreprisesBundle\Entity\EntreprisesRepository")
 * @ORM\Table(name="jobinge__entreprises")
 * @UniqueEntity(fields={"tva"}, message="Cette entreprise est déja enregistrée")
 */
class Entreprises
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string",
     *     length=20,
     *     unique=true,
     *     nullable=false
     * )
     *
     */
    protected $tva;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=100,
     *     nullable=false
     * )
     */
    protected $nom;

    /**
     * @Gedmo\Slug(fields={"nom"}, unique=true, updatable=true)
     * @ORM\Column(length=120, unique=false)
     */
    protected $nomSlug;

    /**
     * @ORM\OneToOne(
     *     targetEntity="AEES\UserBundle\Entity\User", cascade={"remove"}
     * )
     * @ORM\JoinColumn(name="contact_id", referencedColumnName="id")
     *
     */
    protected $contact = null;

    /**
     * @ORM\OneToMany(targetEntity="JOBINGE\ForumBundle\Entity\Inscription",
     *     mappedBy="company")
     */
    protected $inscriptions;

    /**
     * @ORM\OneToMany(targetEntity="JOBINGE\ForumBundle\Entity\Conference",
     *     mappedBy="company")
     */
    protected $conferences;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=100,
     *     nullable=false
     * )
     */
    protected $adresseSiege;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=10,
     *     nullable=false
     * )
     */
    protected $postalSiege;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=20,
     *     nullable=false
     * )
     */
    protected $villeSiege;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=20,
     *     nullable=false
     * )
     */
    protected $paysSiege;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=100,
     *     nullable=true
     * )
     */
    protected $adresseFacturation;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=10,
     *     nullable=true
     * )
     */
    protected $postalFacturation;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=20,
     *     nullable=true
     * )
     */
    protected $villeFacturation;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=100,
     *     nullable=true
     * )
     */
    protected $paysFacturation;

    /**
     * @ORM\Column(
     *     type="text",
     *     nullable=true
     * )
     */
    protected $presentation;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=100,
     *     nullable=true
     * )
     */
    protected $siteWeb;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=100,
     *     nullable=true
     * )
     */
    protected $facebook;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=100,
     *     nullable=true
     * )
     */
    protected $linkedIn;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=100,
     *     nullable=true
     * )
     */
    protected $twitter;


    /**
     * @ORM\Column(
     *     type="string",
     *     length=10,
     *     nullable=true
     * )
     */
    protected $chiffreAffaire;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=20,
     *     nullable=true
     * )
     */
    protected $effectifs;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=20,
     *     nullable=true
     * )
     */
    protected $nbUniversitaires;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=255,
     *     nullable=true
     * )
     */
    protected $personneRecrutement;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=255,
     *     nullable=true
     * )
     */
    protected $adresseRecrutement;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=255,
     *     nullable=true
     * )
     */
    protected $secteur;

    /**
     * @ORM\ManyToMany(targetEntity="JOBINGE\ForumBundle\Entity\Masters")
     * @ORM\JoinTable(name="jobinge__entreprises_master",
     *     joinColumns={@ORM\JoinColumn(name="entreprise_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="master_id", referencedColumnName="id")}
     * )
     */
    protected $masters;

    /**
     * @ORM\Column(
     *     type="text",
     *     nullable=true
     * )
     */
    protected $profilsRecherches;

    /**
     * @ORM\Column(
     *     type="text",
     *     nullable=true
     * )
     */
    protected $pointsForts;

    /**
     * @ORM\Column(
     *     type="text",
     *     nullable=true
     * )
     */
    protected $evolution;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=255,
     *     nullable=true
     * )
     */
    protected $implementation;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=255,
     *     nullable=true
     * )
     */
    protected $conseil;

    /**
     * @ORM\Column(
     *     type="datetime",
     *     nullable=false
     * )
     */
    protected $dateInscription;

    /**
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"})
     */
    protected $logo;

    /**
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"})
     */
    protected $logoHQ;


    /**
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"})
     */
    protected $pub;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->inscriptions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->nom;
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get tva
     *
     * @return string
     */
    public function getTva()
    {
        return $this->tva;
    }

    /**
     * Set tva
     *
     * @param string $tva
     *
     * @return Entreprises
     */
    public function setTva($tva)
    {
        $this->tva = $tva;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Entreprises
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        $this->nomSlug = null;

        return $this;
    }

    /**
     * Get adresseSiege
     *
     * @return string
     */
    public function getAdresseSiege()
    {
        return $this->adresseSiege;
    }

    /**
     * Set adresseSiege
     *
     * @param string $adresseSiege
     *
     * @return Entreprises
     */
    public function setAdresseSiege($adresseSiege)
    {
        $this->adresseSiege = $adresseSiege;

        return $this;
    }

    /**
     * Get postalSiege
     *
     * @return string
     */
    public function getPostalSiege()
    {
        return $this->postalSiege;
    }

    /**
     * Set postalSiege
     *
     * @param string $postalSiege
     *
     * @return Entreprises
     */
    public function setPostalSiege($postalSiege)
    {
        $this->postalSiege = $postalSiege;

        return $this;
    }

    /**
     * Get villeSiege
     *
     * @return string
     */
    public function getVilleSiege()
    {
        return $this->villeSiege;
    }

    /**
     * Set villeSiege
     *
     * @param string $villeSiege
     *
     * @return Entreprises
     */
    public function setVilleSiege($villeSiege)
    {
        $this->villeSiege = $villeSiege;

        return $this;
    }

    /**
     * Get paysSiege
     *
     * @return string
     */
    public function getPaysSiege()
    {
        return $this->paysSiege;
    }

    /**
     * Set paysSiege
     *
     * @param string $paysSiege
     *
     * @return Entreprises
     */
    public function setPaysSiege($paysSiege)
    {
        $this->paysSiege = $paysSiege;

        return $this;
    }

    /**
     * Get adresseFacturation
     *
     * @return string
     */
    public function getAdresseFacturation()
    {
        return $this->adresseFacturation;
    }

    /**
     * Set adresseFacturation
     *
     * @param string $adresseFacturation
     *
     * @return Entreprises
     */
    public function setAdresseFacturation($adresseFacturation)
    {
        $this->adresseFacturation = $adresseFacturation;

        return $this;
    }

    /**
     * Get postalFacturation
     *
     * @return string
     */
    public function getPostalFacturation()
    {
        return $this->postalFacturation;
    }

    /**
     * Set postalFacturation
     *
     * @param string $postalFacturation
     *
     * @return Entreprises
     */
    public function setPostalFacturation($postalFacturation)
    {
        $this->postalFacturation = $postalFacturation;

        return $this;
    }

    /**
     * Get villeFacturation
     *
     * @return string
     */
    public function getVilleFacturation()
    {
        return $this->villeFacturation;
    }

    /**
     * Set villeFacturation
     *
     * @param string $villeFacturation
     *
     * @return Entreprises
     */
    public function setVilleFacturation($villeFacturation)
    {
        $this->villeFacturation = $villeFacturation;

        return $this;
    }

    /**
     * Get paysFacturation
     *
     * @return string
     */
    public function getPaysFacturation()
    {
        return $this->paysFacturation;
    }

    /**
     * Set paysFacturation
     *
     * @param string $paysFacturation
     *
     * @return Entreprises
     */
    public function setPaysFacturation($paysFacturation)
    {
        $this->paysFacturation = $paysFacturation;

        return $this;
    }

    /**
     * Get presentation
     *
     * @return string
     */
    public function getPresentation()
    {
        return $this->presentation;
    }

    /**
     * Set presentation
     *
     * @param string $presentation
     *
     * @return Entreprises
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * Get siteWeb
     *
     * @return string
     */
    public function getSiteWeb()
    {
        return $this->siteWeb;
    }

    /**
     * Set siteWeb
     *
     * @param string $siteWeb
     *
     * @return Entreprises
     */
    public function setSiteWeb($siteWeb)
    {
        $this->siteWeb = $siteWeb;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     *
     * @return Entreprises
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get linkedIn
     *
     * @return string
     */
    public function getLinkedIn()
    {
        return $this->linkedIn;
    }

    /**
     * Set linkedIn
     *
     * @param string $linkedIn
     *
     * @return Entreprises
     */
    public function setLinkedIn($linkedIn)
    {
        $this->linkedIn = $linkedIn;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     *
     * @return Entreprises
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get chiffreAffaire
     *
     * @return string
     */
    public function getChiffreAffaire()
    {
        return $this->chiffreAffaire;
    }

    /**
     * Set chiffreAffaire
     *
     * @param string $chiffreAffaire
     *
     * @return Entreprises
     */
    public function setChiffreAffaire($chiffreAffaire)
    {
        $this->chiffreAffaire = $chiffreAffaire;

        return $this;
    }

    /**
     * Get effectifs
     *
     * @return string
     */
    public function getEffectifs()
    {
        return $this->effectifs;
    }

    /**
     * Set effectifs
     *
     * @param string $effectifs
     *
     * @return Entreprises
     */
    public function setEffectifs($effectifs)
    {
        $this->effectifs = $effectifs;

        return $this;
    }

    /**
     * Get nbUniversitaires
     *
     * @return string
     */
    public function getNbUniversitaires()
    {
        return $this->nbUniversitaires;
    }

    /**
     * Set nbUniversitaires
     *
     * @param string $nbUniversitaires
     *
     * @return Entreprises
     */
    public function setNbUniversitaires($nbUniversitaires)
    {
        $this->nbUniversitaires = $nbUniversitaires;

        return $this;
    }

    /**
     * Get personneRecrutement
     *
     * @return string
     */
    public function getPersonneRecrutement()
    {
        return $this->personneRecrutement;
    }

    /**
     * Set personneRecrutement
     *
     * @param string $personneRecrutement
     *
     * @return Entreprises
     */
    public function setPersonneRecrutement($personneRecrutement)
    {
        $this->personneRecrutement = $personneRecrutement;

        return $this;
    }

    /**
     * Get adresseRecrutement
     *
     * @return string
     */
    public function getAdresseRecrutement()
    {
        return $this->adresseRecrutement;
    }

    /**
     * Set adresseRecrutement
     *
     * @param string $adresseRecrutement
     *
     * @return Entreprises
     */
    public function setAdresseRecrutement($adresseRecrutement)
    {
        $this->adresseRecrutement = $adresseRecrutement;

        return $this;
    }

    /**
     * Get secteur
     *
     * @return string
     */
    public function getSecteur()
    {
        return $this->secteur;
    }

    /**
     * Set secteur
     *
     * @param string $secteur
     *
     * @return Entreprises
     */
    public function setSecteur($secteur)
    {
        $this->secteur = $secteur;

        return $this;
    }

    /**
     * Get profilsRecherches
     *
     * @return string
     */
    public function getProfilsRecherches()
    {
        return $this->profilsRecherches;
    }

    /**
     * Set profilsRecherches
     *
     * @param string $profilsRecherches
     *
     * @return Entreprises
     */
    public function setProfilsRecherches($profilsRecherches)
    {
        $this->profilsRecherches = $profilsRecherches;

        return $this;
    }

    /**
     * Get pointsForts
     *
     * @return string
     */
    public function getPointsForts()
    {
        return $this->pointsForts;
    }

    /**
     * Set pointsForts
     *
     * @param string $pointsForts
     *
     * @return Entreprises
     */
    public function setPointsForts($pointsForts)
    {
        $this->pointsForts = $pointsForts;

        return $this;
    }

    /**
     * Get evolution
     *
     * @return string
     */
    public function getEvolution()
    {
        return $this->evolution;
    }

    /**
     * Set evolution
     *
     * @param string $evolution
     *
     * @return Entreprises
     */
    public function setEvolution($evolution)
    {
        $this->evolution = $evolution;

        return $this;
    }

    /**
     * Get implementation
     *
     * @return string
     */
    public function getImplementation()
    {
        return $this->implementation;
    }

    /**
     * Set implementation
     *
     * @param string $implementation
     *
     * @return Entreprises
     */
    public function setImplementation($implementation)
    {
        $this->implementation = $implementation;

        return $this;
    }

    /**
     * Get conseil
     *
     * @return string
     */
    public function getConseil()
    {
        return $this->conseil;
    }

    /**
     * Set conseil
     *
     * @param string $conseil
     *
     * @return Entreprises
     */
    public function setConseil($conseil)
    {
        $this->conseil = $conseil;

        return $this;
    }

    /**
     * Get dateInscription
     *
     * @return \DateTime
     */
    public function getDateInscription()
    {
        return $this->dateInscription;
    }

    /**
     * Set dateInscription
     *
     * @param \DateTime $dateInscription
     *
     * @return Entreprises
     */
    public function setDateInscription($dateInscription)
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    /**
     * Get contact
     *
     * @return \AEES\UserBundle\Entity\User
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set contact
     *
     * @param \AEES\UserBundle\Entity\User $contact
     *
     * @return Entreprises
     */
    public function setContact(\AEES\UserBundle\Entity\User $contact = null)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Add inscription
     *
     * @param \JOBINGE\ForumBundle\Entity\Inscription $inscription
     *
     * @return Entreprises
     */
    public function addInscription(\JOBINGE\ForumBundle\Entity\Inscription $inscription)
    {
        $this->inscriptions[] = $inscription;

        return $this;
    }

    /**
     * Remove inscription
     *
     * @param \JOBINGE\ForumBundle\Entity\Inscription $inscription
     */
    public function removeInscription(\JOBINGE\ForumBundle\Entity\Inscription $inscription)
    {
        $this->inscriptions->removeElement($inscription);
    }

    /**
     * Get inscriptions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInscriptions()
    {
        return $this->inscriptions;
    }


    /**
     * Add master
     *
     * @param \JOBINGE\ForumBundle\Entity\Masters $master
     *
     * @return Entreprises
     */
    public function addMaster(\JOBINGE\ForumBundle\Entity\Masters $master)
    {
        $this->masters[] = $master;

        return $this;
    }

    /**
     * Remove master
     *
     * @param \JOBINGE\ForumBundle\Entity\Masters $master
     */
    public function removeMaster(\JOBINGE\ForumBundle\Entity\Masters $master)
    {
        $this->masters->removeElement($master);
    }

    /**
     * Get masters
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMasters()
    {
        return $this->masters;
    }

    /**
     * Get logoHQ
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getLogoHQ()
    {
        return $this->logoHQ;
    }

    /**
     * Set logoHQ
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $logoHQ
     *
     * @return Entreprises
     */
    public function setLogoHQ(\Application\Sonata\MediaBundle\Entity\Media $logoHQ = null)
    {
        $this->logoHQ = $logoHQ;

        return $this;
    }

    /**
     * Get pub
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getPub()
    {
        return $this->pub;
    }

    /**
     * Set pub
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $pub
     *
     * @return Entreprises
     */
    public function setPub(\Application\Sonata\MediaBundle\Entity\Media $pub = null)
    {
        $this->pub = $pub;

        return $this;
    }

    /**
     * Get nomSlug.
     *
     * @return string
     */
    public function getNomSlug()
    {
        return $this->nomSlug;
    }

    /**
     * Set nomSlug.
     *
     * @param string $nomSlug
     *
     * @return Entreprises
     */
    public function setNomSlug($nomSlug)
    {
        $this->nomSlug = $nomSlug;

        return $this;
    }

    /**
     * Get logo.
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media|null
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set logo.
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media|null $logo
     *
     * @return Entreprises
     */
    public function setLogo(\Application\Sonata\MediaBundle\Entity\Media $logo = null)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Add conference.
     *
     * @param \JOBINGE\ForumBundle\Entity\Conference $conference
     *
     * @return Entreprises
     */
    public function addConference(\JOBINGE\ForumBundle\Entity\Conference $conference)
    {
        $this->conferences[] = $conference;

        return $this;
    }

    /**
     * Remove conference.
     *
     * @param \JOBINGE\ForumBundle\Entity\Conference $conference
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeConference(\JOBINGE\ForumBundle\Entity\Conference $conference)
    {
        return $this->conferences->removeElement($conference);
    }

    /**
     * Get conferences.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConferences()
    {
        return $this->conferences;
    }
}
