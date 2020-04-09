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

namespace App\Entity\Page;

use Doctrine\ORM\Mapping as ORM;
use Sonata\PageBundle\Entity\BasePage;

/**
 * @ORM\Entity
 * @ORM\Table(name="page__page")
 * @ORM\HasLifecycleCallbacks
 */
class Page extends BasePage
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
     *     targetEntity="App\Entity\Page\Page",
     *     mappedBy="parent", cascade={"persist"}, orphanRemoval=false
     * )
     * @ORM\OrderBy({"position"="ASC"})
     *
     * @var Page[]
     */
    protected $children;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Page\Block",
     *     mappedBy="page", cascade={"remove", "persist", "refresh", "merge", "detach"}, orphanRemoval=false
     * )
     * @ORM\OrderBy({"position"="ASC"})
     *
     * @var Block[]
     */
    protected $blocks;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\Page\Site",
     *     cascade={"persist"}
     * )
     * @ORM\JoinColumn(name="site_id", referencedColumnName="id", onDelete="CASCADE")
     *
     * @var Site
     */
    protected $site;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\Page\Page",
     *     inversedBy="children", cascade={"persist"}
     * )
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     *
     * @var Page
     */
    protected $parent;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Page\Page",
     *     mappedBy="target", orphanRemoval=false
     * )
     *
     * @var Page[]
     */
    protected $sources;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\Page\Page",
     *     inversedBy="sources", cascade={"persist"}
     * )
     * @ORM\JoinColumn(name="target_id", referencedColumnName="id", onDelete="CASCADE")
     *
     * @var Page
     */
    protected $target;

    public function getId()
    {
        return $this->id;
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
