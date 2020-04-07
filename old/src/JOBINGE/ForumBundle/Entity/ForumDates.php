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
 * @ORM\Entity(repositoryClass="JOBINGE\ForumBundle\Entity\ForumDatesRepository")
 * @ORM\Table(name="jobinge__forum_dates")
 */
class ForumDates
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="date", nullable=false, unique=true)
     */
    protected $date;

    /**
     * @ORM\ManyToOne(targetEntity="JOBINGE\ForumBundle\Entity\Forum", inversedBy="dates", cascade={"persist"})
     */
    protected $forum;

    /**
     * @ORM\ManyToMany(
     *     targetEntity="JOBINGE\ForumBundle\Entity\Inscription",
     *     mappedBy="dates"
     * )
     *
     */
    protected $insciptions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->insciptions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->date->format("d M Y");
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
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return ForumDates
     */
    public function setDate($date)
    {
        $this->date = $date;

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
     * @return ForumDates
     */
    public function setForum(\JOBINGE\ForumBundle\Entity\Forum $forum = null)
    {
        $this->forum = $forum;

        return $this;
    }

    /**
     * Add insciptions
     *
     * @param \JOBINGE\ForumBundle\Entity\Inscription $insciptions
     *
     * @return ForumDates
     */
    public function addInsciption(\JOBINGE\ForumBundle\Entity\Inscription $insciptions)
    {
        $this->insciptions[] = $insciptions;

        return $this;
    }

    /**
     * Remove insciptions
     *
     * @param \JOBINGE\ForumBundle\Entity\Inscription $insciptions
     */
    public function removeInsciption(\JOBINGE\ForumBundle\Entity\Inscription $insciptions)
    {
        $this->insciptions->removeElement($insciptions);
    }

    /**
     * Get insciptions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInsciptions()
    {
        return $this->insciptions;
    }
}
