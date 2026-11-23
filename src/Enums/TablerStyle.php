<?php

namespace Filafly\Icons\Tabler\Enums;

use Filafly\Icons\Contracts\StyleEnum;

enum TablerStyle: string implements StyleEnum
{
    case Outline = '';
    case Filled = '-filled';

    public function getStyleName(): string
    {
        return match ($this) {
            self::Outline => 'outline',
            self::Filled => 'filled',
        };
    }

    public function getEnumSuffix(): string
    {
        return match ($this) {
            self::Outline => 'Outline',
            self::Filled => 'Filled',
        };
    }

    public static function getStyleNames(): array
    {
        return ['outline', 'filled'];
    }

    public static function fromStyleName(string $styleName): ?self
    {
        return match (strtolower($styleName)) {
            'outline' => self::Outline,
            'filled' => self::Filled,
            default => null,
        };
    }
}
