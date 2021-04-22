<?php

namespace DanialRahimy\Telegram;

use DanialRahimy\Telegram\TelegramInterface;

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
        $url = $this->apiUrlKey . "/sendMessage?chat_id=" . $to . "&text=" . urlencode($message) . "&parse_mode=html";
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