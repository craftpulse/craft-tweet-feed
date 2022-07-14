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

use Craft;
use craft\base\Plugin;
use craft\web\twig\variables\CraftVariable;
use percipiolondon\tweetfeed\models\Settings;
use percipiolondon\tweetfeed\services\TweetService;
use percipiolondon\tweetfeed\twigextensions\TweetExtension;
use percipiolondon\tweetfeed\variables\TweetVariable;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use yii\base\Event;
use yii\base\Exception;

/**
 * Class TweetFeed
 *
 * @author    percipiolondon
 * @package   TweetFeed
 * @since     1.0.0
 *
 * @property  TweetService $tweets
 * @property  Settings $settings
 *
 * @method Settings getSettings()
 */
class TweetFeed extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var TweetFeed
     */
    public static TweetFeed $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public string $schemaVersion = '1.0.0';

    /**
     * @var bool
     */
    public bool $hasCpSettings = true;

    /**
     * @var bool
     */
    public bool $hasCpSection = false;

    // Public Methods
    // =========================================================================


    /**
     * init
     */
    public function init(): void
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function(Event $event) {
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
    /**
     * Creates and returns the model used to store the plugin’s settings.
     *
     * @return Settings
     */
    protected function createSettingsModel(): Settings
    {
        return new Settings();
    }

    /**
     * Returns the rendered settings HTML, which will be inserted into the content
     * block on the settings page.
     *
     * @return string|null The rendered settings HTML
     * @throws Exception
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    protected function settingsHtml(): ?string
    {
        return Craft::$app->view->renderTemplate(
            'tweetfeed/settings',
            [
                'settings' => $this->settings,
            ]
        );
    }
}
