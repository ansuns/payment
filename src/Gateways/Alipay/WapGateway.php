<?php

namespace Ansuns\Pay\Gateways\Alipay;

class WapGateway extends WebGateway
{
    /**
     * Get method config.
     *
     * @author ansuns
     */
    protected function getMethod(): string
    {
        return 'alipay.trade.wap.pay';
    }

    /**
     * Get productCode config.
     *
     * @author ansuns
     */
    protected function getProductCode(): string
    {
        return 'QUICK_WAP_WAY';
    }
}
