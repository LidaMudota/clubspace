<?php

namespace App\Enums;

enum BookingStatus: string
{
    case Draft = 'draft';
    case Confirmed = 'confirmed';
    case Cancelled = 'cancelled';
    case Refunded = 'refunded';
}
