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

/**
 * @ORM\Entity(repositoryClass="JOBINGE\ForumBundle\Entity\InscriptionRepository")
 * @ORM\Table(name="jobinge__inscription_elements")
 * @UniqueEntity(
 *     fields={"forum", "company"},
 *     message="Vous ne pouvez vous inscrire qu'une seule fois au forum"
 * )
 */
class InscriptionElement
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="JOBINGE\ForumBundle\Entity\Inscription",
     *     inversedBy="elements"
     * )
     */
    protected $inscription;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=100,
     *     nullable=false
     * )
     *
     */
    protected $nom;

    /**
     * @ORM\Column(
     *     type="integer",
     *     length=10,
     *     nullable=false
     * )
     *
     */
    protected $quantite;

    /**
     * @ORM\Column(
     *     type="decimal",
     *     scale=2,
     *     nullable=true
     * )
     *
     */
    protected $prixUnit;

    /**
     * @ORM\Column(
     *     type="integer",
     *     length=1,
     *     nullable=false
     * )
     *
     */
    protected $type;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->inscription = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return InscriptionElement
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return integer
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return InscriptionElement
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get prixUnit
     *
     * @return string
     */
    public function getPrixUnit()
    {
        return $this->prixUnit;
    }

    /**
     * Set prixUnit
     *
     * @param string $prixUnit
     *
     * @return InscriptionElement
     */
    public function setPrixUnit($prixUnit)
    {
        $this->prixUnit = $prixUnit;

        return $this;
    }

    /**
     * Get inscription
     *
     * @return \JOBINGE\ForumBundle\Entity\Inscription
     */
    public function getInscription()
    {
        return $this->inscription;
    }

    /**
     * Set inscription
     *
     * @param \JOBINGE\ForumBundle\Entity\Inscription $inscription
     *
     * @return InscriptionElement
     */
    public function setInscription(\JOBINGE\ForumBundle\Entity\Inscription $inscription = null)
    {
        $this->inscription = $inscription;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return InscriptionElement
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}
