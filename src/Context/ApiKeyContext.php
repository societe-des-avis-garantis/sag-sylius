<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Context;

use Dedi\SyliusSAGPlugin\Entity\ApiKeyConfigInterface;
use Dedi\SyliusSAGPlugin\Repository\Config\ApiKeyConfigRepositoryInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;

final class ApiKeyContext implements ApiKeyContextInterface
{
    /** @var LocaleContextInterface */
    private $localeContext;

    /** @var ChannelContextInterface */
    private $channelContext;

    /** @var ApiKeyConfigRepositoryInterface */
    private $apiKeyConfigRepository;

    public function __construct(
        LocaleContextInterface $localeContext,
        ChannelContextInterface $channelContext,
        ApiKeyConfigRepositoryInterface $apiKeyConfigRepository
    ) {
        $this->localeContext = $localeContext;
        $this->channelContext = $channelContext;
        $this->apiKeyConfigRepository = $apiKeyConfigRepository;
    }

    public function getApiKey(): ?ApiKeyConfigInterface
    {
        $channelCode = $this->channelContext->getChannel()->getCode();
        if (null === $channelCode) {
            return null;
        }

        return $this->apiKeyConfigRepository->findOneByLocaleCodeAndChannelCode(
            $this->localeContext->getLocaleCode(),
            $channelCode
        );
    }

    public function findApiKeyByCountryCode(string $code): ?ApiKeyConfigInterface
    {
        return $this->apiKeyConfigRepository->findOneByCountryCode($code);
    }
}
