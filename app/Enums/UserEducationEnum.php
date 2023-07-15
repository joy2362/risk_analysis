<?php

namespace App\Enums;

enum UserEducationEnum: string
{
    case NoEducation = 'no education';
    case PassPSC = 'pass PSC';
    case PassJSC = 'pass JSC';
    case SSCPass = 'SSC pass';
    case HSCPass = 'HSC Pass';
    case Graduation = 'graduation';
    case PostGraduation = 'Post-Graduation';

}
