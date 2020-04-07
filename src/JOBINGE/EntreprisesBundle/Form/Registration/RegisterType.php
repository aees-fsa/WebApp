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

namespace JOBINGE\EntreprisesBundle\Form\Registration;


use JOBINGE\EntreprisesBundle\Validator\isTVA;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tva', null, array_merge(array(
                'label' => 'jobinge.register.company.tva',
                'constraints' => array(
                    new NotBlank(),
                    new isTVA(),
                ),

            )))
            ->add('nom', null, array_merge(array(
                'label' => 'jobinge.register.company.name',
                'constraints' => array(
                    new NotBlank()
                )
            )))
            ->add('adresseSiege', null, array_merge(array(
                'label' => 'jobinge.register.company.address',
                'constraints' => array(
                    new NotBlank()
                )
            )))
            ->add('postalSiege', null, array_merge(array(
                'label' => 'jobinge.register.company.zip',
                'constraints' => array(
                    new NotBlank()
                )
            )))
            ->add('villeSiege', null, array_merge(array(
                'label' => 'jobinge.register.company.ville',
                'constraints' => array(
                    new NotBlank()
                )
            )))
            ->add('paysSiege', null, array_merge(array(
                'label' => 'jobinge.register.company.country',
                'constraints' => array(
                    new NotBlank()
                )
            )));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JOBINGE\EntreprisesBundle\Entity\Entreprises'
        ));
    }

    public function getName()
    {
        return 'jobinge_entreprises_registration';
    }
}