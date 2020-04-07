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

namespace JOBINGE\EntreprisesBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EntreprisesAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('brochure', $this->getRouterIdParameter() . '/brochure');
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('Fiche Entreprise')
            ->add('nom', null, array(//'disabled' => true
            ))
            ->add('contact')
            ->add('nomSlug', 'text', array('disabled' => true))
            ->add('tva', null, array(
                'disabled' => true
            ))
            ->add('adresseSiege', null, array(
                'disabled' => true
            ))
            ->add('postalSiege', null, array(
                'disabled' => true
            ))
            ->add('villeSiege', null, array(
                'disabled' => true
            ))
            ->add('paysSiege', null, array(
                'disabled' => true
            ))
            ->add('logo', 'sonata_type_model_list', array('required' => false), array(
                'link_parameters' => array(
                    'context' => 'jobinge_logos',
                    'hide_context' => true,
                ),
            ))
            ->add('logoHQ', 'sonata_type_model_list', array('required' => false), array(
                'link_parameters' => array(
                    'context' => 'jobinge_logosHQ',
                    'hide_context' => true,
                ),
            ))
            ->add('pub', 'sonata_type_model_list', array('required' => false), array(
                'link_parameters' => array(
                    'context' => 'jobinge_pub',
                    'hide_context' => true,
                ),
            ))
            ->add('personneRecrutement', null, array(
                'label' => "jobinge.companies.account.company.personneRecrutement"
            ))
            ->add('adresseRecrutement', null, array(
                'label' => "jobinge.companies.account.company.adresseRecrutement"
            ))
            ->add('siteweb', TextType::class, array(
                'label' => "Site web"
            ))
            ->add('facebook', null, array(
                'label' => "Facebook"
            ))
            ->add('linkedIn', null, array(
                'label' => "LinkedIn"
            ))
            ->add('twitter', null, array(
                'label' => "Twitter"
            ))
            ->add('secteur', null, array(
                'label' => "Secteur d’activité"
            ))
            ->add('presentation', null, array(
                'label' => "Présentation de l’entreprise"
            ))
            ->add('masters', EntityType::class, array(
                'class' => 'JOBINGE\ForumBundle\Entity\Masters',
                'multiple' => true,
                'expanded' => true,
                'label' => "Masters : Sélectionnez parmi les choix ci-dessous les masters qui vous intéressent."
            ))
            ->add('profilsRecherches', null, array(
                'label' => "Profils recherchés : Décrivez en quelques mots les profils types qui vous intéressent."
            ))
            ->add('evolution', null, array(
                'label' => "Evolution dans l’entreprise : Décrivez brièvement l’évolution possible pour un jeune diplômé dans votre entreprise. Les différents types de carrière possible dans l’entreprise."
            ))
            ->add('pointsForts', null, array(
                'label' => "Points forts de votre entreprise"
            ))
            ->add('effectifs', null, array(
                'label' => "Effectifs"
            ))
            ->add('chiffreAffaire', null, array(
                'label' => "Chiffre d’affaire"
            ))
            ->add('nbUniversitaires', null, array(
                'label' => "Nombre de jeunes diplômés recrutés l’année passée"
            ))
            ->add('implementation', null, array(
                'label' => "Lieu d’implémentation de votre société"
            ))
            ->add('conseil', null, array(
                'label' => "Conseil pour un jeune diplômé : Donnez un conseil aux futurs diplômés"
            ))
            ->end()
            ->end()
            //->tab('Personne de contact')
            //->with('Profil', array('class' => 'col-md-6'))
            //    ->add('contact.lastname')
            //    ->add('contact.firstname')
            //    ->add('contact.locale', LocaleType::class, array(
            //        'choices' => array(
            //            'français' => 'fr',
            //            'English' => 'en'
            //        )
            //    ))
            //    ->add('contact.phone')
            //->end()
            //->with('Géneral', array('class' => 'col-md-6'))
            //->add('contact.username', null,  array(
            //    'disabled' => true
            //))
            //->add('contact.email', EmailType::class)
            //->add('contact.plainPassword', TextType::class, array(
            //    'required' => false,
            //))
            //->end()
            //->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nom');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('nom');
    }
}