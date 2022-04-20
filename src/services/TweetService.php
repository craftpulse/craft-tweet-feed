<?php
/**
 * Tweet plugin for Craft CMS 3.x
 *
 * Get the latest tweets from a feed
 *
 * @link      https://percipio.london
 * @copyright Copyright (c) 2021 percipiolondon
 */

namespace percipiolondon\tweetfeed\services;

use Craft;
use craft\base\Component;
use craft\helpers\Json;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use percipiolondon\tweetfeed\models\Settings;
use percipiolondon\tweetfeed\TweetFeed;
use yii\base\Exception;

/**
 * @author    percipiolondon
 * @package   Tweet
 * @since     1.0.0
 */

/**
 * @property-read Settings $settings
 * @method Settings getSettings()
 */
class TweetService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * @var Settings
     */
    private Settings $settings;

    public function init(): void
    {
        $this->settings = Tweetfeed::$plugin->getSettings();
    }

    /*
     * @return mixed
     */
    /**
     * @throws Exception
     * @throws GuzzleException
     */
    public function getTweets(int $amount = 100, mixed $fields = null, string $parameters = '')
    {
        //https://developer.twitter.com/en/docs/twitter-api/data-dictionary/object-model/tweet
        $stack = HandlerStack::create();

        if (
            empty(Craft::parseEnv($this->settings->apiKey)) ||
            empty(Craft::parseEnv($this->settings->apiKeySecret)) ||
            empty(Craft::parseEnv($this->settings->token)) ||
            empty(Craft::parseEnv($this->settings->tokenSecret)) ||
            empty(Craft::parseEnv($this->settings->userId))
        ) throw new Exception("Not all keys and tokens are provided in the settings");

        $middleware = new Oauth1([
            'consumer_key' => Craft::parseEnv($this->settings->apiKey),
            'consumer_secret' => Craft::parseEnv($this->settings->apiKeySecret),
            'token' => Craft::parseEnv($this->settings->token),
            'token_secret' => Craft::parseEnv($this->settings->tokenSecret)
        ]);
        $stack->push($middleware);

        $client = new Client([
            'base_uri' => 'https://api.twitter.com/2/',
            'handler' => $stack,
            'auth' => 'oauth',
        ]);

        $fields = $fields ? ',' . $fields : '';
        $userId = Craft::parseEnv($this->settings->userId);

        $response = $client->get("users/{$userId}/tweets?max_results={$amount}&tweet.fields=entities{$fields}{$parameters}");

        return Json::decodeIfJson($response->getBody()->getContents(), true);
    }
}
