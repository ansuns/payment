<?php

namespace Ansuns\Pay\Gateways\Alipay;

use Symfony\Component\HttpFoundation\Response;
use Ansuns\Pay\Events;
use Ansuns\Pay\Exceptions\InvalidArgumentException;
use Ansuns\Pay\Exceptions\InvalidConfigException;
use Ansuns\Pay\Gateways\Alipay;

class AppGateway extends Gateway
{
    /**
     * Pay an order.
     *
     * @author ansuns
     *
     * @param string $endpoint
     *
     * @throws InvalidConfigException
     * @throws InvalidArgumentException
     */
    public function pay($endpoint, array $payload): Response
    {
        $payload['method'] = 'alipay.trade.app.pay';

        $biz_array = json_decode($payload['biz_content'], true);
        if ((Alipay::MODE_SERVICE === $this->mode) && (!empty(Support::getInstance()->pid))) {
            $biz_array['extend_params'] = is_array($biz_array['extend_params']) ? array_merge(['sys_service_provider_id' => Support::getInstance()->pid], $biz_array['extend_params']) : ['sys_service_provider_id' => Support::getInstance()->pid];
        }
        $payload['biz_content'] = json_encode(array_merge($biz_array, ['product_code' => 'QUICK_MSECURITY_PAY']));
        $payload['sign'] = Support::generateSign($payload);

        Events::dispatch(new Events\PayStarted('Alipay', 'App', $endpoint, $payload));

        return new Response(http_build_query($payload));
    }
}
