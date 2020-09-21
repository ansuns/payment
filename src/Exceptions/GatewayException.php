<?php

namespace Ansuns\Payment\Exceptions;

class GatewayException extends Exception
{
    /**
     * Bootstrap.
     *
     * @author ansuns
     *
     * @param string       $message
     * @param array|string $raw
     * @param int          $code
     */
    public function __construct($message, $raw = [], $code = self::ERROR_GATEWAY)
    {
        parent::__construct('ERROR_GATEWAY: '.$message, $raw, $code);
    }
}
