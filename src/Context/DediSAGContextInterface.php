<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Context;

use Dedi\SyliusSAGPlugin\Model\ApiKey;

interface DediSAGContextInterface
{
    public function getApiKey(): ?ApiKey;
}
