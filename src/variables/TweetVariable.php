<?php
/**
 * Tweet plugin for Craft CMS 3.x
 *
 * Get the latest tweets from a feed
 *
 * @link      https://percipio.london
 * @copyright Copyright (c) 2021 percipiolondon
 */

namespace percipiolondon\tweetfeed\variables;

use percipiolondon\tweetfeed\TweetFeed;

use Craft;

/**
 * @author    percipiolondon
 * @package   Tweet
 * @since     1.0.0
 */
class TweetVariable
{
    // Public Methods
    // =========================================================================

    public function tweets($amount = 100, $fields = null, $params = null)
    {
        //The max_results expects a number between 5 and 100
        $count = $amount;

        if($count && $count > 100){
            $count = 100;
        }

        if($count && $count < 5){
            $count = 5;
        }

        $tweets = TweetFeed::$plugin->tweets->getTweets($count, $fields, $params);
        $tweets = array_key_exists('data', $tweets) ? $tweets['data'] : [];

        if($amount && $amount < 5){
            $tweets = array_slice($tweets, 0, $amount);
        }

        return $tweets;
    }
}
