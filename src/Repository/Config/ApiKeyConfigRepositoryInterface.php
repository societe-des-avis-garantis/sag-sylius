<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Repository\Config;

use Dedi\SyliusSAGPlugin\Entity\ApiKeyConfigInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface ApiKeyConfigRepositoryInterface extends RepositoryInterface
{
    public function findOneByLocaleCodeAndChannelCode(
        string $localeCode,
        string $channelCode
    ): ?ApiKeyConfigInterface;
}
