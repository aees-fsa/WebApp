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
 * @ORM\Entity(repositoryClass="AEES\VoteBundle\Entity\VoteSessionRepository")
 * @ORM\Table(name="vote__session")
 */
class VoteSession
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(type="text", length=255)
     */
    protected $description;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $begin;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $end;

    /**
     * @ORM\OneToMany(targetEntity="VotePeople", cascade={"persist", "remove"}, mappedBy="session")
     */
    protected $people;

    /**
     * @ORM\OneToMany(targetEntity="VoteList", cascade={"persist", "remove"}, mappedBy="session")
     */
    protected $list;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->people = new \Doctrine\Common\Collections\ArrayCollection();
        $this->begin = new \DateTime();
        $this->end = new \DateTime();
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
     * @return VoteSession
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get begin
     *
     * @return \DateTime
     */
    public function getBegin()
    {
        return $this->begin;
    }

    /**
     * Set begin
     *
     * @param \DateTime $begin
     *
     * @return VoteSession
     */
    public function setBegin($begin)
    {
        $this->begin = $begin;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     *
     * @return VoteSession
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Add people
     *
     * @param \AEES\VoteBundle\Entity\VotePeople $people
     *
     * @return VoteSession
     */
    public function addPerson(\AEES\VoteBundle\Entity\VotePeople $people)
    {
        $this->people[] = $people;

        return $this;
    }

    /**
     * Remove people
     *
     * @param \AEES\VoteBundle\Entity\VotePeople $people
     */
    public function removePerson(\AEES\VoteBundle\Entity\VotePeople $people)
    {
        $this->people->removeElement($people);
    }

    /**
     * Get people
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPeople()
    {
        return $this->people;
    }

    /**
     * Add list
     *
     * @param \AEES\VoteBundle\Entity\VoteList $list
     *
     * @return VoteSession
     */
    public function addList(\AEES\VoteBundle\Entity\VoteList $list)
    {
        $this->list[] = $list;

        return $this;
    }

    /**
     * Remove list
     *
     * @param \AEES\VoteBundle\Entity\VoteList $list
     */
    public function removeList(\AEES\VoteBundle\Entity\VoteList $list)
    {
        $this->list->removeElement($list);
    }

    /**
     * Get list
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getList()
    {
        return $this->list;
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
     * @return VoteSession
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
}
