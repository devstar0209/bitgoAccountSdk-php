<?php namespace Bitgo;

use GuzzleHttp\Client;
use Bitgo\Response;
use Exception;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class Request
{
    /**
     * Bitgo access
     *
     * @return Bitgo
     */
    private $bitgo;

    /**
     * Guzzle Client
     *
     * @return GuzzleHttp\Client
     */
    private $client;

    /**
     * Start the class()
     *
     */
    public function __construct(Bitgo $bitgo, $timeout = 4)
    {
        $this->bitgo = $bitgo;

        $this->client = new Client([
            'base_uri' => $this->bitgo->getRoot(),
            'timeout'  => $timeout
        ]);
    }

    /**
     * send()
     *
     * Send request
     *
     * @return \Bitgo\Response
     */
    public function send($handle, $params = [], $type = 'GET')
    {
        // build and prepare our full path rul
        $url = $this->prepareUrl($handle, $params);

        // lets track how long it takes for this request
        $seconds = 0;

        try {
            // push request
            $options = [
                'headers' => [
                    'Content-Type' => '*/*',
                    'Accept' => '*/*',
                    'Authorization' => 'Bearer '.$this->bitgo->getAccessToken(),
                ],
                'on_stats' => function (\GuzzleHttp\TransferStats $stats) use (&$seconds) {
                    $seconds = $stats->getTransferTime(); 
                 }
            ];
            if($type == 'GET') $options['query'] = $params;
            else $options['json'] = $params;
            
            $request = $this->client->request($type, $url, $options);
        }
         catch (ClientException  $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $erroObj = json_decode($responseBodyAsString);
            throw new Exception($erroObj->message);
        } catch (RequestException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $erroObj = json_decode($responseBodyAsString);
            throw new Exception($erroObj->message);
        }

        // send and return the request response
        return (new Response($request, $seconds));
    }

    /**
     * prepareUrl()
     *
     * Get and prepare the url
     *
     * @return string
     */
    private function prepareUrl($handle, $segments = [])
    {
        $url = $this->bitgo->getPath($handle);

        foreach($segments as $segment=>$value) {
            if (gettype($value) == 'string') {
                $url = str_replace('{'.$segment.'}', $value, $url);
                $url = str_replace(':'.$segment, $value, $url);
            }
        }

        return $url;
    }
}
