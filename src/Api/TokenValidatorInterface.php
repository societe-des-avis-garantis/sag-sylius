<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Api;

use Dedi\SyliusSAGPlugin\Model\Api\ApiTokenAwareRequestInterface;

interface TokenValidatorInterface
{
    public function __invoke(ApiTokenAwareRequestInterface $request): bool;
}
