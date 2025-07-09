<?php

namespace App\Enums;

enum CourseStatusEnum: string
{
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Pending = 'pending';

    public function label(): string
    {
        return match ($this) {
            self::Approved => 'Aprovado',
            self::Rejected => 'Rejeitado',
            self::Pending => 'Pendente',
        };
    }
}
