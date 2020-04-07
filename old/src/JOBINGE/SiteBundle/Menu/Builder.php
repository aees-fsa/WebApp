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

namespace JOBINGE\SiteBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\RequestStack;


class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    protected $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root')
            ->setChildrenAttribute('class', 'nav-item');


        $path = $requestStack->getCurrentRequest()->getPathInfo();


        if (preg_match('/^\/students/', $path)) {
            $menu->addChild('menu.students.home', array('route' => 'page_slug', 'routeParameters' => array('path' => '/students')))
                ->setLinkAttribute('class', 'nav-link');

            $menu->addChild('menu.students.forum', array('route' => 'page_slug', 'routeParameters' => array('path' => '/students/jobfair')))
                ->setLinkAttribute('class', 'nav-link');

            $menu->addChild('menu.students.offers', array('uri' => 'http://www.facsa.uliege.be/cms/c_2801470/fr/fsa-offres-d-emploi-d-entreprises'))
                ->setLinkAttribute('class', 'nav-link')
                ->setLinkAttribute('target', '_blank');

            //$menu->addChild('menu.students.events', array('route' => 'page_slug', 'routeParameters' => array('path' => '/students/events')))
            //    ->setLinkAttribute('class', 'nav-link');

            $menu->addChild('menu.students.cv', array('route' => 'page_slug', 'routeParameters' => array('path' => '/students/cv')))
                ->setLinkAttribute('class', 'nav-link');

            $menu->addChild('menu.students.contact', array('route' => 'page_slug', 'routeParameters' => array('path' => '/students/contact')))
                ->setLinkAttribute('class', 'nav-link');

            switch (true) {
                case preg_match('/^\/students$/', $path):
                    $menu->getChild('menu.students.home')->setCurrent(true);
                    break;
                case preg_match('/^\/students\/jobfair/', $path):
                    $menu->getChild('menu.students.forum')->setCurrent(true);
                    break;
                case preg_match('/^\/students\/offers/', $path):
                    $menu->getChild('menu.students.offers')->setCurrent(true);
                    break;

                case preg_match('/^\/students\/events/', $path):
                    $menu->getChild('menu.students.events')->setCurrent(true);
                    break;

                case preg_match('/^\/students\/contact/', $path):
                    $menu->getChild('menu.students.contact')->setCurrent(true);
                    break;

            }
        } elseif (preg_match('/^\/companies/', $path)) {
            $menu->addChild('menu.companies.home', array('route' => 'page_slug', 'routeParameters' => array('path' => '/companies')))
                ->setLinkAttribute('class', 'nav-link');

            $menu->addChild('menu.companies.forum', array('route' => 'page_slug', 'routeParameters' => array('path' => '/companies/jobfair')))
                ->setLinkAttribute('class', 'nav-link');

            $menu->addChild('menu.companies.formulas', array('route' => 'page_slug', 'routeParameters' => array('path' => '/companies/formula')))
                ->setLinkAttribute('class', 'nav-link');

            $menu->addChild('menu.companies.masters', array('route' => 'page_slug', 'routeParameters' => array('path' => '/companies/masters')))
                ->setLinkAttribute('class', 'nav-link');

            $menu->addChild('menu.companies.contact', array('route' => 'page_slug', 'routeParameters' => array('path' => '/companies/contact')))
                ->setLinkAttribute('class', 'nav-link');

            switch (true) {
                case preg_match('/^\/companies$/', $path):
                    $menu->getChild('menu.companies.home')->setCurrent(true);
                    break;
                case preg_match('/^\/companies\/jobfair/', $path):
                    $menu->getChild('menu.companies.forum')->setCurrent(true);
                    break;
                case preg_match('/^\/companies\/formulas/', $path):
                    $menu->getChild('menu.companies.formulas')->setCurrent(true);
                    break;

                case preg_match('/^\/companies\/masters/', $path):
                    $menu->getChild('menu.companies.masters')->setCurrent(true);
                    break;

                case preg_match('/^\/companies\/contact/', $path):
                    $menu->getChild('menu.companies.contact')->setCurrent(true);
                    break;

            }
        }


        return $menu;
    }

}