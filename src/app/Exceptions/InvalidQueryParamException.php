<?php

namespace App\Exceptions;

use Throwable;

/**
 * Class InvalidQueryParamException
 * @package App\Exceptions
 */
class InvalidQueryParamException extends \Exception
{
    /**
     * InvalidQueryParamException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
