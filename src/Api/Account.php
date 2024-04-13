<?php namespace Bitgo\Api;

use Bitgo\Bitgo;

class Account
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
     * Create an account with coin.
     * This will create a bitgo trading account for the end user.
     * 
     * @param string $label
     * @param string $network eth | bitcoin | btc
     * @param string $encryptedPrv
     * @param JSON $options
     * 
     * @return JSON
     */
    public function create($label='', $network='eth', $encryptedPrv='', $options=[])
    {
        $bitgoKeyresult = $this->bitgo->key->bitgo($encryptedPrv, $network, $options);
        $userKeyresult = $this->bitgo->key->user($encryptedPrv, $network, $options);
        $backupKeyresult = $this->bitgo->key->backup($encryptedPrv, $network, $options);
        $keys[] = $bitgoKeyresult['id'];
        $keys[] = $userKeyresult['id'];
        $keys[] = $backupKeyresult['id'];

        $params = [
            'coin' => $this->bitgo->getCoin(),
            'enterpriseId' => $this->bitgo->enterpriseId,
            'label' => $label,
            'type' => 'trading',
            "m"=> 1,
            "n"=> 1,
            "keys"=> $keys,
            $options
        ];
        return $this->bitgo->wallet->create($params);
    }

    /**
     * Get balance information about a single trading account.
     * 
     * @param string $accountId
     * 
     * @return array
     */
    public function balances($accountId)
    {
        $result = $this->bitgo->request('account_balances', ['accountId' => $accountId], "GET")->contents();
        return $result['data'];
    }

    /**
     * Get the list of trading accounts that the current user belongs to.
     * 
     * @param string $accountId
     * 
     * @return array
     */
    public function getAll()
    {
        $result = $this->bitgo->request('account_balances')->contents();
        return $result['data'];
    }

    /**
     * Get a link token from Plaid to securely connect and fetch bank account information.
     * After logging into Plaid, you receive a token from Plaid that you must pass to BitGo in the next step.
     * 
     * @return string
     */
    public function getPlaidLinkToken()
    {
        $result = $this->bitgo->request('plaid_link_token')->contents();
        return $result['link_token'];
    }

    /**
     * Pass the Plaid token to BitGo.
     * 
     * @param string $publicToken
     * 
     * @return string
     */
    public function postPlaidPublicToken($publicToken)
    {
        $param = [
            'public_token' => $publicToken
        ];
        $result = $this->bitgo->request('plaid_link_token', $param, 'POST')->contents();
        return $result['status'];
    }

}