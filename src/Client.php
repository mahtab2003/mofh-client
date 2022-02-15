<?php 
namespace Mahtab2003\Mofh;
use Mahtab2003\Mofh\Handler\curlHandler;
use Mahtab2003\Mofh\Message\AbstractRequest;
use Mahtab2003\Mofh\Message\AvailabilityRequest;
use Mahtab2003\Mofh\Message\CreateAccountRequest;
use Mahtab2003\Mofh\Message\DeleteAccountRequest;
use Mahtab2003\Mofh\Message\GetUserDomainsRequest;
use Mahtab2003\Mofh\Message\GetDomainUserRequest;
use Mahtab2003\Mofh\Message\PasswordRequest;
use Mahtab2003\Mofh\Message\SuspendRequest;
use Mahtab2003\Mofh\Message\UnsuspendRequest;

class Client
{

	protected $ch;
	protected $parameters;

    public function __construct()
    {
    	$this->ch = new curlHandler;
        $this->initialize();
    }

    public static function create(array $parameters = [])
    {
        $client = new self();
        $client->initialize($parameters);
        return $client;
    }
    
    public function initialize(array $parameters = array())
    {
        $this->parameters = $parameters;
        foreach (array_replace($this->getDefaultParameters(), $parameters) as $key => $value) {
            $this->setParameter($key, $value);
        }

        return $this;
    }

    public function getDefaultParameters()
    {
        return [
            'apiUsername' => '',
            'apiPassword' => '',
            'apiUrl' => 'https://panel.myownfreehost.net/xml-api/',
            'plan' => '',
        ];
    }

    protected function setParameter($key, $value)
    {
        $this->parameters[$key] = $value;

        return $this;
    }

    protected function getParameter($key)
    {
        if (isset($this->parameters[$key])) {
            return $this->parameters[$key];
        } else {
            return null;
        }
    }

     public function setApiUsername($username)
    {
        return $this->setParameter('apiUsername', $username);
    }

    public function getApiUsername()
    {
        return $this->getParameter('apiUsername');
    }

    public function setApiPassword($password)
    {
        return $this->setParameter('apiPassword', $password);
    }

    public function getApiPassword()
    {
        return $this->getParameter('apiPassword');
    }

    public function setPlan($plan)
    {
        return $this->setParameter('plan', $plan);
    }

    public function getPlan()
    {
        return $this->getParameter('plan');
    }

    public function setApiUrl($url)
    {
        return $this->setParameter('apiUrl', $url);
    }

    public function getApiUrl()
    {
        return $this->getParameter('apiUrl');
    }

    protected function createRequest($class, array $parameters)
    {
        $obj = new $class($this->ch);
        return $obj->initialize(array_replace($this->parameters, $parameters));
    }

    public function availability(array $parameters = [])
    {
        return $this->createRequest(AvailabilityRequest::class, $parameters);
    }

    public function createAccount(array $parameters = [])
    {
        return $this->createRequest(CreateAccountRequest::class, $parameters);
    }

    public function suspend(array $parameters = [])
    {
        return $this->createRequest(SuspendRequest::class, $parameters);
    }

    public function unsuspend(array $parameters = [])
    {
        return $this->createRequest(UnsuspendRequest::class, $parameters);
    }

    public function getDomainUser(array $parameters = [])
    {
        return $this->createRequest(GetDomainUserRequest::class, $parameters);
    }

    public function getUserDomains(array $parameters = [])
    {
        return $this->createRequest(GetUserDomainsRequest::class, $parameters);
    }

    public function removeAccount(array $parameters = [])
    {
        return $this->createRequest(DeleteAccountRequest::class, $parameters);
    }
}
?>
