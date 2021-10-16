<?php

namespace App\Exceptions;

class NotAuthHttpException extends BaseHttpException
{
    protected int $resCode = 401;
    protected string $resMsg = 'Unauthorized';
}
