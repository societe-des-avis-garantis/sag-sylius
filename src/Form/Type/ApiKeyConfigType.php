<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Form\Type;

use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Bundle\LocaleBundle\Form\Type\LocaleChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class ApiKeyConfigType extends AbstractType
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

            ->add('idSite', NumberType::class, [
                'label' => 'dedi_sylius_sag_plugin.form.id_site',
                'required' => true,
                'html5' => true,
            ])
            ->add('countryCode', TextType::class, [
                'label' => 'dedi_sylius_sag_plugin.form.country_code',
                'required' => true,
            ])
            ->add('key', TextType::class, [
                'label' => 'dedi_sylius_sag_plugin.form.key',
                'required' => true,
            ])
            ->add('locales', LocaleChoiceType::class, [
                'label' => 'dedi_sylius_sag_plugin.form.locales',
                'required' => false,
                'multiple' => true,
            ])
            ->add('channels', ChannelChoiceType::class, [
                'label' => 'dedi_sylius_sag_plugin.form.channels',
                'required' => false,
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }
}
