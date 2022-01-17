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

use craft\helpers\Json;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use percipiolondon\tweetfeed\TweetFeed;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

use Craft;
use craft\base\Component;
use yii\base\Exception;

/**
 * @author    percipiolondon
 * @package   Tweet
 * @since     1.0.0
 */
class TweetService extends Component
{
    // Public Methods
    // =========================================================================

    /*
     * @return mixed
     */
    public function getTweets($amount = 100, $fields = null, $parameters = '')
    {
        //https://developer.twitter.com/en/docs/twitter-api/data-dictionary/object-model/tweet
        $stack = HandlerStack::create();

        if (
            empty(Craft::parseEnv(TweetFeed::$plugin->getSettings()->apiKey)) ||
            empty(Craft::parseEnv(TweetFeed::$plugin->getSettings()->apiKeySecret)) ||
            empty(Craft::parseEnv(TweetFeed::$plugin->getSettings()->token) ) ||
            empty(Craft::parseEnv(TweetFeed::$plugin->getSettings()->tokenSecret)) ||
            empty(Craft::parseEnv(TweetFeed::$plugin->getSettings()->userId))
        ) {
            throw new Exception("Not all keys and tokens are provided in the settings");
        }

        $middleware = new Oauth1([
            'consumer_key'    => Craft::parseEnv(TweetFeed::$plugin->getSettings()->apiKey),
            'consumer_secret' => Craft::parseEnv(TweetFeed::$plugin->getSettings()->apiKeySecret),
            'token'           => Craft::parseEnv(TweetFeed::$plugin->getSettings()->token),
            'token_secret'    => Craft::parseEnv(TweetFeed::$plugin->getSettings()->tokenSecret)
        ]);
        $stack->push($middleware);

        $client = new Client([
            'base_uri' => 'https://api.twitter.com/2/',
            'handler' => $stack,
            'auth' => 'oauth'
        ]);

        $fields = $fields ? ','.$fields : '';
        $userId = Craft::parseEnv(TweetFeed::$plugin->getSettings()->userId);

        $response = $client->get("users/{$userId}/tweets?max_results={$amount}&tweet.fields=entities{$fields}{$parameters}");

        return Json::decodeIfJson($response->getBody()->getContents(), true);
    }
}
