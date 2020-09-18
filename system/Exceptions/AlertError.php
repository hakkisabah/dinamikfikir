<?php namespace CodeIgniter\Exceptions;

/**
 * Error: Action must be taken immediately (system/db down, etc)
 */

class AlertError extends \Error
{
    /**
     * Error code
     *
     * @var integer
     */
    protected $code = 404;

    public static function xssError(string $message = null)
    {
        return new static($message ?? 'Uygunsuz bir davranış sergilediniz.');
    }
}
