<?php

namespace App\Enum\Transaction;

enum TransactionStatusEnum:string
{
        case SUCCESS = 'success';
    case FAILED = 'failed';
    case PENDING = 'pending';

}
