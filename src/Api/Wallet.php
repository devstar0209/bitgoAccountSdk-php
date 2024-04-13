<?php namespace Bitgo\Api;

use Bitgo\Bitgo;

class Wallet
{
    /**
     * @var \Bitgo\Bitgo
     */
    protected $bitgo;

    /**
     * Construct
     */
    public function __construct(Bitgo $bitgo)
    {
        $this->bitgo = $bitgo;
    }

    /**
     * Create an wallet.
     * 
     * @param JSON $params
     * 
     * @return JSON
     */
    public function create($params)
    {
        return $this->bitgo->request('wallets', $params, "POST")->contents();
    }

    /**
     * query a list of all the wallets.
     * 
     * @param JSON $params
     * 
     * @return array
     */
    public function getAll($params=[])
    {
        return $this->bitgo->request('wallets', $params)->contents();
    }

    /**
     * query a specific wallet.
     * 
     * @param string $walletId
     * 
     * @return JSON
     */
    public function get($walletId)
    {
        $params = [
            'coin' => $this->bitgo->getCoin(),
            'walletId' => $walletId
        ];

        return $this->bitgo->request('wallet', $params)->contents();
    }

    /**
     * updates wallet information.
     * 
     * @param string $wallet_id
     * @param JSON $params
     * 
     * @return JSON
     */
    public function update($wallet_id, $params=[])
    {
        $params['wallet_id'] = $wallet_id;
        return $this->bitgo->request('wallet', $params, "PATCH")->contents();
    }

    /**
     * closes an active wallet.
     * 
     * @param string $wallet_id
     * 
     * @return JSON
     */
    public function delete($wallet_id)
    {
        return $this->bitgo->request('wallet', ['wallet_id' => $wallet_id], "DELETE")->contents();
    }
}