<?php

namespace percipiolondon\tweetfeed\models;

use craft\base\Model;
use craft\behaviors\EnvAttributeParserBehavior;

/**
 * percipiolondon\tweetfeed\models\Settings
 *
 * @property string $apiKey
 */
class Settings extends Model
{
    /**
     * @var string
     */
    public string $apiKey;

    /**
     * @var string
     */
    public string $apiKeySecret;

    /**
     * @var string
     */
    public string $token;

    /**
     * @var string
     */
    public string $tokenSecret;

    /**
     * @var string
     */
    public string $userId;

    /**
     * @inheritdoc
     */
    protected function defineRules(): array
    {
        return [
            [['apiKey', 'apiKeySecret', 'token', 'tokenSecret', 'userId'], 'required'],
            [['apiKey', 'apiKeySecret', 'token', 'tokenSecret', 'userId'], 'string', 'max' => 255],
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
