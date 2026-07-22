<?php

namespace App\Enum\Notification;

enum NotificationTypeEnum:string
{
       case ORDER_CREATED = 'order_created';
    case ORDER_SHIPPED = 'order_shipped';
    case PAYMENT_SUCCESS = 'payment_success';
    case PAYMENT_FAILED = 'payment_failed';
    case PROMOTION = 'promotion';
    case SYSTEM_ALERT = 'system_alert';
}
