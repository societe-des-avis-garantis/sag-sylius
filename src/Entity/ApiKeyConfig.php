<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Locale\Model\LocaleInterface;

class ApiKeyConfig implements ApiKeyConfigInterface
{
    /** @var mixed|null */
    protected $id;

    /**
     * @var int
     *
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected $idSite;

    /**
     * @var string
     *
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected $countryCode;

    /**
     * @var string
     *
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected $key;

    /** @var ?string */
    protected $certificateOfTruthUrl;

    /**
     * @var Collection|LocaleInterface[]
     *
     * @psalm-var Collection<array-key, LocaleInterface>
     */
    protected $locales;

    /**
     * @var Collection|ChannelInterface[]
     *
     * @psalm-var Collection<array-key, ChannelInterface>
     */
    protected $channels;

    public function __construct()
    {
        $this->locales = new ArrayCollection();
        $this->channels = new ArrayCollection();
    }

    /**
     * @return mixed|null
     */
    public function getId()
    {
        return $this->id;
    }

    public function getIdSite(): int
    {
        return $this->idSite;
    }

    public function setIdSite(int $idSite): ApiKeyConfigInterface
    {
        $this->idSite = $idSite;

        return $this;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): ApiKeyConfigInterface
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(string $key): ApiKeyConfigInterface
    {
        $this->key = $key;

        return $this;
    }

    public function getApiKey(): string
    {
        return implode('/', [
            $this->idSite,
            $this->countryCode,
            $this->key,
        ]);
    }

    public function getCertificateOfTruthUrl(): ?string
    {
        return $this->certificateOfTruthUrl;
    }

    public function setCertificateOfTruthUrl(?string $certificateOfTruthUrl): ApiKeyConfigInterface
    {
        $this->certificateOfTruthUrl = $certificateOfTruthUrl;

        return $this;
    }

    public function getLocales(): Collection
    {
        return $this->locales;
    }

    public function addLocale(LocaleInterface $locale): ApiKeyConfigInterface
    {
        if (!$this->hasLocale($locale)) {
            $this->locales->add($locale);
        }

        return $this;
    }

    public function removeLocale(LocaleInterface $locale): ApiKeyConfigInterface
    {
        if ($this->hasLocale($locale)) {
            $this->locales->removeElement($locale);
        }

        return $this;
    }

    public function hasLocale(LocaleInterface $locale): bool
    {
        return $this->locales->contains($locale);
    }

    public function getChannels(): Collection
    {
        return $this->channels;
    }

    public function addChannel(ChannelInterface $channel): ApiKeyConfigInterface
    {
        if (!$this->hasChannel($channel)) {
            $this->channels->add($channel);
        }

        return $this;
    }

    public function removeChannel(ChannelInterface $channel): ApiKeyConfigInterface
    {
        if ($this->hasChannel($channel)) {
            $this->channels->removeElement($channel);
        }

        return $this;
    }

    public function hasChannel(ChannelInterface $channel): bool
    {
        return $this->channels->contains($channel);
    }
}
