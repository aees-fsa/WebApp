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

use AEES\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="AEES\VoteBundle\Entity\VotePeopleRepository")
 * @ORM\Table(name="vote__people")
 */
class VotePeople
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="AEES\VoteBundle\Entity\VoteSession", inversedBy="people")
     */
    protected $session;

    /**
     * @ORM\ManyToOne(targetEntity="AEES\UserBundle\Entity\User")
     */
    protected $user;

    /**
     * @ORM\Column(type="integer")
     */
    protected $max_votes;


    public function __toString()
    {
        return strval($this->id);
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
     * Get max_votes
     *
     * @return integer
     */
    public function getMaxVotes()
    {
        return $this->max_votes;
    }

    /**
     * Set max_votes
     *
     * @param integer $maxVotes
     *
     * @return VotePeople
     */
    public function setMaxVotes($maxVotes)
    {
        $this->max_votes = $maxVotes;

        return $this;
    }

    /**
     * Get session_id
     *
     * @return \AEES\VoteBundle\Entity\VoteSession
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Set session_id
     *
     * @param \AEES\VoteBundle\Entity\VoteSession $sessionId
     *
     * @return VotePeople
     */
    public function setSession(VoteSession $sessionId = null)
    {
        $this->session = $sessionId;

        return $this;
    }

    /**
     * Get user_id
     *
     * @return \AEES\UserBundle\Document\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user_id
     *
     * @param \AEES\UserBundle\Entity\User $userId
     *
     * @return VotePeople
     */
    public function setUser(User $userId = null)
    {
        $this->user = $userId;

        return $this;
    }
}
