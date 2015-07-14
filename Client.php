<?php

/**
 * Class Client
 * @package AlexanderEmelyanov\HasOffers
 *
 * @author Alexander Emelyanov
 * @date 14jul2015
 * @place Moscow, Russia
 */

namespace AlexanderEmelyanov\HasOffers;

use GuzzleHttp\Client as GuzzleClient;

class Client
{


    /**
     * HTTP Headers.
     *
     * @var array
     */
    public $headers = ['User-Agent' => 'Alexander Emelyanov / Has Offers Client'];

    /**
     * Configure this URL using data from your HasOffers instance
     * @var string
     */
    public $goalsTrackingUrl = 'http://something.go2cloud.org/aff_goal?a=lsr';

    /**
     * HTTP Client.
     *
     * @var \GuzzleHttp\Client
     */
    private $httpClient;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->httpClient = new GuzzleClient([
            'defaults' => [
                'headers' => $this->headers,
            ],
        ]);
    }

    /**
     * Handle the response.
     * @param object $response
     * @return object
     * @throws \Exception
     */
    private function handleResponse($response)
    {
        $statusCode = $response->getStatusCode();
        $body = $response->getBody();
        if ($statusCode >= 200 && $statusCode < 300) {
            return true;
        }
        throw new \Exception($body, $statusCode);
    }

    /**
     * Send get request to Postback URL for goal reaching
     * Example for postback url of HasOffers goal:
     *     http://algomonster.go2cloud.org/aff_goal?a=lsr&goal_id=2&transaction_id=TRANSACTION_ID
     *
     * @param array $params Should be consist of 'goal_id' and 'transaction_id'
     * @return object
     */
    public function trackGoal(array $params){
        $url = $this->goalsTrackingUrl . '&' . http_build_query($params);
        /** @var \GuzzleHttp\Message\Response $response */
        $response = $this->httpClient->get($url);
        return $this->handleResponse($response);
    }

}