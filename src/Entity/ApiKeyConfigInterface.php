<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Entity;

use Dedi\SyliusSAGPlugin\Entity\Channel\ChannelInterface;
use Dedi\SyliusSAGPlugin\Model\ApiKeyInterface;
use Dedi\SyliusSAGPlugin\Model\CertificateOfTruthAwareInterface;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface ApiKeyConfigInterface extends ResourceInterface, ApiKeyInterface, CertificateOfTruthAwareInterface
{
    public function getApiKey(): string;

    public function setApiKey(?string $apiKey): self;

    public function setCertificateOfTruthUrl(?string $certificateOfTruthUrl): self;

    /**
     * @return string[]
     */
    public function getOrderStatesToExport(): array;

    /**
     * @param string[] $orderStatesToExport
     *
     * @return ApiKeyConfigInterface
     */
    public function setOrderStatesToExport(array $orderStatesToExport): self;

    public function getOrderPaymentStatesToExport(): array;

    /**
     * @param string[] $orderPaymentStatesToExport
     *
     * @return ApiKeyConfigInterface
     */
    public function setOrderPaymentStatesToExport(array $orderPaymentStatesToExport): self;

    public function getOrderShippingStatesToExport(): array;

    /**
     * @param string[] $orderShippingStatesToExport
     *
     * @return ApiKeyConfigInterface
     */
    public function setOrderShippingStatesToExport(array $orderShippingStatesToExport): self;

    /**
     * @return Collection<array-key, LocaleInterface>
     */
    public function getLocales(): Collection;

    public function addLocale(LocaleInterface $locale): self;

    public function removeLocale(LocaleInterface $locale): self;

    public function hasLocale(LocaleInterface $locale): bool;

    /**
     * @return Collection<array-key, ChannelInterface>
     */
    public function getChannels(): Collection;

    public function addChannel(ChannelInterface $channel): self;

    public function removeChannel(ChannelInterface $channel): self;

    public function hasChannel(ChannelInterface $channel): bool;
}
