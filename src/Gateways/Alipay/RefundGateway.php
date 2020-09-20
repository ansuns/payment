<?php

namespace Ansuns\Pay\Gateways\Alipay;

class RefundGateway
{
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
            'method' => 'alipay.trade.fastpay.refund.query',
            'biz_content' => json_encode(is_array($order) ? $order : ['out_trade_no' => $order]),
        ];
    }
}
