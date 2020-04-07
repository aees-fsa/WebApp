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

namespace JOBINGE\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


/**
 * @ORM\Entity(repositoryClass="JOBINGE\ForumBundle\Entity\InscriptionRepository")
 * @ORM\Table(name="jobinge__inscriptions")
 * @UniqueEntity(
 *     fields={"forum", "company"},
 *     message="Vous ne pouvez vous inscrire qu'une seule fois au forum"
 * )
 */
class Inscription
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @ORM\ManyToOne(
     *     targetEntity="JOBINGE\EntreprisesBundle\Entity\Entreprises",
     *     inversedBy="inscriptions"
     * )
     *
     */
    protected $company;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="JOBINGE\ForumBundle\Entity\Forum",
     *     inversedBy="inscriptions"
     * )
     *
     */
    protected $forum;

    /**
     * @ORM\ManyToMany(
     *     targetEntity="JOBINGE\ForumBundle\Entity\ForumDates",
     *     inversedBy="insciptions"
     * )
     * @ORM\JoinTable(name="jobinge__inscription_dates")
     */
    protected $dates;

    /**
     * @ORM\OneToMany(
     *     targetEntity="JOBINGE\ForumBundle\Entity\InscriptionElement",
     *     mappedBy="inscription",
     *     cascade={"persist"},
     *     orphanRemoval=true
     * )
     */
    protected $elements;

    /**
     * @ORM\Column(
     *     type="json_array",
     *     nullable=true
     * )
     */
    protected $options;

    /**
     * @ORM\Column(
     *     type="text",
     *     nullable=true
     * )
     */
    protected $commentaire;

    /**
     * @ORM\Column(
     *     type="integer",
     *     nullable=false
     * )
     */
    protected $status;

    /**
     * @ORM\Column(
     *     type="text",
     *     nullable=true
     * )
     */
    protected $statusComment;

    /**
     * @ORM\Column(
     *     type="integer",
     *     nullable=true
     * )
     */
    protected $statusInterne;

    /**
     * @ORM\Column(
     *     type="text",
     *     nullable=true
     * )
     */
    protected $commentInterne;

    /**
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"})
     */
    protected $contrat;

    /**
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"})
     */
    protected $contratSigne;

    /**
     * @ORM\Column(
     *     type="datetime",
     *     nullable=false
     * )
     */
    protected $created;

    /**
     * @ORM\Column(
     *     type="boolean",
     *     nullable=true
     * )
     */
    protected $confirmProfile;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dates = new \Doctrine\Common\Collections\ArrayCollection();
        $this->elements = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return "Dossier n°" . $this->getIdentifier();
    }

    public function getIdentifier()
    {
        return $this->getCreated()->format("Y") . str_pad($this->getId(), 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Inscription
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
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

    public function getPack()
    {
        foreach ($this->getElements() as $element) {
            if ($element->getType() == 0) {
                return $element;
            }
        }
        return null;
    }

    /**
     * Get elements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getElements()
    {
        return $this->elements;
    }

    public function getOtherOptions()
    {
        $options = array();

        foreach ($this->getElements() as $element) {
            if ($element->getType() != 0) {
                $options[] = $element;
            }
        }
        return $options;
    }

    public function getTotal()
    {
        $total = 0.0;
        foreach ($this->getElements() as $element) {
            $total += $element->getPrixUnit() * $element->getQuantite();
        }

        return $total;
    }

    public function getStatusString()
    {
        switch ($this->status) {
            case 1:
                return "En cours de validation";
            case 2:
                return "En attente de signature du contrat";
            case 3:
                return "En attente de payement de la facture";
            case 4:
                return "Validé";
            case 0:
                return "Refusé";
            default:
                return "";
        }
    }

    public function getStatusInterneString()
    {
        $statuts = array(
            0 => 'Nouveau',
            1 => 'Vu, a accepter',
            2 => 'Vu, refus probable',
            3 => 'Vu, a contacter pour plus d\'informations',
            5 => 'Contrat envoyé, en attente de signature',
            6 => 'Contrat signé reçu',
            7 => 'Facture envoyée, en attente de payement',
            8 => 'Facture payée',
            9 => 'Refusé',
            10 => 'Refusé et prévenu'
        );

        return $statuts[$this->statusInterne];
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        if ($this->getStatus() >= 2 && $this->getContrat() == null) {
            $context->buildViolation('Vous devez d\'abord uploader le contrat')
                ->atPath('status')
                ->addViolation();
        } elseif ($this->getStatus() >= 3 && $this->getContratSigne() == null) {
            $context->buildViolation('Vous devez d\'abord uploader le contrat signé')
                ->atPath('status')
                ->addViolation();
        }

    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Inscription
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get contrat
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getContrat()
    {
        return $this->contrat;
    }

    /**
     * Set contrat
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $contrat
     *
     * @return Inscription
     */
    public function setContrat(\Application\Sonata\MediaBundle\Entity\Media $contrat = null)
    {
        $this->contrat = $contrat;

        return $this;
    }

    /**
     * Get contratSigne
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getContratSigne()
    {
        return $this->contratSigne;
    }

    /**
     * Set contratSigne
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $contratSigne
     *
     * @return Inscription
     */
    public function setContratSigne(\Application\Sonata\MediaBundle\Entity\Media $contratSigne = null)
    {
        $this->contratSigne = $contratSigne;

        return $this;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set options
     *
     * @param array $options
     *
     * @return Inscription
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return Inscription
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get company
     *
     * @return \JOBINGE\EntreprisesBundle\Entity\Entreprises
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set company
     *
     * @param \JOBINGE\EntreprisesBundle\Entity\Entreprises $company
     *
     * @return Inscription
     */
    public function setCompany(\JOBINGE\EntreprisesBundle\Entity\Entreprises $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get forum
     *
     * @return \JOBINGE\ForumBundle\Entity\Forum
     */
    public function getForum()
    {
        return $this->forum;
    }

    /**
     * Set forum
     *
     * @param \JOBINGE\ForumBundle\Entity\Forum $forum
     *
     * @return Inscription
     */
    public function setForum(\JOBINGE\ForumBundle\Entity\Forum $forum = null)
    {
        $this->forum = $forum;

        return $this;
    }

    /**
     * Add dates
     *
     * @param \JOBINGE\ForumBundle\Entity\ForumDates $dates
     *
     * @return Inscription
     */
    public function addDate(\JOBINGE\ForumBundle\Entity\ForumDates $dates)
    {
        $this->dates[] = $dates;

        return $this;
    }

    /**
     * Remove dates
     *
     * @param \JOBINGE\ForumBundle\Entity\ForumDates $dates
     */
    public function removeDate(\JOBINGE\ForumBundle\Entity\ForumDates $dates)
    {
        $this->dates->removeElement($dates);
    }

    /**
     * Get dates
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDates()
    {
        return $this->dates;
    }

    /**
     * Add elements
     *
     * @param \JOBINGE\ForumBundle\Entity\InscriptionElement $elements
     *
     * @return Inscription
     */
    public function addElement(\JOBINGE\ForumBundle\Entity\InscriptionElement $elements)
    {
        $this->elements[] = $elements;

        return $this;
    }

    /**
     * Remove elements
     *
     * @param \JOBINGE\ForumBundle\Entity\InscriptionElement $elements
     */
    public function removeElement(\JOBINGE\ForumBundle\Entity\InscriptionElement $elements)
    {
        $this->elements->removeElement($elements);
    }

    /**
     * Get statusInterne
     *
     * @return integer
     */
    public function getStatusInterne()
    {
        return $this->statusInterne;
    }

    /**
     * Set statusInterne
     *
     * @param integer $statusInterne
     *
     * @return Inscription
     */
    public function setStatusInterne($statusInterne)
    {
        $this->statusInterne = $statusInterne;

        return $this;
    }

    /**
     * Get statusComment
     *
     * @return string
     */
    public function getStatusComment()
    {
        return $this->statusComment;
    }

    /**
     * Set statusComment
     *
     * @param string $statusComment
     *
     * @return Inscription
     */
    public function setStatusComment($statusComment)
    {
        $this->statusComment = $statusComment;

        return $this;
    }

    /**
     * Get commentInterne
     *
     * @return string
     */
    public function getCommentInterne()
    {
        return $this->commentInterne;
    }

    /**
     * Set commentInterne
     *
     * @param string $commentInterne
     *
     * @return Inscription
     */
    public function setCommentInterne($commentInterne)
    {
        $this->commentInterne = $commentInterne;

        return $this;
    }

    /**
     * Get confirmProfile
     *
     * @return boolean
     */
    public function getConfirmProfile()
    {
        return $this->confirmProfile;
    }

    /**
     * Set confirmProfile
     *
     * @param boolean $confirmProfile
     *
     * @return Inscription
     */
    public function setConfirmProfile($confirmProfile)
    {
        $this->confirmProfile = $confirmProfile;

        return $this;
    }
}
