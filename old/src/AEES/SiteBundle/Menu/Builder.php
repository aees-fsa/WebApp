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

namespace AEES\SiteBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root')
            ->setChildrenAttribute('class', 'nav-item');

        $menu->addChild('Accueil', array('route' => 'page_slug', 'routeParameters' => array('path' => '/')))
            ->setLinkAttribute('class', 'nav-link');

        $menu->addChild('À propos', array('route' => 'page_slug', 'routeParameters' => array('path' => '/a-propos')))
            ->setLinkAttribute('class', 'nav-link');

        $menu->addChild('Events', array('route' => 'page_slug', 'routeParameters' => array('path' => '/events')))
            ->setLinkAttribute('class', 'nav-link');

        $menu->addChild('Ingénu', array('route' => 'page_slug', 'routeParameters' => array('path' => '/ingenu/archive')))
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');

        $menu->addChild('Contact', array('route' => 'page_slug', 'routeParameters' => array('path' => '/contact')))
            ->setLinkAttribute('class', 'nav-link');

        $request = null; //$this->container->get('request');

        $path = null; //$request->getPathInfo();
        switch (true) {
            case preg_match('/^\/$/', $path):
                $menu->getChild('Accueil')->setCurrent(true);
                break;
            case preg_match('/^\/a-propos/', $path):
                $menu->getChild('À propos')->setCurrent(true);
                break;
            case preg_match('/^\/events/', $path):
                $menu->getChild('Events')->setCurrent(true);
                break;

            case preg_match('/^\/ingenu/', $path):
                $menu->getChild('Ingénu')->setCurrent(true);
                break;

            case preg_match('/^\/contact/', $path):
                $menu->getChild('Contact')->setCurrent(true);
                break;

        }

        return $menu;
    }

}