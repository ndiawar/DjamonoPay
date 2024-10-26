<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserRole extends Enum
{
    const CLIENT = 'client';
    const DISTRIBUTEUR = 'distributeur';
    const AGENT = 'agent';

    public static function getDescription($value): string
    {
        return match ($value) {
            self::CLIENT => 'Client',
            self::DISTRIBUTEUR => 'Distributeur',
            self::AGENT => 'Agent',
            default => parent::getDescription($value),
        };
    }

    public static function getRoleColors(): array
    {
        return [
            self::CLIENT => 'blue',
            self::DISTRIBUTEUR => 'green',
            self::AGENT => 'red',
        ];
    }

    public static function getRoleIcon($value): string
    {
        return match ($value) {
            self::CLIENT => 'user',
            self::DISTRIBUTEUR => 'store',
            self::AGENT => 'shield',
            default => 'user',
        };
    }

    public static function canManageUsers($value): bool
    {
        return $value === self::AGENT;
    }

    public static function canManageTransactions($value): bool
    {
        return in_array($value, [self::AGENT, self::DISTRIBUTEUR]);
    }
}
