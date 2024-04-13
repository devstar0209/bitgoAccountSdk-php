<?php namespace Bitgo;

use Bitgo\Api\Account;
use Bitgo\Api\Key;
use Bitgo\Api\Trade;
use Bitgo\Api\Wallet;
use Bitgo\Request;

class Bitgo
{

    /**
     * API accessToken
     *
     * @var string
     */
    private $accessToken;
    
    /**
     * API version
     *
     * @var string
     */
    private $version = 'v2';

    /**
     * Use test account (true/false)
     *
     * @var bool
     */
    private $test;

    /**
     * API test Path
     *
     * @var array
     */
    private $apiTestPath = 'https://app.bitgo-test.com/api/';

    /**
     * API Real Path
     *
     * @var array
     */
    private $apiPath = 'https://app.bitgo.com/api/';

    /**
     *
     * @var string default: eth
     */
    private $coin="eth";

    

    /**
     * API Paths
     *
     * @var array
     */
    private $paths = [
        "keys"     => "v2/{coin}/key",
        "key"     => "v2/{coin}/key/{idOrPub}",
        "wallets"     => "v2/{coin}/wallet",
        "wallet"     => "v2/{coin}/wallet/{walletId}",
        "plaid_link_token"     => "accounts/v1/enterprise/{enterpriseId}/plaid/link",
        "trades"     => "prime/trading/v1/accounts/{accountId}/trades",
        "orders"     => "prime/trading/v1/accounts/{accountId}/orders",
        "order"     => "prime/trading/v1/accounts/{accountId}/orders/{orderId}",
        "order_products"     => "prime/trading/v1/accounts/{accountId}/products",
        "cancel_order"     => "prime/trading/v1/accounts/{accountId}/orders/{orderId}/cancel",
        "account_balances"     => "prime/trading/v1/accounts/{accountId}/balances",
        "accounts"     => "prime/trading/v1/accounts",
    ];

    /**
     *
     * @var string|null
     */
    public $enterpriseId;

    /**
     * @var \Bitgo\Api\Account
     */
    public $account;

    /**
     * @var \Bitgo\Api\Key
     */
    public $key;
    
    /**
     * @var \Bitgo\Api\Wallet
     */
    public $wallet;


    /**
     * @var \Bitgo\Api\Trade
     */
    public $trade;
    

    /**
     * Set Bitgo 
     *
     */
    public function __construct($accessToken, $enterpriseId=null, $test = false)
    {
        $this->setAccessToken($accessToken);
        $this->test = $test;
        $this->enterpriseId = $enterpriseId;

        $this->account = (new Account($this));
        $this->key = (new Key($this));
        $this->wallet = (new Wallet($this));
        $this->trade = (new Trade($this));
    }

    /**
     * setAccessToken()
     *
     * @return self
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * getAccessToken()
     *
     * @return array
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function coin($coin)
    {
        $this->coin = $coin;
        return $this;
    }

    public function getCoin()
    {
        return $this->coin;
    }

    /**
     * getRoot()
     *
     * @return string
     */
    public function getRoot()
    {
        if ($this->test===true) {
            return $this->apiTestPath;
        }

        return $this->apiPath;
    }

    /**
     * getPath()
     *
     * @return string
     */
    public function getPath($handle)
    {
        return isset($this->paths[$handle]) ? $this->paths[$handle] : false;
    }
    
    /**
     * request()
     *
     * @return \Bitgo\Response
     */
    public function request($handle, $params = [], $type = 'GET')
    {
        return (new Request($this))->send($handle, $params, $type);
    }

    /**
     * account()
     *
     * @return \Bitgo\Account\Account
     */
    public function account()
    {
        return (new Account($this));
    }
}
