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
use Sonata\AdminBundle\Show\ShowMapper;

class VotePeopleAdmin extends AbstractAdmin
{

    protected $parentAssociationMapping = 'session';

    protected function configureFormFields(FormMapper $formMapper)
    {
        if (!$this->isChild()) {
            $formMapper
                ->add('session', 'sonata_type_model_list');
        }
        $formMapper
            ->add('user', 'sonata_type_model_autocomplete', array(
                'property' => array('firstname', 'lastname', 'username'),
                'items_per_page' => 50,
                'multiple' => false,
                'required' => true,
            ))
            ->add('max_votes', 'integer', array(
                'required' => true,
            ));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('user')
            ->add('session');

    }

    protected function configureListFields(ListMapper $listMapper)
    {

        if (!$this->isChild()) {
            $listMapper->addIdentifier('id')
                ->add('user');
        } else {
            $listMapper->addIdentifier('user');
        }

        $listMapper
            ->add('max_votes');
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('session');
    }


}