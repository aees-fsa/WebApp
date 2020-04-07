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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterContactType extends AbstractType
{


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // NEXT_MAJOR: Keep FQCN when bumping Symfony requirement to 2.8+.
        if (method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')) {
            $emailType = 'Symfony\Component\Form\Extension\Core\Type\EmailType';
            $repeatedType = 'Symfony\Component\Form\Extension\Core\Type\RepeatedType';
            $passwordType = 'Symfony\Component\Form\Extension\Core\Type\PasswordType';
        } else {
            $emailType = 'email';
            $repeatedType = 'repeated';
            $passwordType = 'password';
        }


        $builder
            ->add('firstname', null, array_merge(array(
                'label' => 'jobinge.register.contact.prenom',
                'constraints' => new NotBlank(),
            )))
            ->add('lastname', null, array_merge(array(
                'label' => 'jobinge.register.contact.nom',
                'constraints' => new NotBlank(),
            )))
            ->add('email', $emailType, array_merge(array(
                'label' => 'jobinge.register.contact.mail',
                'constraints' => new Email(),
            )))
            ->add('phone', null, array(
                'label' => 'jobinge.register.contact.phone',
                'constraints' => new NotBlank()
            ))
            ->add('locale', LocaleType::class, array(
                'label' => 'jobinge.register.contact.locale',
                'constraints' => new NotBlank(),
                'choices' => array(
                    'français' => 'fr',
                    'English' => 'en'
                )
            ))
            ->add('plainPassword', $repeatedType, array_merge(array(
                'type' => $passwordType,
                'options' => array(),
                'first_options' => array_merge(array(
                    'label' => 'jobinge.register.contact.password',
                )),
                'second_options' => array_merge(array(
                    'label' => 'jobinge.register.contact.password.repeat',
                )),
                'invalid_message' => 'fos_user.password.mismatch',
            )));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AEES\UserBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'jobinge_entreprises_registration_contact';
    }
}
