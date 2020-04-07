<?php
/**
 * Copyright (C) 2020 Andrew SASSOYE
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, version 3.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 */

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseUser;

/**
 * Entity User
 * @package App\Entity\User
 * @author  Andrew SASSOYE <andrew@sassoye.be>
 *
 * @ORM\Entity()
 * @ORM\Table(name="user__user")
 */
class User extends BaseUser
{
    /**
     * Id of User
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __toString()
    {
        if (!empty($this->lastname) && !empty($this->firstname)) {
            $toString = $this->firstname . " " . $this->lastname . " (" . $this->username . ")";
        } else {
            $toString = $this->username;
        }
        return strval($toString);
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     *
     * @return $this
     */
    public function setId(?int $id): User
    {
        $this->id = $id;
        return $this;
    }
}
