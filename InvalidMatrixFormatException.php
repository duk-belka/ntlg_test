<?php
/**
 * Created by PhpStorm.
 * User: neduck
 * Date: 06/10/2018
 * Time: 19:08
 */

namespace App;

class InvalidMatrixFormatException extends \Exception
{
    /**
     * InvalidMatrixFormatException constructor.
     *
     * @param string          $message
     * @param int             $code
     * @param \Throwable|null $previous
     */
    public function __construct(
        string $message = 'Invalid matrix format',
        int $code = 500,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}