<?php

namespace App\Enum\Payment;

enum PaymentMethodTypeEnum:string
{
    case CREDIT_CARD = 'credit_card';
    case E_WALLET = 'e_wallet';
    case BANK_TRANSFER = 'bank_transfer';
    case CASH_ON_DELIVERY = 'cash_on_delivery';
}
