<?php

declare(strict_types=1);

namespace App\Form\Cluster;

use App\Entity\Cluster\Fuel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FuelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isEdition = $options['edition'] ?? false;

        $builder
            ->add('carburantId', IntegerType::class, [
                'empty_data' => $options['data']->getCarburantId(),
                'attr' => [
                    'disabled' => $isEdition,
                    'class' => 'form-control',
                    'title' => $isEdition ? 'Vous ne pouvez pas la modifier, vu qu\'elle est retourner par Autobiz' : '',
                ],
            ])
            ->add('carburantCorrected', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('carburantClass', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fuel::class,
            'edition' => false,
        ]);
    }
}
