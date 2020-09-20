<?php

namespace Ansuns\Pay\Contracts;

use Symfony\Component\HttpFoundation\Response;
use Ansuns\Supports\Collection;

interface GatewayApplicationInterface
{
    /**
     * To pay.
     *
     * @author yansongda <me@yansonga.cn>
     *
     * @param string $gateway
     * @param array  $params
     *
     * @return Collection|Response
     */
    public function pay($gateway, $params);

    /**
     * Query an order.
     *
     * @author ansuns
     *
     * @param string|array $order
     *
     * @return Collection
     */
    public function find($order, string $type);

    /**
     * Refund an order.
     *
     * @author ansuns
     *
     * @return Collection
     */
    public function refund(array $order);

    /**
     * Cancel an order.
     *
     * @author ansuns
     *
     * @param string|array $order
     *
     * @return Collection
     */
    public function cancel($order);

    /**
     * Close an order.
     *
     * @author ansuns
     *
     * @param string|array $order
     *
     * @return Collection
     */
    public function close($order);

    /**
     * Verify a request.
     *
     * @author ansuns
     *
     * @param string|array|null $content
     *
     * @return Collection
     */
    public function verify($content, bool $refund);

    /**
     * Echo success to server.
     *
     * @author ansuns
     *
     * @return Response
     */
    public function success();
}
