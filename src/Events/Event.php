<?php

namespace Ansuns\Payment\Events;

use Symfony\Contracts\EventDispatcher\Event as SymfonyEvent;

class Event extends SymfonyEvent
{
    /**
     * Driver.
     *
     * @var string
     */
    public $driver;

    /**
     * Method.
     *
     * @var string
     */
    public $gateway;

    /**
     * Extra attributes.
     *
     * @var mixed
     */
    public $attributes;

    /**
     * Bootstrap.
     *
     * @author ansuns
     */
    public function __construct(string $driver, string $gateway)
    {
        $this->driver = $driver;
        $this->gateway = $gateway;
    }
}
