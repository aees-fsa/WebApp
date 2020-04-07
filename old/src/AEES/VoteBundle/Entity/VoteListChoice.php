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
 * @ORM\Entity(repositoryClass="AEES\VoteBundle\Entity\VoteListChoiceRepository")
 * @ORM\Table(name="vote__list_choice")
 */
class VoteListChoice
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="VoteList", inversedBy="choices")
     */
    protected $list;

    /**
     * @ORM\Column(type="text", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(type="integer")
     */
    protected $result = 0;

    public function __toString()
    {
        return $this->name;
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
     * @return VoteListChoice
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get list
     *
     * @return \AEES\VoteBundle\Entity\VoteList
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * Set list
     *
     * @param \AEES\VoteBundle\Entity\VoteList $list
     *
     * @return VoteListChoice
     */
    public function setList(\AEES\VoteBundle\Entity\VoteList $list = null)
    {
        $this->list = $list;

        return $this;
    }

    /**
     * Get result
     *
     * @return integer
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set result
     *
     * @param integer $result
     *
     * @return VoteListChoice
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }
}
