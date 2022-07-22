<?php
/**
 * Tweet plugin for Craft CMS 3.x
 *
 * Get the latest tweets from a feed
 *
 * @link      https://percipio.london
 * @copyright Copyright (c) 2021 percipiolondon
 */

namespace percipiolondon\tweetfeed\twigextensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class TweetExtension
 *
 * @package percipiolondon\tweetfeed\twigextensions
 */
class TweetExtension extends AbstractExtension
{
    /**
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('urlify', array($this, 'urlify'))
        ];
    }

    /**
     * @param array $tweet
     * @return array|mixed|string|string[]
     */
    public function urlify(array $tweet)
    {
        $tweetText = $tweet['text'] ?? '';

        // convert urls to anchors
        if($tweet['entities']['urls'] ?? null) {
            foreach($this->_unique_array($tweet['entities']['urls'], 'url') as $url) {
                $url = $url['url'];
                $href = '<a href="'.$url.'" target="_blank" rel="nofollow noopener">'.$url.'</a>';
                $tweetText =  str_replace($url, $href, $tweetText);
            }
        }

        // convert hashtags to anchors
        if($tweet['entities']['hashtags'] ?? null) {
            foreach($this->_unique_array($tweet['entities']['hashtags'], 'tag') as $hashtags) {
                $hashtags = $hashtags['tag'];
                $href = '<a href="https://twitter.com/search?q='.$hashtags.'&src=typed_query" target="_blank" rel="nofollow noopener">#'.$hashtags.'</a>';
                $tweetText =  str_replace('#'.$hashtags, $href, $tweetText);
            }
        }

        return $tweetText;
    }

    /**
     * @param $tweets
     * @param $key
     * @return array
     */
    private function _unique_array($tweets, $key): array
    {
        $result = array();
        $i = 0;
        $key_array = array();

        foreach($tweets as $val) {
            if(array_key_exists($key, $val)) {
                if (!in_array($val[$key], $key_array, true)) {
                    $key_array[$i] = $val[$key];
                    $result[$i] = $val;
                }
                $i++;
            }
        }
        return $result;
    }
}