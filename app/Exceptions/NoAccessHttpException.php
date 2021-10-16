<?php

namespace App\Exceptions;

class NoAccessHttpException extends BaseHttpException
{
    protected int $resCode = 403;
    protected string $resMsg = 'No Access';
}
