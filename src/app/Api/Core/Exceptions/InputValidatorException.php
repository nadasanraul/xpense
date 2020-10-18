<?php

namespace App\Api\Core\Exceptions;

use Throwable;

/**
 * Class InputValidatorException
 * @package App\Api\Core\Exceptions
 */
class InputValidatorException extends \Exception
{
    public $errors;

    /**
     * InputValidatorException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $this->errors = json_decode($message, true);
        parent::__construct($message, $code, $previous);
    }
}
