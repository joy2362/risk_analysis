<?php

namespace App\Enums;

enum LoanUserForEnum: string
{
    case COW = 'cow';
    case CAR = 'car';
    case NOT_SURE = 'not sure';
    case OTHER = 'other';
    case AGRICULTURE = 'agriculture';
    case PLOTLY_FARM = 'plotly farm';
    case BUSINESS = 'business';
}
