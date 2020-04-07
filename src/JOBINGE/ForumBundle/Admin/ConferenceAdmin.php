<?php
/**
 * Copyright (C) 2018 Andrew SASSOYE
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

namespace JOBINGE\ForumBundle\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;

class ConferenceAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('forum', ModelListType::class, array(
                'btn_delete' => null,
            ))
            ->add(
                'company', ModelListType::class, array(
                'btn_delete' => null
            ))
            ->add(
                'name'
            )
            ->add(
                'description'
            )
            ->add('date', DateTimePickerType::class, array(
                'format' => 'dd/MM/yyyy HH:mm',
                'dp_side_by_side' => false,
                'dp_use_current' => true,
                'dp_use_seconds' => false,
                'dp_collapse' => false,
                'dp_calendar_weeks' => false,
                'dp_view_mode' => 'months',
                'dp_min_view_mode' => 'days',
            ))
            ->add('duree')
            ->add('emplacement');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('name')
            ->add('forum')
            ->add('company')
            ->add('date');
    }
}