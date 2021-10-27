<?php

declare(strict_types=1);

namespace Tests\Dedi\SyliusSAGPlugin\Application\src\Entity\Channel;

use Dedi\SyliusSAGPlugin\Entity\Channel\ChannelInterface as DediSAGChannelInterface;
use Dedi\SyliusSAGPlugin\Entity\Channel\ChannelTrait as DediSAGChannelTrait;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Channel as BaseChannel;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_channel")
 */
class Channel extends BaseChannel implements DediSAGChannelInterface
{
    use DediSAGChannelTrait;
}
