# MyOwnFreeHost API Client
An API client to use the free hosting system from [MyOwnFreeHost](https://myownfreehost.net).

**IMPORTANT: THIS LIBRARY IS AIMED AT EXPERIENCED PHP DEVELOPERS. Experience with object-oriented PHP and Composer is required. If you can't use oo-PHP and Composer, don't bother with this library.**

## Installation

This package is best installed through Composer:

```bash
composer require mahtab2003/mofh-client
```

## Usage
Before you can get started, you need to get the API credentials from MyOwnFreeHost. Login to the [reseller panel](https://panel.myownfreehost.net), go to API -> Setup WHM API -> select the domain you want to configure. Copy the API Username and API password and set your own IP address as the Allowed IP Address (the IP address of your computer, server, or wherever you want to use this API client).

The MyOwnFreeHost API exposes the following methods. The available parameters are listed below.
- createAccount
    - username: A unique, 8 character identifier of the account.
    - password: A password to login to the control panel, FTP and databases.
    - domain: A domain name to create the account. Can be a subdomain or a custom domain.
    - email: The email address of the user.
    - plan: The name of the hosting plan to create the account on. Requires a hosting package to be configured through MyOwnFreeHost.
- suspend
    - username: The unique, 8 character identifier of the account.
    - reason: A string with information about why you are suspending the account.
    - linked: If true, related accounts will be suspended as well.
- unsuspend
    - username: The unique, 8 character identifier of the account.
- password
    - username: The unique, 8 character identifier of the account.
    - password: The new password to set for the account.
- availability
    - domain: The domain name or subdomain to check.
- getUserDomains
    - username: The vistaPanel login username (e.g. abcd_12345678).
- getDomainUser
    - domain: The domain name to search for.
- removeAccount
    - userame: The unique, 8 character identifier of the account

### Example

```php
use \Mahtab2003\Mofh\Client;

$client = Client::create([
    'apiUsername' => 'your_api_username',
    'apiPassword' => 'your_api_password',
    'plan' => 'my_plan', // Optional, you can define it here or define it with the createAccount call.
]);

// Create a request object to create the request.
$request = $client->createAccount([
    'username' => 'abcdefgh', // A unique, 8 character identifier of the account.
    'password' => 'password123', // A password to login to the control panel, FTP and databases.
    'domain' => 'userdomain.example.com', // Can be a subdomain or a custom domain.
    'email' => 'user@example.com', // The email address of the user.
    'plan' => 'my_plan', // Optional, you can submit a hosting plan here or with the Client instantiation.
]);

// Send the API request and keep the response.
$response = $request->send();

// Check whether the request was successful.
if ($response->isSuccessful()) {
   echo 'You can login as: ' . $response->getVpUsername();
} else {
   echo 'Failed to create account: ' . $response->getMessage();
}
```

## License

©️ Copyright 2022 NXTS Developer. Code released under the MPL-2.0 License.
This build is inspired by InfinityFreeHosting/mofh-client.