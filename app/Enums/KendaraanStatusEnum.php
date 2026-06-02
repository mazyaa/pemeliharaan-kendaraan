<?php

namespace App\Enums;

enum KendaraanStatusEnum: string
{
    case AKTIF = 'aktif';
    case SERVIS = 'servis';
    case RUSAK = 'rusak';
    case NONAKTIF = 'nonaktif';

    public function label(): string
    {
        return match ($this) {
            self::AKTIF => 'Aktif',
            self::SERVIS => 'Servis',
            self::RUSAK => 'Rusak',
            self::NONAKTIF => 'Nonaktif',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::AKTIF => 'success',
            self::SERVIS => 'warning',
            self::RUSAK => 'danger',
            self::NONAKTIF => 'info',
        };
    }
}
