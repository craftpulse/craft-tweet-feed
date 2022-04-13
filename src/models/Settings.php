<?php

namespace percipiolondon\tweetfeed\models;

use craft\base\Model;
use craft\behaviors\EnvAttributeParserBehavior;

class Settings extends Model
{
    public string $apiKey;
    public string $apiKeySecret;
    public string $token;
    public string $tokenSecret;
    public int $userId;

    public function rules(): array
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
            ],
        ];
    }
}
