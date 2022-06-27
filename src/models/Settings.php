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
     * @var string|null
     */
    public string|null $apiKey = null;

    /**
     * @var string|null
     */
    public string|null $apiKeySecret = null;

    /**
     * @var string|null
     */
    public string|null $token = null;

    /**
     * @var string
     */
    public string|null $tokenSecret = null;

    /**
     * @var string|null
     */
    public string|null $userId = null;


    /**
     * @return array
     */
    protected function defineRules(): array
    {
        return [
            [['apiKey', 'apiKeySecret', 'token', 'tokenSecret', 'userId'], 'required'],
            [['apiKey', 'apiKeySecret', 'token', 'tokenSecret', 'userId'], 'string', 'max' => 255],
        ];
    }


    /**
     * @return array
     */
    public function behaviors(): array
    {
        // Keep any parent behaviors
        $behaviors = parent::behaviors();

        return array_merge($behaviors, [
            'parser' => [
                'class' => EnvAttributeParserBehavior::class,
                'attributes' => ['apiKey', 'apiKeySecret', 'token', 'tokenSecret', 'userId'],
            ],
        ]);
    }
}
