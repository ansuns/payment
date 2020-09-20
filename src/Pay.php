<?php

namespace Ansuns\Payment;

class Pay
{
    /**
     * config
     * @var
     */
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

}