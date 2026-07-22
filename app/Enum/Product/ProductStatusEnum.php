<?php

namespace App\Enum\Product;

enum ProductStatusEnum:string
{
    case DRAFT = 'Draft';
    case ACTIVE = 'Active';
    case INACTIVE = 'Inactive';
    case OUT_OF_STOCK = 'Out_of_stock';
}
