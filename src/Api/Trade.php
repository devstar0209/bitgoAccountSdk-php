<?php namespace Bitgo\Api;

use Bitgo\Bitgo;

class Trade
{
    /**
     * @var \Bitgo\Bitgo
     */
    protected $bitgo;

    /**
     * Construct
     */
    public function __construct(Bitgo $Bitgo)
    {
        $this->bitgo = $Bitgo;
    }

    /**
     * Create an order.
     * 
     * @param string $accountId
     * @param string $asset
     * @param string $quantity
     * @param string $counterAsset
     * @param string $type market | limit | twap
     * @param string $side buy | sell
     * @param JSON $options
     * 
     * @return JSON
     */
    public function createOrder($accountId, $asset, $quantity, $counterAsset, $type='market', $side='buy', $options=[])
    {
        $params = [
            "accountId"=> $accountId,
            "type"=> $type,
            "product"=> "$asset-$counterAsset",
            "side"=> $side,
            "quantity"=> $quantity,
            "quantityCurrency"=> $side == 'buy' ? $counterAsset : $asset,
            $options
        ];
        return $this->bitgo->request('orders', $params, "POST")->contents();
    }

    /**
     * Lists trades from the trading account. This will include trades that have not yet settled.
     * 
     * @param string $accountId
     * @param JSON $params
     * 
     * @return JSON
     */
    public function getAll($accountId, $params=[])
    {
        $params['accountId'] = $accountId;
        $result = $this->bitgo->request('trades', $params, "GET")->contents();
        return $result['data'];
    }

    /**
     * Get a single order by order id.
     * 
     * @param string $accountId
     * @param string $orderId
     * 
     * @return JSON
     */
    public function getOrder($accountId, $orderId)
    {
        $params['accountId'] = $accountId;
        $params['orderId'] = $orderId;
        return $this->bitgo->request('order', $params, "GET")->contents();
    }

    /**
     * Lists all orders from the given trading account.
     * 
     * @param string $accountId
     * @param string $status pending_open | open | completed | pending_cancel | canceled | error | scheduled
     * @param JSON $params
     * 
     * @return JSON
     */
    public function getOrders($accountId, $status='', $params)
    {
        $params['accountId'] = $accountId;
        if($status !== '')
            $params['status'] = $status;
        $result = $this->bitgo->request('orders', $params, "GET")->contents();
        return $result['data'];
    }

    /**
     * cancel an order.
     * 
     * @param string $accountId
     * @param string $orderId
     * 
     * @return JSON
     */
    public function cancel($accountId, $orderId)
    {
        $params['accountId'] = $accountId;
        $params['orderId'] = $orderId;
        return $this->bitgo->request('cancel_order', $params, "PUT")->contents();
    }

    /**
     * Gets a list of all available products.
     * 
     * @param string $accountId
     * 
     * @return JSON
     */
    public function getProducts($accountId)
    {
        $result = $this->bitgo->request('order_products', ['accountId' => $accountId], "GET")->contents();
        return $result['data'];
    }

}