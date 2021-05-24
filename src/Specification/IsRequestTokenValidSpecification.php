<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Specification;

use Dedi\SyliusSAGPlugin\Api\TokenValidatorInterface;
use Dedi\SyliusSAGPlugin\Model\Api\ApiTokenAwareRequestInterface;

class IsRequestTokenValidSpecification
{
    /** @var TokenValidatorInterface */
    private $tokenValidator;

    public function __construct(
        TokenValidatorInterface $tokenValidator
    ) {
        $this->tokenValidator = $tokenValidator;
    }

    public function __invoke(
        ApiTokenAwareRequestInterface $request
    ): bool {
        return $this->tokenValidator->__invoke($request);
    }
}
