<?php

namespace Ansuns\Payment\Contracts;

use Symfony\Component\HttpFoundation\Response;
use Ansuns\Supports\Collection;

interface GatewayInterface
{
    /**
     * Pay an order.
     *
     * @author ansuns
     *
     * @param string $endpoint
     *
     * @return Collection|Response
     */
    public function pay($endpoint, array $payload);
}
