<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Repository\Config;

use Dedi\SyliusSAGPlugin\Entity\ApiKeyConfigInterface;
use Dedi\SyliusSAGPlugin\Entity\Channel\ChannelInterface;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface ApiKeyConfigRepositoryInterface extends RepositoryInterface
{
    public function findOneByLocaleCodeAndChannelCode(
        string $localeCode,
        string $channelCode
    ): ?ApiKeyConfigInterface;

    /**
     * @param mixed|null $id
     * @param LocaleInterface[] $locales
     * @param ChannelInterface[] $channels
     */
    public function countFindWithSimilarConfiguration(
        $id,
        array $locales,
        array $channels
    ): int;

    public function findOneByCountryCode(string $code): ?ApiKeyConfigInterface;
}
