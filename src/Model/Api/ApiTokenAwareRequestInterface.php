<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Model\Api;

interface ApiTokenAwareRequestInterface
{
    public function getToken(): string;

    public function getCountryCode(): string;
}
