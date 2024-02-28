<?php

declare(strict_types=1);

namespace App\Response;

enum ResponseStatus: string
{
    case SUCCESS = 'success';
    case FAILURE = 'failure';
}
