<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Model;

class CertificateOfTruth
{
    /** @var string */
    private $link;

    public function __construct(
        string $link
    ) {
        $this->link = $link;
    }

    public function getLink(): string
    {
        return $this->link;
    }
}
