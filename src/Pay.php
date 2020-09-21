<?php

namespace Ansuns\Payment;

use Exception;
use Ansuns\Payment\Contracts\GatewayApplicationInterface;
use Ansuns\Payment\Exceptions\InvalidGatewayException;
use Ansuns\Payment\Gateways\Alipay;
use Ansuns\Payment\Gateways\Wechat;
use Ansuns\Payment\Listeners\KernelLogSubscriber;
use Ansuns\Supports\Config;
use Ansuns\Supports\Log;
use Ansuns\Supports\Logger;
use Ansuns\Supports\Str;

/**
 * @method static Alipay alipay(array $config) 支付宝
 * @method static Wechat wechat(array $config) 微信
 */
class Pay
{
    /**
     * Config.
     *
     * @var Config
     */
    protected $config;

    /**
     * Bootstrap.
     *
     * @author ansuns
     *
     * @throws Exception
     */
    public function __construct(array $config)
    {
        $this->config = new Config($config);

        $this->registerLogService();
        $this->registerEventService();
    }

    /**
     * Magic static call.
     *
     * @author ansuns
     *
     * @param string $method
     * @param array  $params
     *
     * @throws InvalidGatewayException
     * @throws Exception
     */
    public static function __callStatic($method, $params): GatewayApplicationInterface
    {
        $app = new self(...$params);

        return $app->create($method);
    }

    /**
     * Create a instance.
     *
     * @author ansuns
     *
     * @param string $method
     *
     * @throws InvalidGatewayException
     */
    protected function create($method): GatewayApplicationInterface
    {
        $gateway = __NAMESPACE__.'\\Gateways\\'.Str::studly($method);

        if (class_exists($gateway)) {
            return self::make($gateway);
        }

        throw new InvalidGatewayException("Gateway [{$method}] Not Exists");
    }

    /**
     * Make a gateway.
     *
     * @author yansongda <me@yansonga.cn>
     *
     * @param string $gateway
     *
     * @throws InvalidGatewayException
     */
    protected function make($gateway): GatewayApplicationInterface
    {
        $app = new $gateway($this->config);

        if ($app instanceof GatewayApplicationInterface) {
            return $app;
        }

        throw new InvalidGatewayException("Gateway [{$gateway}] Must Be An Instance Of GatewayApplicationInterface");
    }

    /**
     * Register log service.
     *
     * @author ansuns
     *
     * @throws Exception
     */
    protected function registerLogService()
    {
        $config = $this->config->get('log');
        $config['identify'] = 'yansongda.pay';

        $logger = new Logger();
        $logger->setConfig($config);

        Log::setInstance($logger);
    }

    /**
     * Register event service.
     *
     * @author ansuns
     */
    protected function registerEventService()
    {
        Events::setDispatcher(Events::createDispatcher());

        Events::addSubscriber(new KernelLogSubscriber());
    }
}
