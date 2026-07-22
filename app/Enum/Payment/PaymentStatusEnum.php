<?php

namespace App\Enum\Payment;

enum PaymentStatusEnum:string
{
    case PENDING = 'pending';
    case AUTHORIZED = 'authorized';
    case PAID = 'paid';
    case FAILED = 'failed';
    case REFUNDED = 'refunded';
    case PARTIALLY_REFUNDED = 'partially_refunded';
}
