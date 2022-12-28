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
        $this->cookieFix();

        return $this->provider->getAuthorizationUrl($options);
    }

    public function getUserData(ResourceOwnerInterface $user): array
    {
        \assert($user instanceof AppleResourceOwner);

        $data = [
            'id'         => $user->getId(),
            'login'      => $user->getEmail(),
            'email'      => $user->getEmail()
        ];

        // Only update fullname if provided (Apple only sends this on first login)
        $full_name = trim($user->getFirstName() . " " . $user->getLastName());
        if (!empty($full_name)) {
            $data['fullname'] = $full_name;
        }

        return $data;
    }

    /**
     * Fix for Grav's session cookie as secure + lax is not passed along with
     * Apple's non-OAuth2 spec POST callback.  Only unsecure cookie is.
     * This is returned to proper configuration when returning to the site.
     * @return void
     */
    public function cookieFix(): void
    {
        /** @var Session $session */
        $session = Grav::instance()['session'];
        $session->close();
        $session->setOptions(['cookie_samesite' => '']);
        $session->setOptions(['cookie_secure' => false]);
        $session->start();
    }

}
