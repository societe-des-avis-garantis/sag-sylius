<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Entity\Channel;

use Sylius\Component\Core\Model\ChannelInterface as BaseChannelInterface;

interface ChannelInterface extends BaseChannelInterface
{
    public function getSAGShowJavascriptWidget(): bool;

    public function setSAGShowJavascriptWidget(bool $SAGShowJavascriptWidget): self;

    public function getSAGShowIframeWidget(): bool;

    public function setSAGShowIframeWidget(bool $SAGShowIframeWidget): self;

    public function getSAGShowFooterCertificateLink(): bool;

    public function setSAGShowFooterCertificateLink(bool $SAGShowFooterCertificateLink): self;
}
