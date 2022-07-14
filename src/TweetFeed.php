<?php
/**
 * Tweet plugin for Craft CMS 3.x
 *
 * Get the latest tweets from a feed
 *
 * @link      https://percipio.london
 * @copyright Copyright (c) 2021 percipiolondon
 */

namespace percipiolondon\tweetfeed;

use percipiolondon\tweetfeed\models\Settings;
use percipiolondon\tweetfeed\services\TweetService;
use percipiolondon\tweetfeed\twigextensions\TweetExtension;
use percipiolondon\tweetfeed\variables\TweetVariable;

use Craft;
use craft\base\Plugin;
use craft\web\twig\variables\CraftVariable;

use yii\base\Event;

/**
 * Class TweetFeed
 *
 * @author    percipiolondon
 * @package   TweetFeed
 * @since     1.0.0
 *
 * @property  TweetService $tweet
 */
class TweetFeed extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var TweetFeed
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    /**
     * @var bool
     */
    public $hasCpSettings = true;

    /**
     * @var bool
     */
    public $hasCpSection = false;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('tweetfeed', TweetVariable::class);
            }
        );

        if (Craft::$app->request->getIsSiteRequest()) {
            $tweetExtension = new TweetExtension();
            Craft::$app->view->registerTwigExtension($tweetExtension);
        }

        $this->setComponents([
            'tweets' => TweetService::class,
        ]);

        Craft::info(
            Craft::t(
                'tweetfeed',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================
    protected function createSettingsModel()
    {
        return new Settings();
    }

    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'tweetfeed/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
