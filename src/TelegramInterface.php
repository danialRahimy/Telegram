<?php

namespace DanialRahimy\Telegram;

interface TelegramInterface 
{
    public function __construct(string $apiKey);

    public function updateApiKey(string $apiKey);

    public function sendTextMessage(string $message, string $to) : array;
    
    public function sendPhoto(string $img, string $to, string $caption = '') : array;
}
