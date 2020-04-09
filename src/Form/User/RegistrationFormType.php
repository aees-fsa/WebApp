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

namespace App\Form\User;


use App\Entity\User\User;
use App\Validator\User\isMatricule;
use App\Validator\User\isUlgEmail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
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
            ->add('username', null, array_merge(array(
                'label' => 'Matricule Uliège (Login)',
                'translation_domain' => 'SonataUserBundle',
                'constraints' => new isMatricule(),
            )))
            ->add('email', $emailType, array_merge(array(
                'label' => 'Adresse e-mail ULg',
                'translation_domain' => 'SonataUserBundle',
                'constraints' => new isUlgEmail(),
            )))
            ->add('firstname', null, array_merge(array(
                'label' => 'Prénom',
                'constraints' => new NotBlank(),
            )))
            ->add('lastname', null, array_merge(array(
                'label' => 'Nom de famille',
                'constraints' => new NotBlank(),
            )))
            ->add('plainPassword', $repeatedType, array_merge(array(
                'type' => $passwordType,
                'options' => array('translation_domain' => 'SonataUserBundle'),
                'first_options' => array_merge(array(
                    'label' => 'form.password',
                )),
                'second_options' => array_merge(array(
                    'label' => 'Répétez le mot de passe',
                )),
                'invalid_message' => 'fos_user.password.mismatch',
            )));
    }

    /**
     * {@inheritdoc}
     *
     * NEXT_MAJOR: remove this method.
     *
     * @deprecated Remove it when bumping requirements to Symfony 2.7+
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
            'intention' => 'registration',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'aees_user_registration';
    }
}
