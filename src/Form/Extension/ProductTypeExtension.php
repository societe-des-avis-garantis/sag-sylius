<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Form\Extension;

use Sylius\Bundle\ProductBundle\Form\Type\ProductType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class ProductTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('SAGEan13', TextType::class, [
                'required' => false,
                'label' => 'dedi_sylius_sag_plugin.ui.ean13',
            ])
            ->add('SAGUpc', TextType::class, [
                'required' => false,
                'label' => 'dedi_sylius_sag_plugin.ui.upc',
            ])
        ;
    }

    public static function getExtendedTypes(): iterable
    {
        return [
            ProductType::class,
        ];
    }
}
