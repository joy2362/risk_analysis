<?php

namespace App\Enums;

enum ChildProfessionEnum: string
{
    case AgeLessThan5Years = 'age less than 5 years';
    case StudentClass1To5 = 'student class 1-5';
    case StudentClass6ToHigh = 'student class 6 to high';
    case JobHolder = 'job Holder';
}
