<?php

namespace Ansuns\Payment\Gateways\Wechat;

use Ansuns\Payment\Events;
use Ansuns\Payment\Exceptions\GatewayException;
use Ansuns\Payment\Exceptions\InvalidArgumentException;
use Ansuns\Payment\Exceptions\InvalidSignException;
use Ansuns\Payment\Gateways\Wechat;
use Ansuns\Supports\Collection;

class GroupRedpackGateway extends Gateway
{
    /**
     * Pay an order.
     *
     * @author ansuns
     *
     * @param string $endpoint
     *
     * @throws GatewayException
     * @throws InvalidArgumentException
     * @throws InvalidSignException
     */
    public function pay($endpoint, array $payload): Collection
    {
        $payload['wxappid'] = $payload['appid'];
        $payload['amt_type'] = 'ALL_RAND';

        if (Wechat::MODE_SERVICE === $this->mode) {
            $payload['msgappid'] = $payload['appid'];
        }

        unset($payload['appid'], $payload['trade_type'],
              $payload['notify_url'], $payload['spbill_create_ip']);

        $payload['sign'] = Support::generateSign($payload);

        Events::dispatch(new Events\PayStarted('Wechat', 'Group Redpack', $endpoint, $payload));

        return Support::requestApi(
            'mmpaymkttransfers/sendgroupredpack',
            $payload,
            true
        );
    }

    /**
     * Get trade type config.
     *
     * @author ansuns
     */
    protected function getTradeType(): string
    {
        return '';
    }
}
