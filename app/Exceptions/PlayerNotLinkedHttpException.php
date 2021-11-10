<?php

namespace App\Exceptions;

class PlayerNotLinkedHttpException extends NoAccessHttpException
{
    protected string $resMsg = 'Player Not Linked';
}
