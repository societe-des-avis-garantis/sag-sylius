<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Enum;

use Sylius\Component\Review\Model\ReviewInterface;

class SagStatusEnum
{
    public const SAG_PENDING = 0;
    public const SAG_APPROVED = 1;
    public const SAG_DELETED = 2;

    public static function sagToSylius(?int $sagStatus): string
    {
        switch ($sagStatus) {
            case self::SAG_APPROVED:
                return ReviewInterface::STATUS_ACCEPTED;
            case self::SAG_DELETED:
                return ReviewInterface::STATUS_REJECTED;
            default:
                return ReviewInterface::STATUS_NEW;
        }
    }
}
