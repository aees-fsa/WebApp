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

namespace AEES\UserBundle\Form\Type;

use Sonata\UserBundle\Model\UserInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfileType extends AbstractType
{
    /**
     * @var string
     */
    private $class;

    /**
     * @param string $class The User class name
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // NEXT_MAJOR: Keep FQCN when bumping Symfony requirement to 2.8+.
        if (method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')) {
            $userGenderType = 'Sonata\UserBundle\Form\Type\UserGenderListType';
            $birthdayType = 'Symfony\Component\Form\Extension\Core\Type\BirthdayType';
            $urlType = 'Symfony\Component\Form\Extension\Core\Type\UrlType';
            $textareaType = 'Symfony\Component\Form\Extension\Core\Type\TextareaType';
            $localeType = 'Symfony\Component\Form\Extension\Core\Type\LocaleType';
            $timezoneType = 'Symfony\Component\Form\Extension\Core\Type\TimezoneType';
        } else {
            $userGenderType = 'sonata_user_gender';
            $birthdayType = 'birthday';
            $urlType = 'url';
            $textareaType = 'text';
            $localeType = 'locale';
            $timezoneType = 'timezone';
        }

        $builder
            ->add('gender', $userGenderType, array(
                'label' => 'form.label_gender',
                'required' => true,
                'translation_domain' => 'SonataUserBundle',
                'choices' => array(
                    UserInterface::GENDER_FEMALE => 'gender_female',
                    UserInterface::GENDER_MALE => 'gender_male',
                ),
            ))
            ->add('firstname', null, array(
                'label' => 'form.label_firstname',
                'required' => false,
            ))
            ->add('lastname', null, array(
                'label' => 'form.label_lastname',
                'required' => false,
            ))
            ->add('dateOfBirth', $birthdayType, array(
                'label' => 'form.label_date_of_birth',
                'required' => false,
                'widget' => 'single_text',
            ))
            ->add('website', $urlType, array(
                'label' => 'form.label_website',
                'required' => false,
            ))
            ->add('biography', $textareaType, array(
                'label' => 'form.label_biography',
                'required' => false,
            ))
            ->add('locale', $localeType, array(
                'label' => 'form.label_locale',
                'required' => false,
            ))
            ->add('timezone', $timezoneType, array(
                'label' => 'form.label_timezone',
                'required' => false,
            ))
            ->add('phone', null, array(
                'label' => 'form.label_phone',
                'required' => false,
            ));
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
            'data_class' => $this->class,
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
        return 'sonata_user_profile';
    }
}
