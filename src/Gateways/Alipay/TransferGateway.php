<?php

namespace Ansuns\Payment\Gateways\Alipay;

use Ansuns\Payment\Contracts\GatewayInterface;
use Ansuns\Payment\Events;
use Ansuns\Payment\Exceptions\GatewayException;
use Ansuns\Payment\Exceptions\InvalidConfigException;
use Ansuns\Payment\Exceptions\InvalidSignException;
use Ansuns\Supports\Collection;

class TransferGateway implements GatewayInterface
{
    /**
     * Pay an order.
     *
     * @author ansuns
     *
     * @param string $endpoint
     *
     * @throws GatewayException
     * @throws InvalidConfigException
     * @throws InvalidSignException
     */
    public function pay($endpoint, array $payload): Collection
    {
        $payload['method'] = 'alipay.fund.trans.uni.transfer';
        $payload['sign'] = Support::generateSign($payload);

        Events::dispatch(new Events\PayStarted('Alipay', 'Transfer', $endpoint, $payload));

        return Support::requestApi($payload);
    }

    /**
     * Find.
     *
     * @author ansuns
     *
     * @param $order
     */
    public function find($order): array
    {
        return [
            'method' => 'alipay.fund.trans.order.query',
            'biz_content' => json_encode(is_array($order) ? $order : ['out_biz_no' => $order]),
        ];
    }
}
