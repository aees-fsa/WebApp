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

/**
 * @ORM\Entity(repositoryClass="JOBINGE\ForumBundle\Entity\ForumRepository")
 * @ORM\Table(name="jobinge__conferences")
 */
class Conference
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
     *     inversedBy="conferences"
     * )
     *
     */
    protected $company;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="JOBINGE\ForumBundle\Entity\Forum",
     *     inversedBy="conferences"
     * )
     *
     */
    protected $forum;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=100,
     *     nullable=false
     * )
     */
    protected $name;

    /**
     * @ORM\Column(
     *     type="text",
     *     nullable=true
     * )
     */
    protected $description;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $date;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    protected $duree;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=100,
     *     nullable=true
     * )
     */
    protected $emplacement;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Conference
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return Conference
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get emplacement.
     *
     * @return string
     */
    public function getEmplacement()
    {
        return $this->emplacement;
    }

    /**
     * Set emplacement.
     *
     * @param string $emplacement
     *
     * @return Conference
     */
    public function setEmplacement($emplacement)
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    /**
     * Get company.
     *
     * @return \JOBINGE\EntreprisesBundle\Entity\Entreprises|null
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set company.
     *
     * @param \JOBINGE\EntreprisesBundle\Entity\Entreprises|null $company
     *
     * @return Conference
     */
    public function setCompany(\JOBINGE\EntreprisesBundle\Entity\Entreprises $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get forum.
     *
     * @return \JOBINGE\ForumBundle\Entity\Forum|null
     */
    public function getForum()
    {
        return $this->forum;
    }

    /**
     * Set forum.
     *
     * @param \JOBINGE\ForumBundle\Entity\Forum|null $forum
     *
     * @return Conference
     */
    public function setForum(\JOBINGE\ForumBundle\Entity\Forum $forum = null)
    {
        $this->forum = $forum;

        return $this;
    }

    /**
     * Get duree.
     *
     * @return \DateTime|null
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set duree.
     *
     * @param \DateTime|null $duree
     *
     * @return Conference
     */
    public function setDuree($duree = null)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime|null
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set date.
     *
     * @param \DateTime|null $date
     *
     * @return Conference
     */
    public function setDate($date = null)
    {
        $this->date = $date;

        return $this;
    }
}
