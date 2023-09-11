<?php

namespace App\Enums;

enum ShopStatus: int
{
    case ACTIVE = 1;
    case IN_ACTIVE = 0;
    case PENDING = -1;
}
