<?php

namespace App\Enums;

enum RiwayatStatusEnum: string
{
    case DIPROSES = 'diproses';
    case SELESAI = 'selesai';
    case DITUNDA = 'ditunda';

    public function label(): string
    {
        return match ($this) {
            self::DIPROSES => 'Diproses',
            self::SELESAI => 'Selesai',
            self::DITUNDA => 'Ditunda',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DIPROSES => 'warning',
            self::SELESAI => 'success',
            self::DITUNDA => 'danger',
        };
    }
}
