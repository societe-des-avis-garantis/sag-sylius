<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Context;

interface ApiContextInterface
{
    public const ENDPOINT_CODE_CHECK_TOKEN = 'ENDPOINT_CODE_CHECK_TOKEN';

    public const ENDPOINT_CODE_ORDER_EXPORT = 'ENDPOINT_CODE_ORDER_EXPORT';

    public function getUrl(
        string $endpointCode,
        string $countryCode
    ): string;

    public function getDomain(string $countryCode): string;
}
