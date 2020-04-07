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
 * @ORM\Entity(repositoryClass="AEES\VoteBundle\Entity\VoteListRepository")
 * @ORM\Table(name="jobinge__packs")
 */
class Packs
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
     * @ORM\Column(
     *     type="text",
     *     nullable=true
     * )
     *
     */
    protected $desciption;

    /**
     * @ORM\Column(
     *     type="decimal",
     *     scale=2,
     *     nullable=true
     * )
     *
     */
    protected $prix;

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
     * @return Packs
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get desciption
     *
     * @return string
     */
    public function getDesciption()
    {
        return $this->desciption;
    }

    /**
     * Set desciption
     *
     * @param string $desciption
     *
     * @return Packs
     */
    public function setDesciption($desciption)
    {
        $this->desciption = $desciption;

        return $this;
    }

    /**
     * Get prix
     *
     * @return string
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set prix
     *
     * @param string $prix
     *
     * @return Packs
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }
}
