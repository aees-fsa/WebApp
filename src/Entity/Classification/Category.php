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

declare(strict_types=1);

namespace App\Entity\Classification;

use Doctrine\ORM\Mapping as ORM;
use Sonata\ClassificationBundle\Entity\BaseCategory;
use Sonata\MediaBundle\Model\MediaInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="classification__category")
 * @ORM\HasLifecycleCallbacks
 */
class Category extends BaseCategory
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Classification\Category",
     *     mappedBy="parent", cascade={"persist"}, orphanRemoval=true
     * )
     * @ORM\OrderBy({"position"="ASC"})
     *
     * @var Category[]
     */
    protected $children;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\Classification\Category",
     *     inversedBy="children", cascade={"persist", "refresh", "merge", "detach"}
     * )
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     *
     * @var Category
     */
    protected $parent;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\Classification\Context",
     *     cascade={"persist"}
     * )
     * @ORM\JoinColumn(name="context", referencedColumnName="id", nullable=false)
     * @Assert\NotNull()
     *
     * @var Context
     */
    protected $context;

    public function getId()
    {
        return $this->id;
    }

    final public function setMedia(MediaInterface $media = null)
    {
        parent::setMedia($media);
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist(): void
    {
        parent::prePersist();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate(): void
    {
        parent::preUpdate();
    }
}
