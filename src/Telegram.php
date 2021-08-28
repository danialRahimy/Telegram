<?php

namespace DanialRahimy\Telegram;
use DanialRahimy\Telegram\Telegram\TelegramInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Telegram implements TelegramInterface
{
    protected string $apiKey;
    protected string $apiUrlKeyRaw = 'https://api.telegram.org';
    protected string $apiUrlKey;

    public function __construct(string $apiKey)
    {
        $this->updateApiKey($apiKey);
    }

    /**
     * @param string $apiKey
     */
    public function updateApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->apiUrlKey = $this->apiUrlKeyRaw . '/bot' . $apiKey;
    }

    /**
     * @param string $message
     * @param string $to
     * @return array
     * @throws GuzzleException
     */
    public function sendTextMessage(string $message, string $to) : array
    {
        $parameters = http_build_query([
            'chat_id' => $to,
            'text' => $message,
            'parse_mode' => 'html'
        ]);
        $url = $this->apiUrlKey . '/sendMessage?' . $parameters;
        $dataJson = $this->do($url);

        return $this->makeOutput($dataJson);
    }

    /**
     * @param string $img
     * @param string $to
     * @param string $caption
     * @return array
     * @throws GuzzleException
     */
    public function sendPhoto(string $img, string $to, string $caption = '') : array
    {
        $parameters = http_build_query([
            'chat_id' => $to,
            'photo' => $img,
            'caption' => $caption,
            'parse_mode' => 'html'
        ]);
        $url = $this->apiUrlKey . '/sendPhoto?' . $parameters;
        $dataJson = $this->do($url);

        return $this->makeOutput($dataJson);
    }

    /**
     * @param $url
     * @return string
     * @throws GuzzleException
     */
    protected function do($url) : string
    {
        $client = new Client();
        $response = $client->get($url);

        return $response->getBody();
    }

    /**
     * @param string $dataJson
     * @return array
     */
    protected function makeOutput(string $dataJson) : array
    {
        $dataArray = json_decode($dataJson, true);

        if (!is_array($dataArray))
            $dataArray = [];

        return $dataArray;
    }
}
