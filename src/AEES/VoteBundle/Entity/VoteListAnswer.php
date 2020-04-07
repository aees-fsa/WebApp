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
 * @ORM\Entity(repositoryClass="AEES\VoteBundle\Entity\VoteListAnswerRepository")
 * @ORM\Table(name="vote__list_answer")
 */
class VoteListAnswer
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="AEES\VoteBundle\Entity\VoteList")
     */
    protected $list;

    /**
     * @ORM\ManyToOne(targetEntity="AEES\UserBundle\Entity\User")
     */
    protected $user;

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
     * @return VoteListAnswer
     */
    public function setList(\AEES\VoteBundle\Entity\VoteList $list = null)
    {
        $this->list = $list;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AEES\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user
     *
     * @param \AEES\UserBundle\Entity\User $user
     *
     * @return VoteListAnswer
     */
    public function setUser(\AEES\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }
}
