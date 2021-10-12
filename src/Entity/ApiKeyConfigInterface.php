<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Entity;

use Dedi\SyliusSAGPlugin\Model\ApiKeyInterface;
use Dedi\SyliusSAGPlugin\Model\CertificateOfTruthAwareInterface;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface ApiKeyConfigInterface extends ResourceInterface, ApiKeyInterface, CertificateOfTruthAwareInterface
{
    public function setIdSite(int $idSite): ApiKeyConfigInterface;

    public function setCountryCode(string $countryCode): ApiKeyConfigInterface;

    public function setKey(string $key): ApiKeyConfigInterface;

    public function setCertificateOfTruthUrl(?string $certificateOfTruthUrl): self;

    /**
     * @return Collection<array-key, LocaleInterface>
     */
    public function getLocales(): Collection;

    public function addLocale(LocaleInterface $locale): self;

    public function removeLocale(LocaleInterface $locale): self;

    public function hasLocale(LocaleInterface $locale): bool;
}
