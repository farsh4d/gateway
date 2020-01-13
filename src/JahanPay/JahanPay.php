<?php

namespace Larabookir\Gateway\JahanPay;

use Illuminate\Support\Facades\Request;
use Larabookir\Gateway\Enum;
use SoapClient;
use Larabookir\Gateway\PortAbstract;
use Larabookir\Gateway\PortInterface;
use Illuminate\Support\Facades\DB;

class JahanPay extends PortAbstract implements PortInterface
{
    /**
     * Address of main SOAP server
     *
     * @var string
     */
    protected $serverUrl = 'http://www.jahanpay.com/webservice?wsdl';

    /**
     * Address of gate for redirect
     *
     * @var string
     */
    protected $gateUrl = 'http://www.jahanpay.com/pay_invoice/';

    /**
     * Get Gateway Configurations
     */
    private $port_config = [];

    private function get_config(){
        $config_id = $this->config->get('gateway.default_config_id.jahanpay');
        $data = DB::table($this->config->get('gateway.gateway_config.jahanpay'))->where('id', $config_id)->first();
        $this->port_config = array(
            "api"=>$data->api,
            "callback-url"=>$data->callback_url
        );
    }

    public function __construct()
    {
        parent::__construct();
        $this->get_config();
    }

    /**
     * {@inheritdoc}
     */
    public function set($amount)
    {
        $this->amount = ($amount / 10);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function ready()
    {
        $this->sendPayRequest();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function redirect()
    {
        return \Redirect::to($this->gateUrl.$this->refId());
    }

    /**
     * {@inheritdoc}
     */
    public function verify($transaction)
    {
        parent::verify($transaction);

        $this->userPayment();
        $this->verifyPayment();

        return $this;
    }

    /**
     * Sets callback url
     * @param $url
     */
    function setCallback($url)
    {
        $this->callbackUrl = $url;
        return $this;
    }

    /**
     * Gets callback url
     * @return string
     */
    function getCallback()
    {
        if (!$this->callbackUrl)
            $this->callbackUrl = $this->port_config['callback-url'];

        return $this->makeCallback($this->callbackUrl, ['transaction_id' => $this->transactionId()]);
    }

    /**
     * Send pay request to server
     *
     * @return void
     *
     * @throws JahanPayException
     */
    protected function sendPayRequest()
    {
        $this->newTransaction();

        try {
            $soap = new SoapClient($this->serverUrl);
            $response = $soap->requestpayment(
                $this->port_config['api'],
                $this->amount,
                $this->getCallback(),
                $this->transactionId(),
                ''
            );

        } catch(\SoapFault $e) {
            $this->transactionFailed();
            $this->newLog('SoapFault', $e->getMessage());
            throw $e;
        }

        if (intval($response) >= 0) {
            $this->refId = $response;
            $this->transactionSetRefId();
            return true;
        }

        $this->transactionFailed();
        $this->newLog($response, JahanPayException::$errors[$response]);
        throw new JahanPayException($response);
    }

    /**
     * Check user payment
     *
     * @return bool
     *
     * @throws JahanPayException
     */
    protected function userPayment()
    {
        $refId = Request::input('au');

        if ($this->refId() != $refId) {
            $this->transactionFailed();
            $this->newLog(-30, JahanPayException::$errors[-30]);
            throw new JahanPayException(-30);
        }

        return true;
    }

    /**
     * Verify user payment from bank server
     *
     * @return bool
     *
     * @throws JahanPayException
     */
    protected function verifyPayment()
    {
        try {
            $soap = new SoapClient($this->serverUrl);
            $response = $soap->verification(
                $this->port_config['api'],
                $this->amount,
                $this->refId
            );

        } catch(\SoapFault $e) {
            $this->transactionFailed();
            $this->newLog('SoapFault', $e->getMessage());
            throw $e;
        }

        if (intval($response) == 1) {
            $this->transactionSucceed();
            $this->newLog($response, Enum::TRANSACTION_SUCCEED_TEXT);
            return true;
        }

        $this->transactionFailed();
        $this->newLog($response, JahanPayException::$errors[$response]);
        throw new JahanPayException($response);
    }
}
