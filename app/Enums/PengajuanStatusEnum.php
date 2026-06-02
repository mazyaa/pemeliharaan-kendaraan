<?php

namespace App\Enums;

enum PengajuanStatusEnum: string
{
    case DRAFT = 'draft';
    case SUBMITTED = 'submitted';
    case APPROVED_KABAG = 'approved_kabag';
    case REJECTED_KABAG = 'rejected_kabag';
    case DISPOSED_BIRO = 'disposed_biro';
    case REJECTED_BIRO = 'rejected_biro';
    case APPROVED_PPTK = 'approved_pptk';
    case REJECTED_PPTK = 'rejected_pptk';
    case SPK_GENERATED = 'spk_generated';
    case COMPLETED = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::SUBMITTED => 'Diajukan',
            self::APPROVED_KABAG => 'Disetujui Kabag',
            self::REJECTED_KABAG => 'Ditolak Kabag',
            self::DISPOSED_BIRO => 'Didisposisi Biro',
            self::REJECTED_BIRO => 'Ditolak Biro',
            self::APPROVED_PPTK => 'Disetujui PPTK',
            self::REJECTED_PPTK => 'Ditolak PPTK',
            self::SPK_GENERATED => 'SPK Diterbitkan',
            self::COMPLETED => 'Selesai',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT => 'secondary',
            self::SUBMITTED => 'info',
            self::APPROVED_KABAG => 'success',
            self::REJECTED_KABAG => 'danger',
            self::DISPOSED_BIRO => 'primary',
            self::REJECTED_BIRO => 'danger',
            self::APPROVED_PPTK => 'success',
            self::REJECTED_PPTK => 'danger',
            self::SPK_GENERATED => 'warning',
            self::COMPLETED => 'success',
        };
    }

    public function isTerminal(): bool
    {
        return in_array($this, [
            self::REJECTED_KABAG,
            self::REJECTED_BIRO,
            self::REJECTED_PPTK,
            self::COMPLETED,
        ]);
    }
}
