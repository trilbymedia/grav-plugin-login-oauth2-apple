<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use Grav\Common\Utils;
use Grav\Plugin\Login\OAuth2\ProviderFactory;
use Grav\Plugin\Login\OAuth2\Providers\AppleProvider;
use RocketTheme\Toolbox\Event\Event;

/**
 * Class LoginOAuth2ApplePlugin
 * @package Grav\Plugin
 */
class LoginOAuth2ApplePlugin extends Plugin
{
    /**
     * @return array
     *
     * The getSubscribedEvents() gives the core a list of events
     *     that the plugin wants to listen to. The key of each
     *     array section is the event that the plugin listens to
     *     and the value (in the form of an array) contains the
     *     callable (or function) as well as the priority. The
     *     higher the number the higher the priority.
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => [
                ['autoload', 100000],
                ['onPluginsInitialized', 0]
            ],
            'onTwigLoader'              => ['onTwigLoader', 0],
            'onTwigSiteVariables'       => ['onTwigSiteVariables', 0],
            'onTwigTemplatePaths'       => ['onTwigTemplatePaths', 0],
        ];
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized()
    {
        if (isset($this->grav['oauth2'])) {
            $options = $this->config->get('plugins.login-oauth2-apple');
            $this->grav['oauth2']->addProvider('apple', $options);
        } else {
            $this->grav['messages']->add('oauth2-apple plugin requires oauth2 plugin but it appears to not be installed or enabled', 'error');
        }

        $this->enable([
            'onTask.callback.oauth2'    => ['loginCallback', 100],
            ]
        );

    }

    /**
     * [onPluginsInitialized:100000] Composer autoload.
     *
     * @return ClassLoader
     */
    public function autoload()
    {
        return require __DIR__ . '/vendor/autoload.php';
    }

    public function onTwigLoader()
    {
        $media_paths = $this->grav['locator']->findResources('plugins://login-oauth2-apple/media');
        foreach(array_reverse($media_paths) as $images_path) {
            $this->grav['twig']->addPath($images_path, 'oauth2-media');
        }
    }

    /**
     * [onTwigTemplatePaths] Add twig paths to plugin templates.
     */
    public function onTwigTemplatePaths()
    {
        $twig = $this->grav['twig'];
        $twig->twig_paths[] = __DIR__ . '/templates';
    }

    public function onTwigSiteVariables()
    {
        // add CSS for frontend if required
        if (!$this->isAdmin() && $this->config->get('plugins.login-oauth2-apple.built_in_css')) {
            $this->grav['assets']->add('plugin://login-oauth2-apple/css/login-oauth2-apple.css');
        }
    }

    /**
     * Worksaround to handle callback being called outside user's session
     *
     * @param Event $e
     * @return void
     */
    public function loginCallback(Event $e)
    {
        $state = $_POST['state'] ?? null;
        $code = $_POST['code'] ?? null;
        if ($code && $state && Utils::startsWith($state, 'APPLE__')) {
            $oauth2 = $this->grav['oauth2'];
            $provider_name = 'apple';

            /** @var AppleProvider $provider */
            $provider = ProviderFactory::create($provider_name, $oauth2->getProviderOptions($provider_name));
            $temp_data = $provider->getTempCookieData();
            $temp_state = $temp_data['state'] ?? null;
            $temp_redirect = $temp_data['redirect_after_login'] ?? null;

            if ($temp_state === $state) {
                $session = $this->grav['session'];
                $session->oauth2_provider = $provider_name;
                $session->oauth2_state = $state;
                $session->oauth2_redirect = $temp_redirect;
            }
        }
    }
}
