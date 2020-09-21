<?php

namespace Ansuns\Payment\Exceptions;

class BusinessException extends GatewayException
{
    /**
     * Bootstrap.
     *
     * @author ansuns
     *
     * @param string       $message
     * @param array|string $raw
     */
    public function __construct($message, $raw = [])
    {
        parent::__construct('ERROR_BUSINESS: '.$message, $raw, self::ERROR_BUSINESS);
    }
}
