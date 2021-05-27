<?php

namespace DanialRahimy\Telegram;

class Telegram implements TelegramInterface
{

    protected $apiKey;
    protected $apiUrlKeyRaw = 'https://api.telegram.org';
    protected $apiUrlKey;

    public function __construct(string $apiKey)
    {
        $this->updateApiKey($apiKey);
    }

    public function updateApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->apiUrlKey = $this->apiUrlKeyRaw . '/bot' . $apiKey;
    }

    public function sendTextMessage(string $message, string $to) : array
    {
        $parameters = http_build_query([
            'chat_id' => $to,
            'text' => $message,
            'parse_mode' => 'html'
        ]);
        $url = $this->apiUrlKey . '/sendMessage?' . $parameters;
        $dataJson = file_get_contents($url);

        return $this->makeOutput($dataJson);
    }

    public function sendPhoto(string $img, string $to, string $caption = '') : array
    {
        $parameters = http_build_query([
            'chat_id' => $to,
            'photo' => $img,
            'caption' => $caption,
            'parse_mode' => 'html'
        ]);
        $url = $this->apiUrlKey . '/sendPhoto?' . $parameters;
        $dataJson = file_get_contents($url);

        return $this->makeOutput($dataJson);
    }

    protected function makeOutput(string $dataJson) : array
    {
        $dataArray = json_decode($dataJson, true);

        if (is_array($dataArray))
            $dataArray = [];

        return $dataArray;
    }
}
