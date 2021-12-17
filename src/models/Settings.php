<?php

namespace percipiolondon\tweetfeed\models;

use craft\base\Model;

class Settings extends Model
{
    public $apiKey;
    public $apiKeySecret;
    public $token;
    public $tokenSecret;
    public $userId;

    public function rules()
    {
        return [
            [['apiKey', 'apiKeySecret', 'token', 'tokenSecret', 'userId'], 'required'],
        ];
    }
}