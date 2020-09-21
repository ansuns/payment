<?php

namespace Ansuns\Payment\Gateways\Alipay;

use Ansuns\Payment\Contracts\GatewayInterface;
use Ansuns\Payment\Exceptions\InvalidArgumentException;
use Ansuns\Supports\Collection;

abstract class Gateway implements GatewayInterface
{
    /**
     * Mode.
     *
     * @var string
     */
    protected $mode;

    /**
     * Bootstrap.
     *
     * @author ansuns
     *
     * @throws InvalidArgumentException
     */
    public function __construct()
    {
        $this->mode = Support::getInstance()->mode;
    }

    /**
     * Pay an order.
     *
     * @author ansuns
     *
     * @param string $endpoint
     *
     * @return Collection
     */
    abstract public function pay($endpoint, array $payload);
}
