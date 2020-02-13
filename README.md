# Login O Auth2 Apple Plugin

**This README.md file should be modified to describe the features, installation, configuration, and general usage of this plugin.**

The **Login O Auth2 Apple** Plugin is for [Grav CMS](http://github.com/getgrav/grav). OAuth2 Provider for Apple

## Installation

Installing the Login O Auth2 Apple plugin can be done in one of two ways. The GPM (Grav Package Manager) installation method enables you to quickly and easily install the plugin with a simple terminal command, while the manual method enables you to do so via a zip file.

### GPM Installation (Preferred)

The simplest way to install this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm) through your system's terminal (also called the command line).  From the root of your Grav install type:

    bin/gpm install login-oauth2-apple

This will install the Login O Auth2 Apple plugin into your `/user/plugins` directory within Grav. Its files can be found under `/your/site/grav/user/plugins/login-oauth2-apple`.

### Manual Installation

To install this plugin, just download the zip version of this repository and unzip it under `/your/site/grav/user/plugins`. Then, rename the folder to `login-oauth2-apple`. You can find these files on [GitHub](https://github.com/trilbymedia/grav-plugin-login-oauth2-apple) or via [GetGrav.org](http://getgrav.org/downloads/plugins#extras).

You should now have all the plugin files under

    /your/site/grav/user/plugins/login-oauth2-apple
	
> NOTE: This plugin is a modular component for Grav which requires [Grav](http://github.com/getgrav/grav) and the [Error](https://github.com/getgrav/grav-plugin-error) and [Problems](https://github.com/getgrav/grav-plugin-problems) to operate.

### Admin Plugin

If you use the admin plugin, you can install directly through the admin plugin by browsing the `Plugins` tab and clicking on the `Add` button.

## Configuration

Before configuring this plugin, you should copy the `user/plugins/login-oauth2-apple/login-oauth2-apple.yaml` to `user/config/plugins/login-oauth2-apple.yaml` and only edit that copy.

Here is the default configuration and an explanation of available options:

```yaml
enabled: true
```

Note that if you use the admin plugin, a file with your configuration, and named login-oauth2-apple.yaml will be saved in the `user/config/plugins/` folder once the configuration is saved in the admin.

## Obtain Certificates / IDs / Keys

There is a good guide [here](https://developer.okta.com/blog/2019/06/04/what-the-heck-is-sign-in-with-apple) about how to obtain step-by-step the necessary ids/keys for the Apple Login.

Below a quick summary of all the steps necessary:

1. Log into developer.apple.com
2. head to Account -> Certificates, IDs & Profiles
3. Create a new Identifier:
    1. Description: Grav OAuth 2
    2. Bundle ID: org.getgrav.oauth2.djamil (explicit)
    3. Check "Sign In with Apple" from the list
    4. Configure and pick "Enable as a primary App ID"
    5. Register
4. Still in the Identifier tab. Switch to Services IDs from the top right dropdown
    1. Register a Service ID
    2. Select "Services IDs" radio
    3. Add a description (ie, your site name)
    4. Pick a an Identifier (this will be your Client ID, ie: org.getgrav.oauth2.djamil.client)
    5. Enable Sign In With Apple
    6. Click Configure
        1. Add your domain site by following instructions for verification. You will be required to download a certificate to prove you are the owner of the site
        2. Add the callback URL (ie, http://yourdomain/grav/task:callback.oauth2)
5. Go under Keys on the sidebar
6. Create a Key
    1. Key Name: Grav OAuth 2
    2. Select Sign in with Apple
    3. Click on Configure on the far right and select the App ID previously created: org.getgrav.oauth2.djamil
    4. Save and Register
7. Follow the directions. Make sure you download the key and you place it under user/data/oauth2/apple/
    1. Make sure you backup this key, you will not be able to download it again.
    2. Do not rename the key, place it in the grav user/data location as is


## Known Issues

This is still a WIP and not fully working. I am unable to get this working in Chrome, works fine in Safari. I am also unable to switch AppleID as well as getting back the full name.

Common error returned:

```
invalid_request
No AppPlatform or Primary app for the web application
```

Not advised to be used in production yet.

## Credits

This plugin is made possible thanks to the oauth2-apple integration by [patrickbussmann/oauth2-apple](https://github.com/patrickbussmann/oauth2-apple)

## To Do

- [ ] Future plans, if any

