<?php

namespace Coderflex\LaravelTurnstile\Exceptions;

use Exception;

class UnkownErrorOccuredException extends Exception
{
    protected int $status = 500;
}
