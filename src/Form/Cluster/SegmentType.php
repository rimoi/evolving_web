<?php

declare(strict_types=1);

namespace App\Form\Cluster;

use App\Entity\Cluster\Segment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SegmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isEdition = $options['edition'] ?? false;

        $builder
            ->add('voModeleId', TextType::class, [
                'empty_data' => $options['data']->getVoModeleId(),
                'attr' => [
                    'disabled' => $isEdition,
                    'class' => 'form-control',
                    'title' => $isEdition ? 'Vous ne pouvez pas la modifier, vu qu\'elle est retourner par Autobiz' : '',
                ],
            ])
            ->add('segmentName', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('segmentClass', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Segment::class,
            'edition' => false,
        ]);
    }
}
