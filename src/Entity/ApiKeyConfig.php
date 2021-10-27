<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Entity;

use Dedi\SyliusSAGPlugin\Entity\Channel\ChannelInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Locale\Model\LocaleInterface;

class ApiKeyConfig implements ApiKeyConfigInterface
{
    /** @var mixed|null */
    protected $id;

    /**
     * @var string|null
     *
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected $apiKey;

    /** @var ?string */
    protected $certificateOfTruthUrl;

    /** @var string[] */
    protected $orderStatesToExport = [];

    /** @var string[] */
    protected $orderPaymentStatesToExport = [];

    /** @var string[] */
    protected $orderShippingStatesToExport = [];

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

    public function getApiKey(): string
    {
        return $this->apiKey ?? '';
    }

    public function setApiKey(?string $apiKey): ApiKeyConfigInterface
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    private function getApiKeyArray(): array
    {
        preg_match(self::VALUE_REGEX, $this->getApiKey(), $matches);
        if (count($matches) < 4) {
            throw new \LogicException(sprintf(
                'Api Key "%s" with id "%s" does not have a valid format.',
                $this->getApiKey(),
                $this->id,
            ));
        }

        return $matches;
    }

    public function getIdSite(): int
    {
        return (int) $this->getApiKeyArray()[1];
    }

    public function getCountryCode(): string
    {
        return (string) $this->getApiKeyArray()[2];
    }

    public function getKey(): string
    {
        return (string) $this->getApiKeyArray()[3];
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

    public function getOrderStatesToExport(): array
    {
        return $this->orderStatesToExport;
    }

    public function setOrderStatesToExport(array $orderStatesToExport): ApiKeyConfigInterface
    {
        $this->orderStatesToExport = $orderStatesToExport;

        return $this;
    }

    public function getOrderPaymentStatesToExport(): array
    {
        return $this->orderPaymentStatesToExport;
    }

    public function setOrderPaymentStatesToExport(array $orderPaymentStatesToExport): ApiKeyConfigInterface
    {
        $this->orderPaymentStatesToExport = $orderPaymentStatesToExport;

        return $this;
    }

    public function getOrderShippingStatesToExport(): array
    {
        return $this->orderShippingStatesToExport;
    }

    public function setOrderShippingStatesToExport(array $orderShippingStatesToExport): ApiKeyConfigInterface
    {
        $this->orderShippingStatesToExport = $orderShippingStatesToExport;

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
