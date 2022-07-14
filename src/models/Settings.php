<?php

namespace percipiolondon\tweetfeed\models;

use craft\base\Model;
use craft\behaviors\EnvAttributeParserBehavior;

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
            [['apiKey', 'apiKeySecret', 'token', 'tokenSecret'], 'string', 'max' => 255],
            [['userId'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return [
            'parser' => [
                'class' => EnvAttributeParserBehavior::class,
                'attributes' => ['apiKey', 'apiKeySecret', 'token', 'tokenSecret', 'userId'],
            ]
        ];
    }
}