<?php 
namespace Mahtab2003\Mofh\Message;
use Mahtab2003\Mofh\Exception\InvalidRequestException;
use Mahtab2003\Mofh\Exception\ConnectionException;

abstract class AbstractRequest
{
	protected $ch;
    protected $parameters;
    protected $response;

    public function __construct($ch)
    {
        $this->ch = $ch;
        $this->initialize();
    }

    public function initialize(array $parameters = array())
    {
        if (null !== $this->response) {
            throw new InvalidRequestException('Request cannot be modified after it has been sent!');
        }
        $this->parameters = $parameters;
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

    protected function setParameter($key, $value)
    {
        if (null !== $this->response) {
            throw new InvalidRequestException('Request cannot be modified after it has been sent!');
        }

        $this->parameters[$key] = $value;

        return $this;
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

    public function setUsername($username)
    {
        return $this->setParameter('username', $username);
    }

    public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function setApiUrl($url)
    {
        return $this->setParameter('apiUrl', $url);
    }

    public function getApiUrl()
    {
        return $this->getParameter('apiUrl');
    }

    public function validate()
    {
        foreach (func_get_args() as $key) {
            $value = $this->getParameter($key);
            if (! isset($value)) {
                throw new InvalidRequestException("The {$key} parameter is required");
            }
        }
    }

    public function send()
    {
        $data = $this->getData();
        return $this->sendData($data);
    }

    protected function sendRequest($function, array $parameters)
    {
        $this->ch->prepare($this->getApiUrl() . $function, 'POST', $parameters);
        $this->ch->auth($this->getApiUsername(),$this->getApiPassword());
        $this->ch->verifyPeer(false);
        $data = $this->ch->run();
        if($this->ch->getResponseCode() == 200)
        {
            return $data;
        }
        else
        {
            throw new ConnectionException("Unable to connect to host at ".$this->getApiUrl(), 1);
        }
    }

    abstract public function sendData($data);
    abstract public function getData();
}
?>
