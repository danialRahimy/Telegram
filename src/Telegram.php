<?php

namespace DanialRahimy\Telegram;
use \DanialRahimy\Telegram\Telegram\TelegramInterface;

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
     */
    public function sendTextMessage(string $message, string $to) : array
    {
        $parameters = http_build_query([
            'chat_id' => $to,
            'text' => $message,
            'parse_mode' => 'html'
        ]);
        $url = $this->apiUrlKey . '/sendMessage?' . $parameters;
        $dataJson = $this->curl_get_contents($url);

        return $this->makeOutput($dataJson);
    }

    /**
     * @param string $img
     * @param string $to
     * @param string $caption
     * @return array
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
        $dataJson = $this->curlGetContents($url);

        return $this->makeOutput($dataJson);
    }

    /**
     * @param $url
     * @return string
     */
    protected function curlGetContents($url) : string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    /**
     * @param string $dataJson
     * @return array
     */
    protected function makeOutput(string $dataJson) : array
    {
        $dataArray = json_decode($dataJson, true);

        if (is_array($dataArray))
            $dataArray = [];

        return $dataArray;
    }
}
