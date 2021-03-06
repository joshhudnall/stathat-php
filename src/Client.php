<?php namespace DoSomething\StatHat;

use GuzzleHttp\Client as GuzzleClient;
use Exception;

class Client {

    protected $config;

    protected $client;

    public function __construct($config = [])
    {
        $this->config = $config;

        $this->client = new GuzzleClient([
            'base_url' => 'https://api.stathat.com/',
            'defaults' => [
                'future' => true,
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ]
            ],
        ]);
    }

    /**
     * Increment a counter using the classic API.
     * @see https://www.stathat.com/manual/send#classic
     *
     * @param $stat_key     string - Private key identifying the stat
     * @param $count        int - Number you want to count
     * @param $ts           Unix timestamp - Optional timestamp
     * @return \GuzzleHttp\Message\FutureResponse
     * @throws \Exception
     */
    public function count($stat_key, $count = 1, $ts = '')
    {
        if(!isset($this->config['user_key'])) throw new Exception('StatHat user key not set.');
        if($this->config['debug']) return;

        return $this->client->post('c', ['body' => ['ukey' => $this->config['user_key'], 'key' => $stat_key, 'count' => $count, 't' => $ts]]);
    }

    /**
     * Send a value using the classic API.
     * @see https://www.stathat.com/manual/send#classic
     *
     * @param $stat_key     string - Private key identifying the stat
     * @param $value        int - Value you want to track
     * @param $ts           Unix timestamp - Optional timestamp
     * @return \GuzzleHttp\Message\FutureResponse
     * @throws \Exception
     */
    public function value($stat_key, $value, $ts = '')
    {
        if(!isset($this->config['user_key'])) throw new Exception('StatHat user key not set.');
        if($this->config['debug']) return;

        return $this->client->post('v', ['body' => ['ukey' => $this->config['user_key'], 'key' => $stat_key, 'value' => $value, 't' => $ts]]);
    }

    /**
     * Increment a counter using the EZ API.
     * @see https://www.stathat.com/manual/send#ez
     *
     * @param $stat         string - Unique stat name
     * @param $count        int - Number you want to count
     * @param $ts           Unix timestamp - Optional timestamp
     * @return \GuzzleHttp\Message\FutureResponse
     * @throws \Exception
     */
    public function ezCount($stat, $count = 1, $ts = '')
    {
        if(!isset($this->config['ez_key'])) throw new Exception('StatHat EZ key not set.');
        if($this->config['debug']) return;

        return $this->client->post('ez', ['body' => ['ezkey' => $this->config['ez_key'], 'stat' => $stat, 'count' => $count, 't' => $ts]]);
    }

    /**
     * Send a value using the EZ API.
     * @see https://www.stathat.com/manual/send#ez
     *
     * @param $stat         string - Unique stat name
     * @param $value        int - Value you want to track
     * @param $ts           Unix timestamp - Optional timestamp
     * @return \GuzzleHttp\Message\FutureResponse
     * @throws \Exception
     */
    public function ezValue($stat, $value, $ts = '')
    {
        if(!isset($this->config['ez_key'])) throw new Exception('StatHat EZ key not set.');
        if($this->config['debug']) return;

        return $this->client->post('ez', ['body' => ['ezkey' => $this->config['ez_key'], 'stat' => $stat, 'value' => $value, 't' => $ts]]);
    }

}
