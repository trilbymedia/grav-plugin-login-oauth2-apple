<?php
namespace Grav\Plugin\Login\OAuth2\Providers;

use Grav\Common\Grav;

class AppleProvider extends BaseProvider
{
    protected $name = 'Apple';
    protected $classname = 'League\\OAuth2\\Client\\Provider\\Apple';
    protected $config;

    /** @var Apple */
    protected $provider;

    public function initProvider(array $options)
    {
        $this->config = Grav::instance()['config'];
        xdebug_break();
        $keyFileId = $this->config->get('plugins.login-oauth2-apple.keyFileId');
        $keyPath = $this->config->get('plugins.login-oauth2-apple.keyFilePath');
        $realKeyPath = Grav::instance()['locator']->findResource($keyPath);
        $realKeyPath .= '/AuthKey_' . $keyFileId . '.p8';

        $options += [
            'clientId'      => $this->config->get('plugins.login-oauth2-apple.client_id'),
            'teamId'        => $this->config->get('plugins.login-oauth2-apple.team_id'),
            'keyFileId'     => $keyFileId,
            'keyFilePath'   => $realKeyPath
        ];

        parent::initProvider($options);
    }

    public function getAuthorizationUrl()
    {
        $options = ['state' => $this->state];
        $options['scope'] = $this->config->get('plugins.login-oauth2-apple.options.scope');

        return $this->provider->getAuthorizationUrl($options);
    }

    public function getUserData($user)
    {
        return [
            'id'         => $user->getId(),
            'login'      => $user->getAttribute('name'),
            'fullname'   => $user->getAttribute('name'),
            'email'      => $user->getEmail()
        ];
    }
}
