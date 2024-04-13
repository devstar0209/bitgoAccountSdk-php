<?php namespace Bitgo\Api;

use Bitgo\Bitgo;

class Key
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
     * generate key.
     * 
     * @param string|null $encryptedPrv
     * @param string $source backup | bitgo | user
     * @param string $type eth | bitcoin | btc
     * @param JSON $options
     * 
     * @return JSON
     */
    public function create($encryptedPrv='', $source='bitgo', $type='eth', $options=[])
    {
        $params = [
            'coin' => $this->bitgo->getCoin(),
            'encryptedPrv' => $encryptedPrv,
            'type' => $type,
            'enterpriseId' => $this->bitgo->enterpriseId,
            'source' => $source,
            $options
        ];
        return $this->bitgo->request('keys', $params, "POST")->contents();
    }

    /**
     * generate bitgo key.
     * 
     * @param string|null $encryptedPrv
     * @param string $type eth | bitcoin | btc
     * @param JSON $options
     * 
     * @return JSON
     */
    public function bitgo($encryptedPrv='', $type='eth', $options=[])
    {
        $params = [
            'coin' => $this->bitgo->getCoin(),
            'encryptedPrv' => $encryptedPrv,
            'type' => $type,
            'enterpriseId' => $this->bitgo->enterpriseId,
            'source' => 'bitgo',
            $options
        ];
        return $this->bitgo->request('keys', $params, "POST")->contents();
    }

    /**
     * generate backup key.
     * 
     * @param string|null $encryptedPrv
     * @param string $type eth | bitcoin | btc
     * @param JSON $options
     * 
     * @return JSON
     */
    public function backup($encryptedPrv='', $type='eth', $options=[])
    {
        $params = [
            'coin' => $this->bitgo->getCoin(),
            'encryptedPrv' => $encryptedPrv,
            'type' => $type,
            'enterpriseId' => $this->bitgo->enterpriseId,
            'source' => 'backup',
            $options
        ];
        return $this->bitgo->request('keys', $params, "POST")->contents();
    }

    /**
     * generate user key.
     * 
     * @param string|null $encryptedPrv
     * @param string $type eth | bitcoin | btc
     * @param JSON $options
     * 
     * @return JSON
     */
    public function user($encryptedPrv='', $type='eth', $options=[])
    {
        $params = [
            'coin' => $this->bitgo->getCoin(),
            'encryptedPrv' => $encryptedPrv,
            'type' => $type,
            'enterpriseId' => $this->bitgo->enterpriseId,
            'source' => 'user',
            $options
        ];
        return $this->bitgo->request('keys', $params, "POST")->contents();
    }


    /**
     * query a list of all the keys.
     * 
     * 
     * @return array
     */
    public function getAll()
    {
        $params = [
            'coin' => $this->bitgo->getCoin()
        ];
        return $this->bitgo->request('keys', $params)->contents();
    }

    /**
     * query a specific key.
     * 
     * @param string $idOrPub
     * 
     * @return JSON
     */
    public function get($idOrPub)
    {
        $params = [
            'coin' => $this->bitgo->getCoin(),
            'idOrPub' => $idOrPub
        ];
        return $this->bitgo->request('key', $params)->contents();
    }
}