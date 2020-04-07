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

namespace AEES\VoteBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoteListType extends AbstractType
{
    protected $vlc;
    protected $maxVotes;


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->vlc = $options['vlc'];
        $this->maxVotes = $options['maxVotes'];

        $nbVotes = array();

        for ($i = 0; $i <= $this->maxVotes; $i++) {
            $nbVotes[$i] = $i;
        }

        foreach ($this->vlc as $choice) {
            $builder
                ->add($choice->getId(), ChoiceType::class, array(
                    'choices' => $nbVotes,
                    'multiple' => false,
                    'label' => $choice->getName(),

                ));
        }

        $builder
            ->add('submit', SubmitType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(array(
                "vlc" => null,
                "maxVotes" => null
            ));

    }
}