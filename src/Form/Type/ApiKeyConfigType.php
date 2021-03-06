<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Form\Type;

use Dedi\SyliusSAGPlugin\Context\ConfigurationContextInterface;
use Dedi\SyliusSAGPlugin\Model\ApiKeyInterface;
use Dedi\SyliusSAGPlugin\Validator\ApiKeyConfigIsUniqueForLocalesAndChannels;
use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Bundle\LocaleBundle\Form\Type\LocaleChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

final class ApiKeyConfigType extends AbstractType
{
    /** @var ConfigurationContextInterface */
    private $configurationContext;

    public function __construct(
        ConfigurationContextInterface $configurationContext
    ) {
        $this->configurationContext = $configurationContext;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('apiKey', TextType::class, [
                'label' => 'dedi_sylius_sag_plugin.form.key',
                'required' => true,
                'constraints' => [
                    new NotNull([
                        'groups' => ['default', 'sylius'],
                    ]),
                    new Regex([
                        'pattern' => ApiKeyInterface::VALUE_REGEX,
                        'groups' => ['default', 'sylius'],
                    ]),
                ],
                'validation_groups' => ['default', 'sylius'],
            ])
            ->add('orderStatesToExport', ChoiceType::class, [
                'label' => 'dedi_sylius_sag_plugin.form.order_states_to_export',
                'required' => false,
                'multiple' => true,
                'choices' => $this->configurationContext->getAvailableOrderStatesToExport(),
                'choice_label' => function(string $choice): string {
                    return $choice;
                },
            ])
            ->add('orderPaymentStatesToExport', ChoiceType::class, [
                'label' => 'dedi_sylius_sag_plugin.form.order_payment_states_to_export',
                'required' => false,
                'multiple' => true,
                'choices' => $this->configurationContext->getAvailableOrderPaymentStatesToExport(),
                'choice_label' => function(string $choice): string {
                    return $choice;
                },
            ])
            ->add('orderShippingStatesToExport', ChoiceType::class, [
                'label' => 'dedi_sylius_sag_plugin.form.order_shipping_states_to_export',
                'required' => false,
                'multiple' => true,
                'choices' => $this->configurationContext->getAvailableOrderShippingStatesToExport(),
                'choice_label' => function(string $choice): string {
                    return $choice;
                },
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

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('constraints', [
                new ApiKeyConfigIsUniqueForLocalesAndChannels(['groups' => ['default', 'sylius']]),
            ])
            ->setDefault('validation_groups', ['default', 'sylius'])
        ;
    }
}
