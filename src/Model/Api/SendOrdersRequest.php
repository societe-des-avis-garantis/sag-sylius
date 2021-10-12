<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Model\Api;

class SendOrdersRequest implements ApiTokenAwareRequestInterface
{
    /** @var string */
    private $token;

    /** @var string */
    private $countryCode;

    /** @var \DateTimeImmutable */
    private $from;

    /** @var \DateTimeImmutable */
    private $to;

    public function __construct(
        string $token,
        string $countryCode,
        \DateTimeImmutable $from,
        \DateTimeImmutable $to
    ) {
        $this->token = $token;
        $this->countryCode = $countryCode;
        $this->from = $from;
        $this->to = $to;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function getFrom(): \DateTimeImmutable
    {
        return $this->from;
    }

    public function getTo(): \DateTimeImmutable
    {
        return $this->to;
    }
}
