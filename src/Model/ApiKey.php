<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Model;

// todo https://www.doctrine-project.org/projects/doctrine-orm/en/2.8/tutorials/embeddables.html
class ApiKey
{
    /** @var int */
    private $idSite;

    /** @var string */
    private $countryCode;

    /** @var string */
    private $key;

    public function __construct(
        int $idSite,
        string $countryCode,
        string $key
    ) {
        $this->idSite = $idSite;
        $this->countryCode = $countryCode;
        $this->key = $key;
    }

    public function getIdSite(): int
    {
        return $this->idSite;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getApiKey(): string
    {
        return implode('/', [
            $this->idSite,
            $this->countryCode,
            $this->key,
        ]);
    }
}
