<?php

namespace Base\Base\Enums;


enum OtpType: int
{
    case FIRST_ACCESS = 1;
    case PASSWORD_RESET = 2;
}
