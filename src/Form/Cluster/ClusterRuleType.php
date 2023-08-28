<?php

declare(strict_types=1);

namespace App\Form\Cluster;

use App\Entity\Cluster\ClusterRule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClusterRuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isEdition = $options['edition'] ?? false;

        $builder
            ->add('cluster', TextType::class, [
                'attr' => [
                    'disabled' => $isEdition,
                    'class' => 'form-control',
                ],
                'empty_data' => $options['data']->getCluster(),
            ])
            ->add('finalCpB2cMin', NumberType::class, [
                'grouping' => true,
                'scale' => 2,
                'label' => 'final_CP/B2C_min :',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('finalCpB2c', NumberType::class, [
                'grouping' => true,
                'scale' => 2,
                'label' => 'final_CP/B2C :',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('finalBpB2cMax', NumberType::class, [
                'grouping' => true,
                'scale' => 2,
                'label' => 'final_CP/B2C_max :',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('finalCpB2CMax', NumberType::class, [
                'grouping' => true,
                'scale' => 2,
                'label' => 'final_BP/B2C_max :',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('finalBpB2cMin', NumberType::class, [
                'grouping' => true,
                'scale' => 2,
                'label' => 'final_BP/B2C_min :',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('finalBpB2c', NumberType::class, [
                'grouping' => true,
                'scale' => 2,
                'label' => 'final_BP/B2C :',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClusterRule::class,
            'edition' => false,
        ]);
    }
}
