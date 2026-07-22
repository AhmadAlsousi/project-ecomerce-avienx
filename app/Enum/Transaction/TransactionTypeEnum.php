<?php

namespace App\Enum\Transaction;

enum TransactionTypeEnum:string
{
      case AUTHORIZATION = 'authorization';
    case CAPTURE = 'capture';
    case REFUND = 'refund';
    case VOID = 'void';
}
