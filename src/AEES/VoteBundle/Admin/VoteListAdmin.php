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

namespace AEES\VoteBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class VoteListAdmin extends AbstractAdmin
{

    protected $parentAssociationMapping = 'session';

    public function prePersist($object)
    {
        foreach ($object->getChoices() as $choice) {
            $choice->setList($object);
        }
    }

    public function preUpdate($object)
    {
        foreach ($object->getChoices() as $choice) {
            $choice->setList($object);
        }
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('status', $this->getRouterIdParameter() . '/status');
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        if (!$this->isChild()) {
            $formMapper
                ->add('session', 'sonata_type_model_list');
        }
        $formMapper
            ->add('name')
            ->add('description')
            ->add('choices', 'sonata_type_collection', array(
                'by_reference' => true
            ), array(
                'edit' => 'inline',
                'inline' => 'table'
            ));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('session');

    }

    protected function configureListFields(ListMapper $listMapper)
    {

        $listMapper
            ->addIdentifier('name')
            ->add('_action', null, array(
                'actions' => array(
                    'status' => array(
                        'template' => 'AEESVoteBundle:VoteList:list__action_status.html.twig'
                    )
                )
            ));

    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('session')
            ->add('name')
            ->add('description')
            ->add('choices');
    }


}