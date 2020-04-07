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

namespace AEES\VoteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="AEES\VoteBundle\Entity\VoteListRepository")
 * @ORM\Table(name="vote__list")
 */
class VoteList
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="AEES\VoteBundle\Entity\VoteSession", inversedBy="list")
     */
    protected $session;

    /**
     * @ORM\Column(type="text", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(type="text", length=255)
     */
    protected $description;

    /**
     * @ORM\Column(type="integer")
     */
    protected $status = 0;

    /**
     * @ORM\Column(type="integer")
     */
    protected $maxVotes = 0;

    /**
     * @ORM\OneToMany(targetEntity="VoteListChoice", cascade={"persist", "remove"}, mappedBy="list", orphanRemoval=true)
     */
    protected $choices;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->choices = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return strval($this->name);
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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return VoteList
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get session
     *
     * @return \AEES\VoteBundle\Entity\VoteSession
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Set session
     *
     * @param \AEES\VoteBundle\Entity\VoteSession $session
     *
     * @return VoteList
     */
    public function setSession(\AEES\VoteBundle\Entity\VoteSession $session = null)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Add choices
     *
     * @param \AEES\VoteBundle\Entity\VoteListChoice $choices
     *
     * @return VoteList
     */
    public function addChoice(\AEES\VoteBundle\Entity\VoteListChoice $choices)
    {
        $this->choices[] = $choices;

        return $this;
    }

    /**
     * Remove choices
     *
     * @param \AEES\VoteBundle\Entity\VoteListChoice $choices
     */
    public function removeChoice(\AEES\VoteBundle\Entity\VoteListChoice $choices)
    {
        $this->choices->removeElement($choices);
    }

    /**
     * Get choices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChoices()
    {
        return $this->choices;
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
     * @return VoteList
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return VoteList
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get maxVotes
     *
     * @return integer
     */
    public function getMaxVotes()
    {
        return $this->maxVotes;
    }

    /**
     * Set maxVotes
     *
     * @param integer $maxVotes
     *
     * @return VoteList
     */
    public function setMaxVotes($maxVotes)
    {
        $this->maxVotes = $maxVotes;

        return $this;
    }
}
