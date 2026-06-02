<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case PENGELOLA_KENDARAAN = 'pengelola_kendaraan';
    case KEPALA_BAGIAN = 'kepala_bagian';
    case KEPALA_BIRO = 'kepala_biro';
    case PPTK = 'pptk';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::PENGELOLA_KENDARAAN => 'Pengelola Kendaraan',
            self::KEPALA_BAGIAN => 'Kepala Bagian',
            self::KEPALA_BIRO => 'Kepala Biro',
            self::PPTK => 'PPTK',
        };
    }

    public static function options(): array
    {
        return [
            self::ADMIN,
            self::PENGELOLA_KENDARAAN,
            self::KEPALA_BAGIAN,
            self::KEPALA_BIRO,
            self::PPTK,
        ];
    }
}
