<?php

namespace App\Form;

use App\Entity\RentalLines;
use App\Entity\Rentals;
use App\Entity\Articles;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RentalLinesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate')
            ->add('endDate')
            ->add('Rental', EntityType::class, [
            // looks for choices from this entity
            'class' => Rentals::class,

            // uses the User.username property as the visible option string
            'choice_label' => "id",

            // used to render a select box, check boxes or radios
            // 'multiple' => true,
                    // 'expanded' => true,
        ])
            ->add('Article', EntityType::class, [
            // looks for choices from this entity
            'class' => Articles::class,

            // uses the User.username property as the visible option string
            'choice_label' => 'label',

            // used to render a select box, check boxes or radios
            // 'multiple' => true,
                    // 'expanded' => true,
        ])
            ->add('save',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RentalLines::class,
        ]);
    }
}
