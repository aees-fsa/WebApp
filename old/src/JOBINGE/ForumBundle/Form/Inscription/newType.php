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

namespace JOBINGE\ForumBundle\Form\Inscription;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class newType extends AbstractType
{
    protected $packs;

    protected $forum;


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->packs = $options['packs'];
        $this->forum = $options['forum'];

        $choises = array();
        foreach ($this->packs as $key => $choise) {
            $choises[$choise->getNom() . ' (€' . $choise->getPrix() . ')'] = $key;
        }

        $dates = array();
        foreach ($this->forum->getDates() as $key => $choice) {
            $dates[$choice->getDate()->format("d/m/Y")] = $key;

        }

        $builder
            ->add('Pack', ChoiceType::class, array(
                'choices' => $choises,
                'multiple' => false,
                'label' => "Formules",
                'expanded' => true

            ))
            ->add('Date', ChoiceType::class, array(
                'choices' => $dates,
                'multiple' => false,
                'label' => "Date",

            ))
            ->add('Table', ChoiceType::class, array(
                'choices' => array(
                    "haute" => "Table haute",
                    "basse" => "Table basse"
                ),
                'multiple' => false,
                'label' => "Choix de Table",
                'expanded' => true
            ))
            ->add("brochure", HiddenType::class, array(
                'required' => false,
                'label' => "Page supplémentaire dans la brochure (€100)"


            ))
            ->add('repas', NumberType::class, array(
                'label' => "Repas supplémentaires (€25/repas)",
                'data' => 0,

            ))
            ->add('Commentaire', 'textarea', array(
                'required' => false
            ));

        $builder
            ->add('submit', SubmitType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(array(
                "packs" => null,
                "forum" => null
            ));
    }
}