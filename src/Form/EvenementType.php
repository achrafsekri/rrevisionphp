<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom')
            // type is a select from one of these sport, technologie, évènements culturels, décoration
            ->add('Type', ChoiceType::class, [
                'choices' => [
                    'sport' => 'sport',
                    'technologie' => 'technologie',
                    'évènements culturels' => 'évènements culturels',
                    'décoration' => 'décoration',
                ],
            ])
            ->add('Date')
            ->add('Lieux')
            ->add('nombrePlace')
            ->add(
                'submit',
                SubmitType::class
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
