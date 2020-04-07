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
 * @ORM\Entity(repositoryClass="JOBINGE\ForumBundle\Entity\ForumRepository")
 * @ORM\Table(name="jobinge__forum")
 * @UniqueEntity(fields={"active"}, message="Un seul forum peut être actif en même temps", ignoreNull=true)
 */
class Forum
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
     * @ORM\OneToMany(targetEntity="JOBINGE\ForumBundle\Entity\ForumDates", mappedBy="forum", cascade={"persist"})
     */
    protected $dates;

    /**
     * @ORM\Column(
     *     type="boolean",
     *     nullable=true,
     *
     * )
     *
     */
    protected $active;

    /**
     * @ORM\OneToMany(targetEntity="JOBINGE\ForumBundle\Entity\Inscription",
     *     mappedBy="forum")
     */
    protected $inscriptions;

    /**
     * @ORM\OneToMany(targetEntity="JOBINGE\ForumBundle\Entity\Conference",
     *     mappedBy="forum")
     */
    protected $conferences;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dates = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Forum
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Forum
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Add dates
     *
     * @param \JOBINGE\ForumBundle\Entity\ForumDates $dates
     *
     * @return Forum
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
     * Add inscriptions
     *
     * @param \JOBINGE\ForumBundle\Entity\Inscription $inscriptions
     *
     * @return Forum
     */
    public function addInscription(\JOBINGE\ForumBundle\Entity\Inscription $inscriptions)
    {
        $this->inscriptions[] = $inscriptions;

        return $this;
    }

    /**
     * Remove inscriptions
     *
     * @param \JOBINGE\ForumBundle\Entity\Inscription $inscriptions
     */
    public function removeInscription(\JOBINGE\ForumBundle\Entity\Inscription $inscriptions)
    {
        $this->inscriptions->removeElement($inscriptions);
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
     * Add conference.
     *
     * @param \JOBINGE\ForumBundle\Entity\Conference $conference
     *
     * @return Forum
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
