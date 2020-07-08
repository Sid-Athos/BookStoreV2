<?php

namespace App\Form;

use App\Entity\Orders;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Client;

class OrdersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateLocation')
            ->add('client', EntityType::class, [
            // looks for choices from this entity
            'class' => Client::class,

            // uses the User.username property as the visible option string
            'choice_label' => 'getFullName',

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
            'data_class' => Orders::class,
        ]);
    }
}
