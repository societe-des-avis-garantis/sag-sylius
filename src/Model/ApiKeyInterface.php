<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Model;

interface ApiKeyInterface
{
    public function getIdSite(): int;

    public function getCountryCode(): string;

    public function getKey(): string;

    public function getApiKey(): string;
}
