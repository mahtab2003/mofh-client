<?php
namespace Mahtab2003\Mofh\Message;

class PasswordRequest extends AbstractRequest
{
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($password)
    {
        return $this->setParameter('password', $password);
    }

    public function sendData($data)
    {
        $httpResponse = $this->sendRequest('passwd', $data);

        return $this->response = new PasswordResponse($this, $httpResponse);
    }

    public function getData()
    {
        $this->validate('apiUsername', 'apiPassword', 'apiUrl', 'username', 'password');

        return [
            'api_user' => $this->getApiUsername(),
            'api_key' => $this->getApiPassword(),
            'user' => $this->getUsername(),
            'pass' => $this->getPassword(),
        ];
    }
}