<?php
namespace Grav\Plugin\Login\OAuth2\Providers;

use Grav\Common\Grav;
use Grav\Common\Session;
use League\OAuth2\Client\Provider\Apple;
use League\OAuth2\Client\Provider\AppleResourceOwner;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class AppleProvider extends BaseProvider
{
    protected $name = 'Apple';
    protected $classname = Apple::class;
    protected $temp_cookie_name = 'siwa-temp-cookie';

    public function initProvider(array $options): void
    {
        $config = Grav::instance()['config'];
        $keyFileId = $config->get('plugins.login-oauth2-apple.keyFileId');
        $keyPath = $config->get('plugins.login-oauth2-apple.keyFilePath');
        $realKeyPath = Grav::instance()['locator']->findResource($keyPath);
        $realKeyPath .= '/AuthKey_' . $keyFileId . '.p8';

        $options += [
            'clientId'      => $config->get('plugins.login-oauth2-apple.client_id'),
            'teamId'        => $config->get('plugins.login-oauth2-apple.team_id'),
            'keyFileId'     => $keyFileId,
            'keyFilePath'   => $realKeyPath
        ];

        parent::initProvider($options);
    }

    public function getAuthorizationUrl()
    {
        $options = ['state' => $this->getState()];
        $options['scope'] = $this->config->get('plugins.login-oauth2-apple.options.scope');

        // workaround for Apple's crappy OAuth2 implementation that uses a POST callback that doesn't forward lax-cookie
        $this->setTempCookie($options);

        return $this->provider->getAuthorizationUrl($options);
    }

    public function getState(): string
    {
        return 'APPLE__' . $this->state;
    }


    public function getUserData(ResourceOwnerInterface $user): array
    {
        \assert($user instanceof AppleResourceOwner);

        $full_name = trim($user->getFirstName() . " " . $user->getLastName());

        $data = [
            'id'         => $user->getId(),
            'login'      => $user->getEmail(),
            'email'      => $user->getEmail()
        ];

        if (!empty($full_name)) {
            $data['fullname'] = $full_name;
        }

        return $data;
    }

    public static function getCallbackUri(string $admin = 'auto'): string
    {
        $callback_uri = parent::getCallbackUri($admin);
        $callback_uri .= '?XDEBUG_SESSION_START=1';
        return $callback_uri;
    }

    public function setTempCookie(Array $options): void
    {
        // Create short-lived cookie to get around Apple's crappy OAuth2 implementation
        $temp_data = [
            'state' => $options['state'],
            'redirect_after_login' => '/en/bookmarks', //testing only
        ];

        setcookie($this->temp_cookie_name, json_encode($temp_data), [
            'expires' => time() + 1800,
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'None',
        ]);
    }

    public function getTempCookieData(): array
    {
        $temp_data = json_decode($_COOKIE[$this->temp_cookie_name] ?? [], true);
        unset($_COOKIE[$this->temp_cookie_name]);
        setcookie($this->temp_cookie_name, null, -1, '/');
        return $temp_data;
    }
}
