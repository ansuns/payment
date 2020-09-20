<?php

namespace Ansuns\Pay\Gateways\Alipay;

use Ansuns\Pay\Contracts\GatewayInterface;
use Ansuns\Pay\Exceptions\InvalidArgumentException;
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
