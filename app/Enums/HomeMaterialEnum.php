<?php

namespace App\Enums;

enum HomeMaterialEnum: string
{
    case OnlyTin = 'only tin';
    case TinAndConcrete = 'tin and concrete';
    case Building = 'building';
    case TinAndBamboo = 'tin and Bamboo without concrete floor';
}
