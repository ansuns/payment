<?php

namespace Ansuns\Payment\Gateways\Wechat;

use Symfony\Component\HttpFoundation\Request;
use Ansuns\Payment\Events;
use Ansuns\Payment\Exceptions\GatewayException;
use Ansuns\Payment\Exceptions\InvalidArgumentException;
use Ansuns\Payment\Exceptions\InvalidSignException;
use Ansuns\Payment\Gateways\Wechat;
use Ansuns\Supports\Collection;

class TransferGateway extends Gateway
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
        if (Wechat::MODE_SERVICE === $this->mode) {
            unset($payload['sub_mch_id'], $payload['sub_appid']);
        }

        $type = Support::getTypeName($payload['type'] ?? '');

        $payload['mch_appid'] = Support::getInstance()->getConfig($type, '');
        $payload['mchid'] = $payload['mch_id'];

        if ('cli' !== php_sapi_name() && !isset($payload['spbill_create_ip'])) {
            $payload['spbill_create_ip'] = Request::createFromGlobals()->server->get('SERVER_ADDR');
        }

        unset($payload['appid'], $payload['mch_id'], $payload['trade_type'],
            $payload['notify_url'], $payload['type']);

        $payload['sign'] = Support::generateSign($payload);

        Events::dispatch(new Events\PayStarted('Wechat', 'Transfer', $endpoint, $payload));

        return Support::requestApi(
            'mmpaymkttransfers/promotion/transfers',
            $payload,
            true
        );
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
            'endpoint' => 'mmpaymkttransfers/gettransferinfo',
            'order' => is_array($order) ? $order : ['partner_trade_no' => $order],
            'cert' => true,
        ];
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
