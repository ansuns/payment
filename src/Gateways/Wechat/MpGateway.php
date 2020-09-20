<?php

namespace Ansuns\Pay\Gateways\Wechat;

use Exception;
use Ansuns\Pay\Events;
use Ansuns\Pay\Exceptions\GatewayException;
use Ansuns\Pay\Exceptions\InvalidArgumentException;
use Ansuns\Pay\Exceptions\InvalidSignException;
use Ansuns\Supports\Collection;
use Ansuns\Supports\Str;

class MpGateway extends Gateway
{
    /**
     * @var bool
     */
    protected $payRequestUseSubAppId = false;

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
     * @throws Exception
     */
    public function pay($endpoint, array $payload): Collection
    {
        $payload['trade_type'] = $this->getTradeType();

        $pay_request = [
            'appId' => !$this->payRequestUseSubAppId ? $payload['appid'] : $payload['sub_appid'],
            'timeStamp' => strval(time()),
            'nonceStr' => Str::random(),
            'package' => 'prepay_id='.$this->preOrder($payload)->get('prepay_id'),
            'signType' => 'MD5',
        ];
        $pay_request['paySign'] = Support::generateSign($pay_request);

        Events::dispatch(new Events\PayStarted('Wechat', 'JSAPI', $endpoint, $pay_request));

        return new Collection($pay_request);
    }

    /**
     * Get trade type config.
     *
     * @author ansuns
     */
    protected function getTradeType(): string
    {
        return 'JSAPI';
    }
}
