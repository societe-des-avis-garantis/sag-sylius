<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Model\Api;

class FetchReviewsRequest
{
    /** @var string */
    private $countryCode;

    /** @var array */
    private $queryParams;

    public function __construct(
        string $countryCode,
        array $queryParams
    ) {
        $this->countryCode = $countryCode;
        $this->queryParams = $queryParams;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }
}
