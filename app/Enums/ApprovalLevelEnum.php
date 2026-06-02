<?php

namespace App\Enums;

enum ApprovalLevelEnum: int
{
    case KEPALA_BAGIAN = 1;
    case KEPALA_BIRO = 2;
    case PPTK = 3;

    public function label(): string
    {
        return match ($this) {
            self::KEPALA_BAGIAN => 'Kepala Bagian',
            self::KEPALA_BIRO => 'Kepala Biro',
            self::PPTK => 'PPTK',
        };
    }
}
