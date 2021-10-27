<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Form\Extension;

use Sylius\Bundle\ChannelBundle\Form\Type\ChannelType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

final class ChannelTypeExtension extends AbstractTypeExtension
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('SAGShowJavascriptWidget', CheckboxType::class, [
                'required' => false,
                'label' => 'dedi_sylius_sag_plugin.form.show_javascript_widget',
            ])
            ->add('SAGShowIframeWidget', CheckboxType::class, [
                'required' => false,
                'label' => 'dedi_sylius_sag_plugin.form.show_iframe_widget',
            ])
            ->add('SAGShowFooterCertificateLink', CheckboxType::class, [
                'required' => false,
                'label' => 'dedi_sylius_sag_plugin.form.show_footer_certificate_link',
            ])
        ;
    }

    public static function getExtendedTypes(): iterable
    {
        return [
            ChannelType::class,
        ];
    }
}
