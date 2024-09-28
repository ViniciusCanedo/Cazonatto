<?php

namespace App\Routes\Enums;

enum RouteWildcards: string
{
    case numeric = '[0-9]+';
    case alpha = '[a-z]+';
    case any = '[a-z0-9\-]+';
}
